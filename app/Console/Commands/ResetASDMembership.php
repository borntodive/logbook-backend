<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetASDMembership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:asdMembership';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset users memberships';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::query()->update(['asd_membership' => false]);

        return Command::SUCCESS;
    }
}
