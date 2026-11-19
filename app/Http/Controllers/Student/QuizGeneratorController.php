<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuizGeneratorController extends Controller
{
    public function index()
    {
        return view('student.ai-quiz');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'topic' => ['required', 'string', 'min:3', 'max:160'],
            'question_count' => ['required', 'integer', 'between:5,10'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
        ]);

        $apiKey = config('services.openai.key');
        if (!$apiKey) {
            return back()->withInput()->with('error', 'AI Quiz Generator needs OPENAI_API_KEY to be configured by the site administrator. Other SMART CAMPUS features are still available.');
        }

        try {
            $response = Http::withToken($apiKey)->acceptJson()->timeout(35)->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'temperature' => 0.4,
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    ['role' => 'system', 'content' => 'Create educational practice quizzes. Return only a JSON object with a questions array. Each question must have question (string), options (array of exactly four strings), answer (one exact option string), and explanation (short string). Ensure the correct answer is unambiguous. Do not create questions about personal data or harmful activities.'],
                    ['role' => 'user', 'content' => 'Create '.$validated['question_count'].' '.$validated['difficulty'].' multiple-choice practice questions about: '.$validated['topic'].'. These are for learning, not a formal examination.'],
                ],
            ]);

            if (!$response->successful()) {
                Log::warning('AI quiz provider returned an error', ['status' => $response->status()]);
                return back()->withInput()->with('error', 'The quiz service is temporarily unavailable. Please try again later.');
            }

            $content = data_get($response->json(), 'choices.0.message.content');
            $decoded = is_string($content) ? json_decode($content, true) : null;
            $questions = is_array($decoded) ? ($decoded['questions'] ?? null) : null;

            if (!is_array($questions) || count($questions) !== (int) $validated['question_count']) {
                return back()->withInput()->with('error', 'The quiz could not be formatted correctly. Please try generating it again.');
            }

            foreach ($questions as $question) {
                if (!is_array($question)
                    || !isset($question['question'], $question['options'], $question['answer'], $question['explanation'])
                    || !is_array($question['options'])
                    || count($question['options']) !== 4
                    || !in_array($question['answer'], $question['options'], true)) {
                    return back()->withInput()->with('error', 'The generated quiz contained an invalid question. Please try again.');
                }
            }

            return view('student.ai-quiz', [
                'questions' => $questions,
                'topic' => $validated['topic'],
                'difficulty' => $validated['difficulty'],
            ]);
        } catch (\Throwable $exception) {
            Log::warning('AI quiz generation failed', ['message' => $exception->getMessage()]);
            return back()->withInput()->with('error', 'Could not connect to the quiz service. Please try again shortly.');
        }
    }
}
