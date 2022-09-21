<?php echo "<?php\n"; ?>

namespace <?php echo $bundleNameSpace; ?>\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class <?php echo $bundleExtensionName; ?> extends Extension
{
    /**
    * @throws Exception
    */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
        $container,
        new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');
    }
}
