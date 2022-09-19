<?php

namespace Laravue\Commands;

use AppCore\Application;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SynfonyCommand;
use Symfony\Component\Console\Output\OutputInterface;

trait CallOnExternal
{



    /**
     * Call another console command from other laravel application.
     *
     * @param  string $appBootstrap
     * @param  string  $command
     * @param  array  $arguments
     * @return int
     * @throws \Throwable
     */
    public function callExternal(string $appBootstrap, string $command, array $arguments = []): int
    {
        return $this->runExternalCommand($appBootstrap, $command, $arguments, $this->output);
    }


    /**
     * Run the given the console command.
     *
     * @param  string  $appBootstrap
     * @param  string  $command
     * @param  array  $arguments
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     * @throws \Symfony\Component\Console\Exception\ExceptionInterface
     * @throws \Throwable
     */
    protected function runExternalCommand(string $appBootstrap, string $command, array $arguments, OutputInterface $output): int
    {
        $arguments['command'] = $command;
        if (!is_file($appBootstrap)) {
            throw new \Exception('Provided bootstrap file does not exist');
        }

        $app = require $appBootstrap;
        if (!$app instanceof Application) {
            throw new \Exception('Provided bootstrap file does not return an instance of Application');
        }
        /** @var \Illuminate\Contracts\Console\Kernel $kernel */
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        $input =  $this->createInputFromArguments($arguments);
        $result = $this->resolveExternalCommand($app, $command)->run(
            $input, $output
        );

        $kernel->terminate($input, $result);
        unset($kernel);
        unset($app);

        return $result;
    }


    /**
     * Resolve the console command instance for the given command.
     *
     * @param  \AppCore\Application  $app
     * @param  string  $command
     * @return \Illuminate\Console\Command|\Symfony\Component\Console\Command\Command
     */
    protected function resolveExternalCommand(Application $app, string $command): Command|SynfonyCommand
    {
        $command = $this->getApplication()->find($command);
        /** @var \AppCore\Application $app */

        if ($command instanceof self) {
            $command->setLaravel($app);
        }

        return $command;
    }
}
