<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ChoicesBundle\EventListener\DataContainer;

use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Contao\CoreBundle\Framework\FrameworkAwareTrait;
use HeimrichHannot\FilterBundle\Filter\Type\TextConcatType;
use HeimrichHannot\FilterBundle\Filter\Type\TextType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class FilterConfigElementListener implements FrameworkAwareInterface, ContainerAwareInterface
{
    use FrameworkAwareTrait;
    use ContainerAwareTrait;

    public function addChoicesFieldToTypePalettes(array &$dca)
    {
        $config = $this->container->getParameter('huh.filter');

        if (!isset($config['filter']['types']))
        {
            return;
        }

        $filterType = null;
        $choiceFields = [];

        foreach ($config['filter']['types'] as $type)
        {
            if ($type['type'] === 'choice')
            {
                $choiceFields[] = $type['name'];
            }
        }

        foreach ($choiceFields as $choiceField)
        {
            $dca['palettes'][$choiceField] = str_replace(';{visualization_legend}', ',skipChoicesSupport;{visualization_legend}', $dca['palettes'][$choiceField]);
        }

        $fields = [
            TextConcatType::TYPE,
            TextType::TYPE
        ];

        foreach ($fields as $field)
        {
            $dca['palettes'][$field] = str_replace(';{visualization_legend}', ',addChoicesSupport;{visualization_legend}', $dca['palettes'][$field]);
        }
    }
}