<?php

namespace Tests\Feature;

use Tests\TestCase;

class AiQuizGeneratorTest extends TestCase
{
    public function test_quiz_generator_is_available_only_to_signed_in_students(): void
    {
        $this->get(route('student.quiz.index'))->assertRedirect(route('login'));
        $this->post(route('student.quiz.generate'), [
            'topic' => 'Data structures',
            'question_count' => 5,
            'difficulty' => 'beginner',
        ])->assertRedirect(route('login'));
    }
}
