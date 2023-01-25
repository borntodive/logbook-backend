<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EmptyTmpFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'empty:tmp-folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empty Tmp Folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Storage::deleteDirectory('/public/tmp');
        return Command::SUCCESS;
    }
}
