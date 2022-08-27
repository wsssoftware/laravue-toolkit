<?php

namespace Laravue\Commands;

use Illuminate\Console\Command;

class LaravueToolkitCommand extends Command
{
    public $signature = 'laravue-toolkit';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
