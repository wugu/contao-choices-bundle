<?php

namespace HeimrichHannot\ChoicesBundle\EventListener;

use Contao\System;
use HeimrichHannot\FilterBundle\Event\AdjustFilterOptionsEvent;

class AdjustFilterOptionsEventListener
{
    public function onAdjustFilterOptions(AdjustFilterOptionsEvent $event)
    {
        $filter = $event->getConfig()->getFilter();
        $table = $filter['dataContainer'];

        System::getContainer()->get('huh.utils.dca')->loadDc($table);

        $dca = &$GLOBALS['TL_DCA'][$table];

        $element = $event->getElement();

        $config = System::getContainer()->getParameter('huh.filter');

        if (!isset($config['filter']['types']))
        {
            return;
        }

        $filterType = null;

        foreach ($config['filter']['types'] as $type)
        {
            if ($type['name'] === $element->type)
            {
                $filterType = $type['type'];
                break;
            }
        }

        if (!$filterType)
        {
            return;
        }

        // select fields are choice'd by default, others not
        switch ($filterType)
        {
            case 'choice':
                if ($element->skipChoicesSupport)
                {
                    return;
                }
                break;
            default:
                if (!$element->addChoicesSupport)
                {
                    return;
                }
                break;
        }

        $options = $event->getOptions();

        // try to get options from dca
        if ($element->field && isset($dca['fields'][$element->field]['eval']['choicesOptions']))
        {
            $choicesOptions = System::getContainer()->get('huh.choices.manager.choices_manager')->getOptionsAsArray(
                $dca['fields'][$element->field]['eval']['choicesOptions']
            );
        }
        else
        {
            $choicesOptions = System::getContainer()->get('huh.choices.manager.choices_manager')->getOptionsAsArray();
        }

        $options['attr']['data-choices'] = '1';
        $options['attr']['data-choices-options'] = json_encode($choicesOptions);

        $event->setOptions($options);
    }
}