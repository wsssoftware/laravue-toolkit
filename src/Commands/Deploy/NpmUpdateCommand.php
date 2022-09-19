<?php

namespace Laravue\Commands\Deploy;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Process\Process;

/**
 * Class NpmUpdateCommand
 *
 * Created by allancarvalho in setembro 13, 2022
 */
class NpmUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'npm:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the npm packages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->components->info('Updating npm packages');

        $process = new Process(['npm', 'update'], dirname(__DIR__, 4));
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                $this->getOutput()->write($data);
            } else { // $process::ERR === $type
                $this->getOutput()->warning($data);
            }
        }

        return SymfonyCommand::SUCCESS;
    }
}
