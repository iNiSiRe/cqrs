<?php

namespace inisire\RPC\Debug;

use inisire\RPC\Entrypoint\CachedProvider;
use inisire\RPC\Entrypoint\Loader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('rpc:debug:list')]
class ListEntrypointCommand extends Command
{
    protected static $defaultName = 'rpc:debug:list';
    
    public function __construct(
        private readonly CachedProvider $provider
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = new Table($output);
        $table->setHeaders(['RPC', 'Description']);

        foreach ($this->provider->getEntrypoints() as $entrypoint) {
            $table->addRow([$entrypoint->getName(), $entrypoint->getDescription()]);
        }

        $table->render();

        return 0;
    }
}
