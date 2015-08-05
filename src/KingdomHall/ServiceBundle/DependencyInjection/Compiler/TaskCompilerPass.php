<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 8/5/15
 * Time: 10:46 AM
 */

namespace KingdomHall\ServiceBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TaskCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container the container
     *
     * @api
     *
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('evoucher.services.cron')) {
            return;
        }

        $definition = $container->getDefinition('evoucher.services.cron');

        $taggedServices = $container->findTaggedServiceIds('evoucher.task');

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addTaskService',
                array (new Reference($id))
            );
        }
    }
}