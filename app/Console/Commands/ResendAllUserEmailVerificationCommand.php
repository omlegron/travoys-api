<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ResendAllUserEmailVerificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'travoy:resend-verification-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resend all user email verification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNull('email_verified_at')->get();
        foreach ($users as $user) {
            $this->line("Resending email to {$user->email}...");

            try {
                $user->sendEmailVerificationNotification();
            } catch (Exception $e) {
                $this->error("Failed sending email to {$user->email}");
            }

            $this->info("Resent email to {$user->email}");
        }
    }
}
