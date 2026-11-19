<?php

namespace Tests\Feature;

use Tests\TestCase;

class StudentPagesSmokeTest extends TestCase
{
    public function test_student_complaint_and_quiz_pages_exist(): void
    {
        $this->assertTrue(view()->exists('student.complaints.index'));
        $this->assertTrue(view()->exists('student.complaints.create'));
        $this->assertTrue(view()->exists('student.complaints.show'));
        $this->assertTrue(view()->exists('student.ai-quiz'));
    }

    public function test_complaints_and_quiz_routes_require_authentication(): void
    {
        $this->get(route('student.complaints.index'))->assertRedirect(route('login'));
        $this->get(route('student.complaints.create'))->assertRedirect(route('login'));
        $this->get(route('student.quiz.index'))->assertRedirect(route('login'));
    }
}
