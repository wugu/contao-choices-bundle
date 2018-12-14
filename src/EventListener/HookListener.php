<?php

namespace HeimrichHannot\ChoicesBundle\EventListener;

use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Contao\CoreBundle\Framework\FrameworkAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class HookListener implements FrameworkAwareInterface, ContainerAwareInterface
{
    use FrameworkAwareTrait;
    use ContainerAwareTrait;

    public function getAttributesFromDca($attributes, $dca)
    {
//        $attributes['data-choices'] = 1;

        return $attributes;
    }
}