<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ChoicesBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use HeimrichHannot\ChoicesBundle\HeimrichHannotContaoChoicesBundle;
use HeimrichHannot\EncoreBundle\HeimrichHannotContaoEncoreBundle;
use HeimrichHannot\FilterBundle\HeimrichHannotContaoFilterBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        $loadAfter = [ContaoCoreBundle::class];

        if (class_exists('HeimrichHannot\EncoreBundle\HeimrichHannotContaoEncoreBundle')) {
            $loadAfter[] = HeimrichHannotContaoEncoreBundle::class;
        }

        if (class_exists('HeimrichHannot\FilterBundle\HeimrichHannotContaoFilterBundle')) {
            $loadAfter[] = HeimrichHannotContaoFilterBundle::class;
        }

        return [
            BundleConfig::create(HeimrichHannotContaoChoicesBundle::class)->setLoadAfter($loadAfter),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig)
    {
        $loader->load('@HeimrichHannotContaoChoicesBundle/Resources/config/services.yml');

        if (class_exists('HeimrichHannot\EncoreBundle\HeimrichHannotContaoEncoreBundle')) {
            $loader->load('@HeimrichHannotContaoChoicesBundle/Resources/config/config_encore.yml');
        }
    }
}
