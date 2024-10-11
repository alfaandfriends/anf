<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use MagicLink\Actions\ControllerAction;
use MagicLink\Actions\ResponseAction;
use MagicLink\MagicLink;

class QRcodeGenerateController extends Controller
{ 
    public function generateQr(Request $request){
        $encrypted_data = Crypt::encryptString(json_encode($request->all()));
        $url = route('upload_artwork', $encrypted_data);
        // dd($url);
        $qrCode =  QrCode::size(150)->style('round')->generate($url);
        return (string)$qrCode;
    }
}
