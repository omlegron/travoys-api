<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Notifications\CustomFcmNotification;
use Illuminate\Support\Facades\Notification;

class SendNotificationUserIdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'travoy:notify-user
                            {id : User ID}
                            {title : Notification Title}
                            {body : Notification Body}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to all user';

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
        $users = User::find($this->argument('id'));

        $this->line("Sending notification to user ID {$this->argument('id')}...");

        Notification::send($users, new CustomFcmNotification(
            $this->argument('title'),
            $this->argument('body')
        ));

        $this->info("Notification to user ID {$this->argument('id')} has been sent.");
    }
}
