<?php

namespace Jeffgreco13\FilamentBlogger\Commands;

use Illuminate\Console\Command;

class FilamentBloggerCommand extends Command
{
    public $signature = 'filament-blogger';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
