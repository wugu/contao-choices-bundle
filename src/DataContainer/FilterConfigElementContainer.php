<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ChoicesBundle\DataContainer;

use HeimrichHannot\FilterBundle\Filter\Type\TextConcatType;
use HeimrichHannot\FilterBundle\Filter\Type\TextType;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FilterConfigElementContainer
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function addChoicesFieldToTypePalettes(array &$dca)
    {
        $config = $this->container->getParameter('huh.filter');

        if (!isset($config['filter']['types'])) {
            return;
        }

        $filterType = null;
        $choiceFields = [];

        foreach ($config['filter']['types'] as $type) {
            if ('choice' === $type['type']) {
                $choiceFields[] = $type['name'];
            }
        }

        foreach ($choiceFields as $choiceField) {
            $dca['palettes'][$choiceField] = str_replace(';{visualization_legend}', ',skipChoicesSupport;{visualization_legend}', $dca['palettes'][$choiceField]);
        }

        $fields = [
            TextConcatType::TYPE,
            TextType::TYPE,
        ];

        foreach ($fields as $field) {
            $dca['palettes'][$field] = str_replace(';{visualization_legend}', ',addChoicesSupport;{visualization_legend}', $dca['palettes'][$field]);
        }
    }
}
