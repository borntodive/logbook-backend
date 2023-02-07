<?php

namespace App\Console\Commands;

use App\Mail\DANMembership;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendDANMembershipEmail extends Command
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
        $exp = Carbon::now()->subDays(45);

        $exp = $exp->subDays(45);
        $users = User::whereMonth('dan_exp', $exp->format('Y-m-d'))->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new DANMembership($user));
        }
        return Command::SUCCESS;
    }
}
