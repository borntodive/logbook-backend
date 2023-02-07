<?php

namespace App\Console\Commands;

use App\Mail\HappyBirthday;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendBirthdayEmail extends Command
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
        $users = User::whereMonth('birthdate', Carbon::now()->format('m'))
            ->whereDay('birthdate', Carbon::now()->format('d'))
            ->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new HappyBirthday($user));
        }
        return Command::SUCCESS;
    }
}
