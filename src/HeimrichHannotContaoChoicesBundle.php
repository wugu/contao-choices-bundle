<?php

namespace HeimrichHannot\ChoicesBundle;

use HeimrichHannot\ChoicesBundle\DependencyInjection\ChoicesExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotContaoChoicesBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new ChoicesExtension();
    }
}
