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


use Symfony\Component\DependencyInjection\ContainerInterface;

class FrontendAsset
{
    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * FrontendAsset constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function addFrontendAssets()
    {
        if (!$this->container->get('huh.utils.container')->isFrontend()) {
            return;
        }

        if ($this->container->has('huh.encore.asset.frontend')) {
            $this->container->get('huh.encore.asset.frontend')->addActiveEntrypoint('contao-choices-bundle');
            $this->container->get('huh.encore.asset.frontend')->addActiveEntrypoint('contao-choices-bundle-theme');
        }

        $GLOBALS['TL_CSS']['contao-choices-bundle'] = 'bundles/heimrichhannotcontaochoices/assets/choices.css|static';
        $GLOBALS['TL_JAVASCRIPT']['contao-choices-bundle--library'] = 'bundles/heimrichhannotcontaochoices/assets/choices.js|static';
        $GLOBALS['TL_JAVASCRIPT']['contao-choices-bundle'] = 'bundles/heimrichhannotcontaochoices/assets/contao-choices-bundle.js|static';
    }
}