<?php

namespace KingdomHall\TaskBundle;

use KingdomHall\TaskBundle\DependencyInjection\Compiler\TaskCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KingdomHallTaskBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TaskCompilerPass());
    }
}
