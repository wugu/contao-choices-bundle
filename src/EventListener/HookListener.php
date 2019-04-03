<?php

namespace HeimrichHannot\ChoicesBundle\EventListener;

use Contao\DataContainer;
use Contao\PageModel;
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

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->dcaUtil = $container->get('huh.utils.dca');
        $this->isFrontend = $container->get('huh.utils.container')->isFrontend();
    }

    protected function getPageParents()
    {
        if (null === $this->pageParents)
        {
            /** @var PageModel $objPage */
            global $objPage;

            $this->pageParents = $this->container->get('huh.utils.model')->findParentsRecursively('pid', 'tl_page', $objPage);
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

        if ($attributes['type'] === 'select')
        {
            $property = $this->dcaUtil->getOverridableProperty('useChoicesForSelect', $this->getPageParents());
            if (true === (bool) $property)
            {
                $attributes['data-choices'] = 1;
            }
        }
        if ($attributes['type'] === 'text')
        {
            $property = $this->dcaUtil->getOverridableProperty('useChoicesForText', $this->getPageParents());
            if (true === (bool) $property)
            {
                $attributes['data-choices'] = 1;
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