<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StudyTask;
use App\Mail\TaskReminderMail;
use Mail;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:remind';
    protected $description = 'Send email reminders for tasks';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $tasks = StudyTask::where('deadline', $tomorrow)
            ->where('status','pending')
            ->get();

        foreach ($tasks as $task) {
            Mail::to($task->user->email)
                ->send(new TaskReminderMail($task));
        }

        return 0;
    }
}
