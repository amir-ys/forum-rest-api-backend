<?php

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReplySubmitted extends Notification
{
    use Queueable;

    public $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'thread_title' => $this->thread->title,
            'url' => route('threads.show', $this->thread->id),
            'time' => now()->format('Y-m-d-h:s:o')
        ];

    }
}
