<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use OpenAI;

class AiController extends Controller
{
    public function commentGenerator(Request $request)
    {   
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $prompt = "Persona: Professional & Formal Teacher

            You will generate comment that explain to parents about the student's progress in the lesson. The comment should be at max 100 words. The comment should include the following information:

            IMPORTANT: Please ensure that the comment is appropriate and does not contain any sensitive information.
            IMPORTANT: Make sure that comment is understandable by parents.
            IMPORTANT: Make sure that comment is relevant to the student's progress.
            IMPORTANT: New paragraph for each point with simple explanation.
            IMPORTANT: Avoid negative tone.
            IMPORTANT: Avoid suggestive comment and parent involvement.

            EXAMPLE: This student has demonstrated proficiency in using fact families to determine unknown numbers in mathematical equations. They have effectively applied this strategy to identify the correct answer, showcasing a strong understanding of the concept.
            EXAMPLE: This student has successfully learned to arrange numbers in both ascending and descending order. They can accurately differentiate between the two and identify smaller and larger numbers. Additionally, their workbook demonstrates a strong grasp of the concept, with all answers correct. They show confidence and proficiency in comparing and ordering numbers.

            $request->user_prompt
        ";

        return response()->stream(function () use ($client, $prompt) {
            ob_start();
            $stream = $client->chat()->createStreamed([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            foreach ($stream as $response) {
                if ($response->choices[0]->delta->content ?? false) {
                    echo $response->choices[0]->delta->content;
                    ob_flush(); // Ensure data is sent immediately
                    flush();
                }
            }
            ob_end_flush();
        }, 200, [
            "Content-Type" => "text/event-stream",
            "Cache-Control" => "no-cache",
            "Connection" => "keep-alive"
        ]);
    }

    public function commentImprove(Request $request)
    {   
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $prompt = "Persona: Professional & Formal Teacher

            Improvise the selected text ONLY with provided context
            $request->user_prompt

            IMPORTANT: Please ensure that the comment is appropriate and does not contain any sensitive information.
            IMPORTANT: Make sure that comment is understandable by parents.
            IMPORTANT: Make sure that comment is relevant to the student's progress.
            IMPORTANT: New paragraph for each point with simple explanation.
            IMPORTANT: Avoid negative tone.
            IMPORTANT: Avoid suggestive comment and parent involvement.

            <example>
                Actual comment: While they are still working on counting in groups of 2s, 5s, and 10s, their participation shows enthusiasm for the lessons. 
                Selected phrase: shows enthusiasm for the lessons
                Response: Improved phrase for `shows enthusiasm for the lessons`
            </example>


            SUPER IMPORTANT: ONLY reply the improvised phrase that will replace the selected phrase.
        ";

        return response()->stream(function () use ($client, $prompt) {
            ob_start();
            $stream = $client->chat()->createStreamed([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            foreach ($stream as $response) {
                if ($response->choices[0]->delta->content ?? false) {
                    echo $response->choices[0]->delta->content;
                    ob_flush(); // Ensure data is sent immediately
                    flush();
                }
            }
            ob_end_flush();
        }, 200, [
            "Content-Type" => "text/event-stream",
            "Cache-Control" => "no-cache",
            "Connection" => "keep-alive"
        ]);
    }
}
