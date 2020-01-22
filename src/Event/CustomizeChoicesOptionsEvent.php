<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ChoicesBundle\Event;


use Contao\DataContainer;
use HeimrichHannot\FilterBundle\Event\AdjustFilterOptionsEvent;
use Symfony\Component\EventDispatcher\Event;

class CustomizeChoicesOptionsEvent extends Event
{

    const NAME = 'huh.choices.customize_choices_options';
    /**
     * @var array
     */
    private $choicesOptions;
    /**
     * @var array
     */
    private $fieldAttributes;
    /**
     * @var DataContainer|null
     */
    private $dc;
    /**
     * @var AdjustFilterOptionsEvent
     */
    protected $adjustFilterOptionsEvent = null;

    /**
     * CustomizeChoicesOptionsEvent constructor.
     * @param array $choicesOptions
     * @param array $fieldAttributes
     * @param DataContainer|null $dc
     */
    public function __construct(array $choicesOptions, array $fieldAttributes, ?DataContainer $dc)
    {
        $this->choicesOptions = $choicesOptions;
        $this->fieldAttributes = $fieldAttributes;
        $this->dc = $dc;
    }

    public function setAdjustFilterOptionsEvent(AdjustFilterOptionsEvent $adjustFilterOptionsEvent)
    {
        $this->adjustFilterOptionsEvent = $adjustFilterOptionsEvent;
    }

    /**
     * @return AdjustFilterOptionsEvent
     */
    public function getAdjustFilterOptionsEvent(): ?AdjustFilterOptionsEvent
    {
        return $this->adjustFilterOptionsEvent;
    }

    /**
     * Return if field is a filter bundle field or not
     *
     * @return bool
     */
    public function isFilterField(): bool
    {
        return (null === $this->adjustFilterOptionsEvent);
    }




    /**
     * @return array
     */
    public function getChoicesOptions(): array
    {
        return $this->choicesOptions;
    }

    /**
     * @return array
     */
    public function getFieldAttributes(): array
    {
        return $this->fieldAttributes;
    }

    /**
     * @return DataContainer
     */
    public function getDc(): ?DataContainer
    {
        return $this->dc;
    }

    /**
     * @param array $choicesOptions
     */
    public function setChoicesOptions(array $choicesOptions): void
    {
        $this->choicesOptions = $choicesOptions;
    }
}