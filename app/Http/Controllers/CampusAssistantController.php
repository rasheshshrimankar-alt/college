<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CampusAssistantController extends Controller
{
    public function reply(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:1200'],
        ]);

        $message = trim($validated['message']);
        $apiKey = config('services.openai.key');
        $model = config('services.openai.model', 'gpt-4o-mini');

        if (!$apiKey) {
            return response()->json([
                'reply' => $this->helpfulFallback($message),
                'mode' => 'help'
            ]);
        }

        try {
            $response = Http::withToken($apiKey)->timeout(25)->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are Smart Campus Assistant for a college management website. Help students and faculty with general guidance about attendance, assignments, exams, fees, timetable, library, placements, notices, and account navigation. Be concise, friendly, and use simple English. Never claim to access private student records, change marks, make payments, or perform actions. For account-specific information, direct the user to the relevant authenticated dashboard page or college office. If uncertain, say so.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
                'max_tokens' => 350,
            ]);

            if (!$response->successful()) {
                Log::warning('Campus assistant provider returned an error', ['status' => $response->status()]);
                return response()->json(['reply' => 'The AI service is temporarily unavailable. Please try again shortly.'], 503);
            }

            $answer = data_get($response->json(), 'choices.0.message.content');
            if (!is_string($answer) || trim($answer) === '') {
                return response()->json(['reply' => 'I could not prepare an answer. Please try asking in a different way.'], 503);
            }

            return response()->json(['reply' => trim($answer), 'mode' => 'ai']);
        } catch (\Throwable $exception) {
            Log::warning('Campus assistant request failed', ['message' => $exception->getMessage()]);
            return response()->json(['reply' => 'The AI service is temporarily unavailable. Please try again shortly.'], 503);
        }
    }

    private function helpfulFallback(string $message): string
    {
        $q = strtolower($message);
        $answers = [
            ['terms' => ['attendance', 'present'], 'text' => 'To check attendance, sign in and open Student Dashboard → Attendance. If a record looks incorrect, contact your faculty or college office.'],
            ['terms' => ['assignment', 'homework', 'submit'], 'text' => 'Open Student Dashboard → Assignments, choose the assignment, attach your work, add an optional note, and submit it before the due date.'],
            ['terms' => ['exam', 'result', 'marks', 'grade'], 'text' => 'Check Student Dashboard → Results for published marks. Exam schedules and updates are available in the notices or examination section.'],
            ['terms' => ['fee', 'fees', 'payment'], 'text' => 'Open Student Dashboard → Fees to review your fee information. For payment confirmation or corrections, contact the accounts office.'],
            ['terms' => ['time table', 'timetable', 'schedule', 'class'], 'text' => 'Open Student Dashboard → Timetable. If your schedule is missing or incorrect, contact your department.'],
            ['terms' => ['library', 'book'], 'text' => 'Open Student Dashboard → Library to browse available books and review your issued-book information.'],
            ['terms' => ['placement', 'internship', 'job'], 'text' => 'Visit the Placements section for opportunities and eligibility details. Contact your placement cell for application support.'],
            ['terms' => ['complaint', 'feedback', 'issue'], 'text' => 'Open Student Dashboard → Complaints to submit an issue and review its status.'],
            ['terms' => ['notice', 'event', 'holiday'], 'text' => 'Check the Notices and Events sections on the website for college announcements and updates.'],
        ];

        foreach ($answers as $item) {
            foreach ($item['terms'] as $term) {
                if (str_contains($q, $term)) return $item['text'];
            }
        }

        return 'I can help with attendance, assignments, exams and results, fees, timetable, library, placements, complaints, and college notices. What would you like help with?';
    }
}
