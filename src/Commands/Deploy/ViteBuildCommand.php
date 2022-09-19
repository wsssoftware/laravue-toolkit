<?php

namespace Laravue\Commands\Deploy;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Process\Process;

/**
 * Class ViteBuildCommand
 *
 * Created by allancarvalho in setembro 19, 2022
 */
class ViteBuildCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vite:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build js and css files using vite';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->components->info('Building resources');

        $process = new Process(['npm', 'run', 'build'], dirname(__DIR__, 4));
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
