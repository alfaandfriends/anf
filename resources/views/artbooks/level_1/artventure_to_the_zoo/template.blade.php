
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $data['name'] }}'s Artventure to the Zoo</title>
    <style type="text/css">
        @page { margin: 0px; }
        @font-face {
            font-family: 'Candy Beans';
            src: url('{{ public_path("/fonts/candy_beans/Candy Beans.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Century Gothic';
            src: url('{{ public_path("/fonts/century_gothic/GOTHIC.TTF") }}') format('truetype');
        }
        @font-face {
            font-family: 'Century Gothic Bold';
            src: url('{{ public_path("/fonts/century_gothic/GOTHICB.TTF") }}') format('truetype');
        }
        .candy_beans{
            font-family: 'Candy Beans', sans-serif;
        }
        .century_gothic{
            font-family: 'Century Gothic', sans-serif;
        }
        .century_gothic.bold{
            font-family: 'Century Gothic Bold', sans-serif;
        }
        body { margin: 0px; }
        .student_name_container{    
            position: absolute;
            right: 37%;
            text-align: center;
            padding: 19px;
            top: -5%;
        }
        .student_name{
            z-index: 1;
            text-align: center;
            color: rgb(241,99,153);
            font-size: 55px;
        }
        .artwork_container{
            position: relative;
        }
        .artwork_area{
            position: relative;
            width: 100%; 
            height: 100%;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            z-index: 1;
        }
        .page_break { 
            page-break-before: always;
        }
        .page_number_left {
            position: absolute; 
            top: 95.6%; 
            left: 5.6%; 
            transform: translate(-50%, -50%); 
            z-index: 1;
        }
        .page_number_right {
            position: absolute; 
            top: 95.6%; 
            right: 4.3%; 
            transform: translate(-50%, -50%); 
            z-index: 1;
        }
    </style>
</head>

<body>
    <div style="position: relative;">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/cover.jpg') }}" style="width: 100%">
        <div style="position: absolute; top: 14%; left: 51.5%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="candy_beans" style="text-align: center; font-size: 40px; color: #d95293; letter-spacing: 0em;">{{ $data['name'] }}'s</p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="page_break"></div>
    <div class="position: relative;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="century_gothic bold" style="font-size: 40px; letter-spacing: 0.05rem; line-height: 2rem; white-space: nowrap;">{{ $data['name'] }}'s Artventure<br> to the Zoo</span>
            </div>
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="century_gothic" style="display: block; font-size: 18px; letter-spacing: 0.05rem; line-height: 1.5rem">Story by:</span>
                <span class="century_gothic" style="display: block; font-size: 18px; letter-spacing: 0.05rem; line-height: 1.5rem">ALFA and Friends</span>
            </div>
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="century_gothic" style="display: block; font-size: 18px; letter-spacing: 0.05rem; line-height: 1.5rem">Illustrated by:</span>
                <span class="century_gothic" style="display: block; font-size: 18px; letter-spacing: 0.05rem; line-height: 1.5rem">ALFA and Friends and {{ $data['name'] }}</span>
            </div>
        </div>
        <div style="position: absolute; top: 82%; left: 16%; transform: translate(-10%, 0%); text-align: justify;">
            <p class="century_gothic" style=" font-size: 13px; letter-spacing: 0.05rem; line-height: 0.8rem">
                Copyright © 2023 ALFA and Friends Sdn. Bhd. All rights reserved. All characters and story contained therein this book is the sole property of the publisher. No part of the content may be reproduced or transmitted in any form or by means, electronic or mechanical, including photocopying, recording, or by any information storage and retrievel system without written permission.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_1.png') }}" class="artwork_area">
        @if($data['image_1'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_1'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_1']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; left: 0%;height: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_2.png') }}" class="artwork_area">
        @if($data['image_1'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_1'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_1']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; right: 0%;height: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_3.png') }}" class="artwork_area">
        @if($data['image_2'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_2'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_2']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; left: 0%;height: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_4.png') }}" class="artwork_area">
        @if($data['image_2'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_2'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_2']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; right: 0%;height: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_5.png') }}" class="artwork_area">
        @if($data['image_3'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_3'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_3']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; left: 0%;height: 100%; width: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_6.png') }}" class="artwork_area">
        @if($data['image_4'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_4'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_4']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; left: 0%;height: 100%; width: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_7.png') }}" class="artwork_area">
        @if($data['image_5'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_5'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_5']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; left: 0%;height: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_8.png') }}" class="artwork_area">
        @if($data['image_5'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_5'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_5']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; right: 0%;height: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_9.png') }}" class="artwork_area">
        @if($data['image_6'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_6'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_6']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; left: 0%;height: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_10.png') }}" class="artwork_area">
        @if($data['image_7'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_7'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_7']) }}" class="artwork" style="position: absolute; z-index: -1;top: 0%; right: 0%;height: 100%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 22px; letter-spacing: 0.05em; line-height: 1.1rem">
                The end.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_zoo/page_11.jpg') }}" class="artwork_area">
        <div style="font-size: 26px; text-align: center; letter-spacing: 0.05em; position: absolute; top: 38%; left: 50%; transform: translate(-50%, -50%); z-index: 1; white-space: nowrap;">
            <p class="candy_beans" style="display: inline-block; color: #d95293;">{{ $data['name'] }}'s</p> 
            <p class="candy_beans" style="display: inline-block; color: #f68b22;">Artventure</p> 
            <p class="candy_beans" style="display: inline-block; color: #13a8b5;">to the Zoo</p>
        </div>
        <div style="text-align: center; letter-spacing: 0em; position: absolute; top: 48%; left: 50%; transform: translate(-50%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 16px; letter-spacing: 0.05em; line-height: 0.95rem; white-space: nowrap;">
                Join young adventurer <span style="color: #d95293">{{ $data['name'] }}</span> on an exciting trip to the<br>
                zoo where {{ $data['gender']['subject_pronoun'] }} encounters a world of diverse animals.<br>
                As {{ $data['gender']['subject_pronoun'] }} explores, <span style="color: #d95293">{{ $data['name'] }}</span> learns about their habitats<br>
                and the importance of preserving biodiversity, touching<br>
                on Sustainable Development Goal: Life on Land. The tale<br>
                unfolds with valuable lessons about conservation and<br>
                protecting animals from extinction.
            </p>
        </div>
    </div>
</body></html>