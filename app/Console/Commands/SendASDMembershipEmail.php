<?php

namespace App\Console\Commands;

use App\Mail\ASDMembership;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendASDMembershipEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthday';

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
        $users = User::get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new ASDMembership($user));
        }
        return Command::SUCCESS;
    }
}
