<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class DokuController extends Controller
{


    public function generatePayment(){
        
        $api_endpoint        =   'https://api-sandbox.doku.com/checkout/v1/payment';
        
        $clientId = "BRN-0208-1696494657208";
        $requestId = "test";
        $requestDate = Carbon::now()->format('Y-m-d\TH:i:s\Z');
        $targetPath = "/checkout/v1/payment"; // For merchant request to Jokul, use Jokul path here. For HTTP Notification, use merchant path here
        $secretKey = "SK-PXOSBkfqfgZRdjrJUXPu";
        $requestBody = array (
            "order" => array(
                "amount" => 20000,
                "invoice_number" => "2023-000001"
            ),
            "payment" => array(
                "payment_due_date" => 0
            )
        );

        // Generate Digest
        $digest = base64_encode(hash('sha256', json_encode($requestBody), true));

        
        $componentSignature  = "Client-Id:" . $clientId . "\n" . 
                                "Request-Id:" . $requestId . "\n" .
                                "Request-Timestamp:" . $requestDate . "\n" . 
                                "Request-Target:" . $targetPath . "\n" .
                                "Digest:" . $digest;

                    
        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));
                            
        try {
            $response = Http::withHeaders([
                'Client-Id'         =>  $clientId,
                'Request-Id'        =>  $requestId,
                'Request-Timestamp' =>  $requestDate,
                'Signature'         =>  "HMACSHA256=" . $signature,
            ])->post($api_endpoint, $requestBody);
            dd(dump($response->body()));
        } catch (RequestException $e) {
            dd($e);
        }
    }
}
