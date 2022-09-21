<?php

namespace TallmanCode\DevaliciousBundle\Generator;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class MakeBundleGenerator
{
    private Filesystem $filesystem;
    private string $projectDir;
    private KernelInterface $kernel;

    public function __construct(Filesystem $filesystem, KernelInterface $kernel)
    {
        $this->filesystem = $filesystem;
        $this->projectDir = $kernel->getProjectDir();
        $this->kernel = $kernel;
    }

    public function addBundle($params)
    {
        $bundlesArray = include $this->projectDir.'\config\bundles.php';
        $bundlesArray[$params['bundleNameSpace'].'\\'.$params['bundleClassName']] = ['all' => true];
        $content = $this->buildContents($bundlesArray);
        file_put_contents($this->projectDir.'\config\bundles.php', $content);
    }

    private function buildContents(array $bundles): string
    {
        $contents = "<?php\n\nreturn [\n";
        foreach ($bundles as $class => $envs) {
            $contents .= "    $class::class => [";
            foreach ($envs as $env => $value) {
                $booleanValue = var_export($value, true);
                $contents .= "'$env' => $booleanValue, ";
            }
            $contents = substr($contents, 0, -2)."],\n";
        }
        $contents .= "];\n";

        return $contents;
    }

    public function generateNameSpace(string $vendor, string $bundleName)
    {
        return $vendor.'\\'.$bundleName;
    }

    public function generateComposer($params, $template = 'Composer.tpl.php')
    {
        $templatePath = $this->getTemplate($template);
        $content = $this->parseTemplate($templatePath, $params['composer']);
        $this->filesystem->dumpFile($this->projectDir.'\lib\\'.$params['bundleNameInput'].'\composer.json', $content);
    }

    public function generateExtension($params, $template = 'BundleExtension.tpl.php')
    {
        $templatePath = $this->getTemplate($template);
        $content = $this->parseTemplate($templatePath, $params);
        $this->filesystem->dumpFile($this->projectDir.'\lib\\'.$params['bundleNameInput'].'\src\DependencyInjection\\'.$params['bundleExtensionName'].'.php', $content);
    }

    public function generateConfigurationClass($params, $template = 'ConfigurationClass.tpl.php')
    {
        $templatePath = $this->getTemplate($template);
        $content = $this->parseTemplate($templatePath, $params);
        $this->filesystem->dumpFile($this->projectDir.'\lib\\'.$params['bundleNameInput'].'\src\DependencyInjection\Configuration.php', $content);
    }

    public function generateConfigurationYaml($params, $template = 'ConfigYaml.tpl.php')
    {
        $templatePath = $this->getTemplate($template);
        $content = $this->parseTemplate($templatePath, $params);
        $this->filesystem->dumpFile($this->projectDir.'\config\packages\\'.$params['configName'].'.yaml', $content);
    }

    public function generateBundleClass($params, $template = 'BundleClass.tpl.php')
    {
        $templatePath = $this->getTemplate($template);
        $content = $this->parseTemplate($templatePath, $params);
        $this->filesystem->dumpFile($this->projectDir.'\lib\\'.$params['bundleNameInput'].'\src\\'.$params['bundleClassName'].'.php', $content);
    }

    public function generateServiceClass($params, $template = 'ServiceClass.tpl.php')
    {
        $templatePath = $this->getTemplate($template);
        $content = $this->parseTemplate($templatePath, $params);
        $this->filesystem->dumpFile($this->projectDir.'\lib\\'.$params['bundleNameInput'].'\src\\'.$params['serviceClassName'].'.php', $content);
    }

    public function generateServices($params, $template = 'ServiceXml.tpl.php')
    {
        $templatePath = $this->getTemplate($template);
        $content = $this->parseTemplate($templatePath, $params);
        $this->filesystem->dumpFile($this->projectDir.'\lib\\'.$params['bundleNameInput'].'\src\Resources\config\services.xml', $content);
    }

    private function getTemplate($templateName)
    {
        return $this->kernel->locateResource('@TallmanCodeDevaliciousBundle').'/Resources/skeleton/'.$templateName;
    }

    private function parseTemplate(string $templatePath, array $parameters): string
    {
        ob_start();
        extract($parameters, EXTR_SKIP);
        include $templatePath;

        return ob_get_clean();
    }
}
