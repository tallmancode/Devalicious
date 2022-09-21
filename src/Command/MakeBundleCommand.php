<?php

namespace TallmanCode\DevaliciousBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use TallmanCode\DevaliciousBundle\Generator\MakeBundleGenerator;

class MakeBundleCommand extends Command
{
    private MakeBundleGenerator $generator;

    public function __construct(MakeBundleGenerator $generator, string $name = null)
    {
        parent::__construct($name);
        $this->generator = $generator;
    }

    protected static $defaultName = 'make:bundle';

    protected static $defaultDescription = 'This command create a boilerplate bundle for getting started with developing a bundle';

    protected function configure(): void
    {
        $this
            ->addArgument('vendor', InputArgument::OPTIONAL, 'Your vendor name for the vendor segment in the bundle namespace')
            ->addArgument('bundle_name', InputArgument::OPTIONAL, 'What would you like to call your bundle?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $params = $this->setupParams($input, $io);
        $params = $this->askCreateServiceQuestion($input, $io, $params);
        $this->generator->generateComposer($params);
        $this->generator->generateBundleClass($params);
        $this->generator->generateExtension($params);
        $this->generator->generateConfigurationClass($params);
        $this->generator->generateConfigurationYaml($params);
        if (array_key_exists('serviceClassName', $params)) {
            $this->generator->generateServiceClass($params);
        }
        $this->generator->generateServices($params);

        $this->generator->addBundle($params);
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }

    private function setupParams(InputInterface $input, SymfonyStyle $io): array
    {
        $vendor = $input->getArgument('vendor');
        $bundleName = $input->getArgument('bundle_name');
        if (null === $vendor) {
            $argument = $this->getDefinition()->getArgument('vendor');
            $question = $this->createQuestion($argument->getDescription());
            $question->setNormalizer(static function ($value) {
                return ucfirst(trim($value));
            });
            $vendor = $io->askQuestion($question);
        }

        if (null === $bundleName) {
            $argument = $this->getDefinition()->getArgument('bundle_name');
            $question = $this->createQuestion($argument->getDescription());
            $question->setNormalizer(static function ($value) {
                $value = ucfirst(trim($value));

                if (str_ends_with($value, 'Bundle')) {
                    return $value;
                }

                return $value.'Bundle';
            });
            $bundleName = $io->askQuestion($question);
        }else if (!str_ends_with($bundleName, 'Bundle')) {
            $bundleName .= 'Bundle';
        }

        return [
            'hasServiceClass' => false,
            'vendorInput' => $vendor,
            'bundleNameInput' => $bundleName,
            'bundleNameSpace' => $this->generator->generateNameSpace($vendor, $bundleName),
            'bundleClassName' => $vendor.$bundleName,
            'bundleExtensionName' => $vendor.preg_replace('/Bundle$/', '', $bundleName).'Extension',
            'configName' => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $bundleName)),
            'composer' => [
                'name' => strtolower($vendor).'/'.$this->hyphenate($bundleName),
                'vendor' => $vendor,
                'bundleName' => $bundleName,
            ],
        ];
    }

    private function askCreateServiceQuestion(InputInterface $input, SymfonyStyle $io, $params)
    {
        $question = new ChoiceQuestion(
            'Do you want to add a service class?(y,n)',
            ['y', 'n'],
            'y'
        );

        $createService = $io->askQuestion($question);

        if ('y' === $createService) {
            $question = $this->createQuestion('What would you like to call your service class?');
            $question->setNormalizer(static function ($value) {
                return ucfirst(trim($value));
            });
            $serviceName = $io->askQuestion($question);
            $params['hasServiceClass'] = true;
            $params['serviceClassName'] = $serviceName;
            $params['serviceAlias'] = strtolower($params['vendorInput']).'_'.strtolower(preg_replace('/Bundle$/', '', $params['bundleNameInput'])).'.'.strtolower($serviceName);
        }

        return $params;
    }

    private function createQuestion(string $questionText): Question
    {
        return new Question($questionText);
    }

    public function hyphenate($str, array $noStrip = [])
    {
        $str = preg_replace('/[^a-z0-9'.implode('', $noStrip).']+/i', ' ', $str);
        $str = trim($str);
        $str = str_replace(' ', '-', $str);

        return strtolower($str);
    }
}
