<?php

namespace HeimrichHannot\ChoicesBundle\EventListener;

use Contao\DataContainer;
use Contao\PageModel;
use HeimrichHannot\ChoicesBundle\Asset\FrontendAsset;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HookListener
{
    /**
     * @var ContainerInterface
     */
    private $container;
    private $pageParents = null;
    /**
     * @var bool
     */
    private $isFrontend;
    /**
     * @var FrontendAsset
     */
    private $frontendAsset;

    public function __construct(ContainerInterface $container, FrontendAsset $frontendAsset)
    {
        $this->container = $container;
        $this->dcaUtil = $container->get('huh.utils.dca');
        $this->isFrontend = $container->get('huh.utils.container')->isFrontend();
        $this->frontendAsset = $frontendAsset;
    }

    protected function getPageWithParents()
    {
        /** @var PageModel $objPage */
        global $objPage;

        if (null === $this->pageParents && null !== $objPage)
        {
            $this->pageParents = $this->container->get('huh.utils.model')->findParentsRecursively('pid', 'tl_page', $objPage);
            $this->pageParents[] = $objPage;
        }

        return $this->pageParents;
    }

    /**
     * getAttributesFromDca Hook
     *
     * @param array $attributes
     * @param DataContainer $dca
     * @return array
     */
    public function onGetAttributesFromDca($attributes, $dca)
    {
        if (!$this->isFrontend || !in_array($attributes['type'], ['select', 'text']))
        {
            return $attributes;
        }

        $this->getPageWithParents();

        if(null !== $this->pageParents)
        {
            if ($attributes['type'] === 'select')
            {
                $property = $this->dcaUtil->getOverridableProperty('useChoicesForSelect', $this->pageParents);
                if (true === (bool) $property)
                {
                    $this->frontendAsset->addFrontendAssets();
                    $attributes['data-choices'] = 1;
                }
            }
            if ($attributes['type'] === 'text')
            {
                $property = $this->dcaUtil->getOverridableProperty('useChoicesForText', $this->pageParents);
                if (true === (bool) $property)
                {
                    $this->frontendAsset->addFrontendAssets();
                    $attributes['data-choices'] = 1;
                }
            }
        }

        $customOptions = [];
        if (isset($attributes['choicesOptions']) && is_array($attributes['choicesOptions'])) {
            $customOptions = $attributes['choicesOptions'];
        }

        $attributes['data-choices-options'] = json_encode($this->container->get('huh.choices.manager.choices_manager')->getOptionsAsArray($customOptions));

        return $attributes;
    }
}