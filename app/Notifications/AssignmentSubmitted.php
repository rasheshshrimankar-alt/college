<?php

namespace App\\Notifications;

use Illuminate\\Bus\\Queueable;
use Illuminate\\Notifications\\Notification;

class AssignmentSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public int $assignmentId,
        public string $assignmentTitle,
        public string $studentName
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New assignment submission',
            'message' => $this->studentName . ' submitted ' . $this->assignmentTitle,
            'url' => route('faculty.assignments.submissions', $this->assignmentId),
            'type' => 'assignment_submission',
        ];
    }
}
