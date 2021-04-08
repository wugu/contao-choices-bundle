<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ChoicesBundle\Asset;


use HeimrichHannot\UtilsBundle\Container\ContainerUtil;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;

class FrontendAsset implements ServiceSubscriberInterface
{
    /**
     * @var ContainerUtil
     */
    protected ContainerUtil $containerUtil;
    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * FrontendAsset constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container, ContainerUtil $containerUtil)
    {
        $this->container = $container;
        $this->containerUtil = $containerUtil;
    }

    public function addFrontendAssets(): void
    {
        if (!$this->containerUtil->isFrontend()) {
            return;
        }

        if ($this->container->has("HeimrichHannot\EncoreBundle\Asset\FrontendAsset")) {
            $this->container->get(\HeimrichHannot\EncoreBundle\Asset\FrontendAsset::class)->addActiveEntrypoint('contao-choices-bundle');
            $this->container->get(\HeimrichHannot\EncoreBundle\Asset\FrontendAsset::class)->addActiveEntrypoint('contao-choices-bundle-theme');
        }

        $GLOBALS['TL_CSS']['contao-choices-bundle'] = 'bundles/heimrichhannotcontaochoices/assets/choices.css|static';
        $GLOBALS['TL_JAVASCRIPT']['contao-choices-bundle--library'] = 'bundles/heimrichhannotcontaochoices/assets/choices.js|static';
        $GLOBALS['TL_JAVASCRIPT']['contao-choices-bundle'] = 'bundles/heimrichhannotcontaochoices/assets/contao-choices-bundle.js|static';
    }

    public static function getSubscribedServices()
    {
        return [
            '?HeimrichHannot\EncoreBundle\Asset\FrontendAsset',
        ];
    }
}