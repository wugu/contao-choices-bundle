<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ChoicesBundle\EventListener;


use Contao\DataContainer;
use Contao\PageModel;
use HeimrichHannot\ChoicesBundle\Asset\FrontendAsset;
use HeimrichHannot\ChoicesBundle\Event\CustomizeChoicesOptionsEvent;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GetAttributesFromDcaListener
{
    private $pageParents = null;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var FrontendAsset
     */
    private $frontendAsset;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var bool
     */
    protected $closed = false;

    /**
     * GetAttributesFromDcaListener constructor.
     * @param null $pageParents
     */
    public function __construct(ContainerInterface $container, FrontendAsset $frontendAsset, EventDispatcherInterface $eventDispatcher)
    {
        $this->container = $container;
        $this->frontendAsset = $frontendAsset;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function close()
    {
        $this->closed = true;
    }

    public function open()
    {
        $this->closed = false;
    }


    /**
     * @Hook("getAttributesFromDca")
     *
     * @param array $attributes
     * @param DataContainer $dc
     * @return array
     */
    public function onGetAttributesFromDca(array $attributes, $dc = null): array
    {
        if ($this->closed || !$this->container->get('huh.utils.container')->isFrontend() || !in_array($attributes['type'], ['select', 'text']))
        {
            $this->open();
            return $attributes;
        }

        $this->getPageWithParents();

        if(null !== $this->pageParents)
        {
            if ($attributes['type'] === 'select')
            {
                $property = $this->container->get('huh.utils.dca')->getOverridableProperty('useChoicesForSelect', $this->pageParents);
                if (true === (bool) $property)
                {
                    $this->frontendAsset->addFrontendAssets();
                    $attributes['data-choices'] = 1;
                }
            }
            if ($attributes['type'] === 'text')
            {
                $property = $this->container->get('huh.utils.dca')->getOverridableProperty('useChoicesForText', $this->pageParents);
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
        $customOptions = $this->container->get('huh.choices.manager.choices_manager')->getOptionsAsArray($customOptions);
        $event = $this->eventDispatcher->dispatch(CustomizeChoicesOptionsEvent::NAME, new CustomizeChoicesOptionsEvent($customOptions, $attributes, $dc));


        $attributes['data-choices-options'] = json_encode($event->getChoicesOptions());


        return $attributes;
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
}