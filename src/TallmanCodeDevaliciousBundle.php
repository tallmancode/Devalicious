<?php
namespace TallmanCode\DevaliciousBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TallmanCode\DevaliciousBundle\DependencyInjection\TallmanCodeDevaliciousExtension;

class TallmanCodeDevaliciousBundle extends Bundle
{
    /**
    * Overridden to allow for the custom extension alias.
    */
    public function getContainerExtension() : ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new TallmanCodeDevaliciousExtension();
        }
        return $this->extension;
    }
}
