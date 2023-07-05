<?php

namespace inisire\RPC\Documentation;

use inisire\DataObject\OpenAPI\RequestSchema;
use inisire\DataObject\OpenAPI\ResponseSchema;
use inisire\DataObject\OpenAPI\SpecificationBuilder;
use inisire\RPC\Entrypoint\Loader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'rpc:documentation:generate',
    description: 'Generate OpenAPI schema for RPCs'
)]
class DocumentationGenerateCommand extends Command
{
    public function __construct(
        private readonly Loader $loader,
        private string          $rootPath = '/rpc'
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('rpc:documentation:generate');
        $this->addArgument('path', InputArgument::OPTIONAL, 'path', 'swagger.json');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $builder = new SpecificationBuilder();

        foreach ($this->loader->load()->getEntrypoints() as $entrypoint) {
            $request = null;
            $responses = [];

            if ($entrypoint->getInputSchema()) {
                $request = new RequestSchema('application/json', $entrypoint->getInputSchema());
            }

            if ($entrypoint->getOutputSchema()) {
                $responses[] = new ResponseSchema(200, 'application/json', $entrypoint->getOutputSchema());
            }

            $path = $this->rootPath . '/' . $entrypoint->getName();
            $builder->addPath('POST', $path, $request, $responses, [], $entrypoint->getDescription() ?? '');
        }

        $specification = $builder->getSpecification();

        $content = json_encode($specification->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($output->isVeryVerbose()) {
            echo $content . PHP_EOL;
        }

        $path = $input->getArgument('path');
        file_put_contents($path, $content);

        $output->writeln(sprintf('Generated: %s', $path));

        return 0;
    }
}