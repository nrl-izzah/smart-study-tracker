<?php

namespace App\Mail;

use App\Models\StudyTask;
use Illuminate\Mail\Mailable;

class TaskCreatedMail extends Mailable
{
    public $task;

    public function __construct(StudyTask $task)
    {
        $this->task = $task;
    }

    public function build()
    {
        return $this->subject('New Task Created')
                    ->view('emails.task-created');
    }
}
