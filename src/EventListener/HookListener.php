<?php

namespace HeimrichHannot\ChoicesBundle\EventListener;

class HookListener
{
    public function onGetAttributesFromDca($attributes, $dca)
    {
//        $attributes['data-choices'] = 1;

        return $attributes;
    }
}