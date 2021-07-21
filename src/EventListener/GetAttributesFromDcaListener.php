<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
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
    /**
     * @var bool
     */
    protected $closed = false;
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
     * GetAttributesFromDcaListener constructor.
     *
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
     * @param DataContainer $dc
     */
    public function onGetAttributesFromDca(array $attributes, $dc = null): array
    {
        if ($this->closed || !$this->container->get('huh.utils.container')->isFrontend() || !\in_array($attributes['type'], ['select', 'text'])) {
            $this->open();

            return $attributes;
        }

        $customOptions = [];

        if (isset($attributes['choicesOptions']) && \is_array($attributes['choicesOptions'])) {
            $customOptions = $attributes['choicesOptions'];
        }
        $customOptions = $this->container->get('huh.choices.manager.choices_manager')->getOptionsAsArray($customOptions);

        $this->getPageWithParents();

        if (null !== $this->pageParents) {
            if ('select' === $attributes['type']) {
                $property = $this->container->get('huh.utils.dca')->getOverridableProperty('useChoicesForSelect', $this->pageParents);

                if (true === (bool) $property) {
                    $this->frontendAsset->addFrontendAssets();
                    $customOptions['enable'] = true;
                }
            }

            if ('text' === $attributes['type']) {
                $property = $this->container->get('huh.utils.dca')->getOverridableProperty('useChoicesForText', $this->pageParents);

                if (true === (bool) $property) {
                    $this->frontendAsset->addFrontendAssets();
                    $customOptions['enable'] = true;
                }
            }
        }

        $event = $this->eventDispatcher->dispatch(CustomizeChoicesOptionsEvent::NAME, new CustomizeChoicesOptionsEvent($customOptions, $attributes, $dc));

        $attributes['data-choices'] = (int) $event->isChoicesEnabled();
        $attributes['data-choices-options'] = json_encode($event->getChoicesOptions());

        return $attributes;
    }

    protected function getPageWithParents()
    {
        /* @var PageModel $objPage */
        global $objPage;

        if (null === $this->pageParents && null !== $objPage) {
            $this->pageParents = $this->container->get('huh.utils.model')->findParentsRecursively('pid', 'tl_page', $objPage);
            $this->pageParents[] = $objPage;
        }

        return $this->pageParents;
    }
}
