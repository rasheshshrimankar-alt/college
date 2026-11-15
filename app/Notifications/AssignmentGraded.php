<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AssignmentGraded extends Notification
{
    use Queueable;

    public function __construct(
        public string $assignmentTitle,
        public float $marks,
        public float $maxMarks
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Assignment graded',
            'message' => $this->assignmentTitle . ': ' . $this->marks . ' / ' . $this->maxMarks,
            'url' => route('student.assignments'),
            'type' => 'assignment_graded',
        ];
    }
}
