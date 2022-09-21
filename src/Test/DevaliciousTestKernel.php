<?php

namespace TallmanCode\DevaliciousBundle\Test;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use TallmanCode\DevaliciousBundle\TallmanCodeDevaliciousBundle;

class DevaliciousTestKernel extends Kernel implements CompilerPassInterface
{
    use MicroKernelTrait;

    public function process(ContainerBuilder $container)
    {
        $defn = $container->getDefinition('devalicious.commands.make_bundle');
        $defn->setPublic(true);
    }

    protected function configureRoutes(RoutingConfigurator $routes)
    {
    }

    protected function configureRouting(RoutingConfigurator $routes)
    {
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->loadFromExtension('framework', [
            'secret' => 123,
            'router' => [
                'utf8' => true,
            ],
            'http_method_override' => false,
        ]);
    }


    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new TallmanCodeDevaliciousBundle()
        ];
    }
}