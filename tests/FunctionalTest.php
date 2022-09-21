<?php
namespace TallmanCode\DevaliciousBundle\Tests;

use PHPUnit\Framework\TestCase;
use TallmanCode\DevaliciousBundle\Command\MakeBundleCommand;
use TallmanCode\DevaliciousBundle\Test\DevaliciousTestKernel;

class FunctionalTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new DevaliciousTestKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();
        $makeBundleCommand = $container->get('devalicious.commands.make_bundle');
        $this->assertInstanceOf(MakeBundleCommand::class, $makeBundleCommand);
    }
}