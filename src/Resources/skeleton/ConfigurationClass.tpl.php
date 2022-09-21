<?php echo "<?php\n"; ?>
namespace <?php echo $bundleNameSpace; ?>\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('<?php echo $configName; ?>');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->end();

        return $treeBuilder;
    }
}
