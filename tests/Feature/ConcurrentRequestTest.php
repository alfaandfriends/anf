<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\Utils;

class ConcurrentRequestTest extends TestCase
{
    public function testConcurrentRequests()
    {
        // Define the number of concurrent requests
        $concurrentRequests = 100;

        // Specify the URLs you want to test
        $urls = [route('login')];

        // Create a Guzzle client
        $client = new Client();

        // Create an array to store promises
        $promises = [];

        // Create concurrent requests
        for ($i = 0; $i < $concurrentRequests; $i++) {
            foreach ($urls as $url) {
                $promises[] = $client->getAsync($url);
            }
        }

        // Wait for all the promises to complete
        $responses = Utils::all($promises)->wait();

        // Add assertions if needed
        foreach ($responses as $response) {
            $this->assertEquals(200, $response->getStatusCode());
        }
    }
}
