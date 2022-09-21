<?php echo "<?php\n"; ?>
namespace <?php echo $bundleNameSpace; ?>;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use <?php echo $bundleNameSpace; ?>\DependencyInjection\<?php echo $bundleExtensionName; ?>;

class <?php echo $bundleClassName; ?> extends Bundle
{
    /**
    * Overridden to allow for the custom extension alias.
    */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new <?php echo $bundleExtensionName; ?>();
        }
        return $this->extension;
    }
}
