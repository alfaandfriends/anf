<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function teacherResources($filename)
    {
        $filePath = storage_path('app/public/teacher_resources/' . $filename);
    
        if (file_exists($filePath)) {
            $headers = [
                'Content-Type' => 'application/octet-stream', // Set the content type explicitly
            ];
            return response()->download($filePath, $filename, $headers);
        } else {
            abort(404);
        }
    }
}
