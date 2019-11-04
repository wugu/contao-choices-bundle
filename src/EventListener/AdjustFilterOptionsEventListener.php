<?php

namespace HeimrichHannot\ChoicesBundle\EventListener;

use HeimrichHannot\ChoicesBundle\Asset\FrontendAsset;
use HeimrichHannot\FilterBundle\Event\AdjustFilterOptionsEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AdjustFilterOptionsEventListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var FrontendAsset
     */
    private $frontendAsset;

    public function __construct(ContainerInterface $container, FrontendAsset $frontendAsset)
    {
        $this->container = $container;
        $this->frontendAsset = $frontendAsset;
    }


    public function onAdjustFilterOptions(AdjustFilterOptionsEvent $event)
    {
        $filter = $event->getConfig()->getFilter();
        $table = $filter['dataContainer'];

        $this->container->get('huh.utils.dca')->loadDc($table);

        $dca = &$GLOBALS['TL_DCA'][$table];

        $element = $event->getElement();

        $config = $this->container->getParameter('huh.filter');

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

        $this->frontendAsset->addFrontendAssets();

        $options = $event->getOptions();

        $choicesOptions = $this->container->get('huh.choices.manager.choices_manager')->getOptionsAsArray([], $table, $element->field ?: '');
        $options['attr']['data-choices'] = '1';
        $options['attr']['data-choices-options'] = json_encode($choicesOptions);

        $event->setOptions($options);
    }
}