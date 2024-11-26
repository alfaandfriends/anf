<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use OpenAI;

class AiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('AiChat/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $api_key = env('OPENAI_API_KEY');
        $client = OpenAI::client($api_key);
        
        // $thread = $client->threads()->createAndRun(
        //     [
        //         'assistant_id' => 'asst_wRbO55kZ9S8XmxSkqu5ndCB4',
        //         'thread' => [
        //             'messages' =>
        //                 [
        //                     [
        //                         'role' => 'user',
        //                         'content' => '
        //                             You are an intelligent teaching assistant. You generate quiz questions based on provided study materials or relevant context retrieved from a vector store. Your goal is to create engaging, level-appropriate questions that help the student reinforce their understanding of the material.

        //                             Based on the following content retrieved from the vector store, create a set of quiz questions. Include a mix of multiple-choice, true/false, and short-answer questions. The questions should align with a BEGINNER level of understanding.

        //                             Content: {vector stores}

        //                             Guidelines:
        //                             - Generate 5-10 questions.
        //                             - Use clear, concise language.
        //                             - If the material includes key terms or concepts, create questions to test their definitions or applications.
        //                             - Include options for multiple-choice questions.

        //                             Start generating the questions now.',
        //                     ],
        //                 ],
        //         ],
        //     ],
        // );
        
        // while(in_array($thread->status, ['queued', 'in_progress'])) {
        //     $threadRun = $client->threads()->runs()->retrieve(
        //         threadId: $thread->threadId,
        //         runId: $thread->id,
        //     );
        // }

        // if ($threadRun->status !== 'completed') {
        //     dump('Request failed, please try again');
        // }

        // $messageList = $client->threads()->messages()->list(
        //     threadId: $threadRun->threadId,
        // );

        // dd($messageList->data[0]->content[0]->text->value);

        $thread = $client->threads()->createAndRun(
            [
                'assistant_id' => 'asst_wRbO55kZ9S8XmxSkqu5ndCB4',
                'thread' => [
                    'messages' =>
                        [
                            [
                                'role' => 'user',
                                'content' => '
                                    You are an intelligent teaching assistant. You generate quiz questions based on provided study materials or relevant context retrieved from a vector store. Your goal is to create engaging, level-appropriate questions that help the student reinforce their understanding of the material.
                
                                    Based on the following content retrieved from the vector store, create a set of quiz questions. Include a mix of multiple-choice, true/false, and short-answer questions. The questions should align with a BEGINNER level of understanding.
                
                                    Content: {vector stores}
                
                                    Guidelines:
                                    - Generate 5-10 questions.
                                    - Use clear, concise language.
                                    - If the material includes key terms or concepts, create questions to test their definitions or applications.
                                    - Include options for multiple-choice questions.
                
                                    Start generating the questions now.',
                            ],
                        ],
                ],
            ],
        );
        $threadId = $thread->threadId;
        $runId = $thread->id;
        
        while(true){
            $response = $client->threads()->runs()->retrieve(
                threadId: $threadId,
                runId: $runId,
            );
            if($response->status !== 'in_progress'){
                $output = $client->threads()->messages()->list($threadId, [
                    'limit' => 10,
                ]);
                dd($output);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
