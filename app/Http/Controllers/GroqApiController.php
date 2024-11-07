<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LucianoTonet\GroqLaravel\Facades\Groq;

class GroqApiController extends Controller
{
    public function test(){
        $response = Groq::chat()->completions()->create([
            'model' => 'llama-3.1-70b-versatile',
            'messages' => [
                ['role' => 'user', 'content' => 'Hello, what is the weather in my location?'],
                ['role' => 'user', 'content' => 'Malaysia, shah alam'],
            ],
            'tools' => [
                [
                    'type' => 'function',
                    'function' => [
                        'name' => 'get_current_weather',
                        'description' => 'Get the current weather in a given location',
                        'parameters' => [
                            'type' => 'object',
                            'properties' => [
                                'location' => [
                                    'type' => 'string',
                                    'description' => 'The city and state, e.g., San Francisco, CA'
                                ],
                                'unit' => [
                                    'type' => 'string',
                                    'enum' => ['celsius', 'fahrenheit']
                                ]
                            ],
                            'required' => ['location']
                        ]
                    ]
                ]
            ],
            'tool_choice' => 'auto'
        ]);
        
        $response['choices'][0]['message']['content']; // "Hey there! I'm doing great! How can I help you today?"
        dd($response);
    }
}
