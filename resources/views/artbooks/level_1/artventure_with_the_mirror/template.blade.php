
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $data['name'] }}'s Artventure with the Mirror</title>
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
        .artwork{
            height: 71.5%;
            width: 71%;
            position: absolute;
            z-index: -1;
            left: 15%;
            top: 15%;
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
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/cover.jpg') }}" style="width: 100%">
        <div style="position: absolute; top: 10%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="candy_beans" style="text-align: center; font-size: 40px; color: #d95293; letter-spacing: 0em;">{{ $data['name'] }}'s</p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="page_break"></div>
    <div class="position: relative;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="century_gothic bold" style="font-size: 40px; letter-spacing: 0.05rem; line-height: 2rem;">{{ $data['name'] }}'s Artventure with the Mirror</span>
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
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_1.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 31%; left: 47%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                It is art class time!<br>
                <span style="color: #d95293;">{{ $data['name'] }}</span> is so excited.<br>
                That is {{ $data['gender']['possessive_adjective'] }} favourite class after all.<br>
                Today, they are going to learn<br>
                how to draw humans and self-portraits.<br>
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_2.png') }}" class="artwork_area">
        @if($data['image_1'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_1'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_1']) }}" class="artwork" style="top: 17%; left: 13%; height: 75%; width: 75%;">
        @endif
        <div style="position: absolute; top: 10%; left: 15%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Human drawing can be quite hard. But, when you use shapes to guide,<br>
                it can be a lot easier!” Says Miss Nasha.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_3.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 17%; left: 49%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Human bodies are all different,<br>
                Some are tall, some are short.<br>
                Some are straight, some are curvy.
            </p>
        </div>
        <div style="position: absolute; top: 89%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Their skins and hairs all vary.<br>
                Not to mention their choice of outfits!
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_4.png') }}" class="artwork_area">
        @if($data['image_2'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_2'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_2']) }}" class="artwork" style="top: 17%; left: 13%; height: 75%; width: 75%;">
        @endif
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_5.png') }}" class="artwork_area">
        @if($data['image_3'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_3'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_3']) }}" class="artwork" style="top: 17%; left: 13%; height: 75%; width: 75%;">
        @endif
        <div style="position: absolute; top: 10%; left: 15%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Next, the class learn how to draw the eyes, nose, mouth and ears.
            </p>
        </div>
        <div style="position: absolute; top: 88%; left: 44%; transform: translate(-40%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Everyone has different set of those.<br>
                That makes everyone’s face so special.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_6.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 10%; left: 10%; transform: translate(-10%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Lastly, everyone has to<br>
                draw their own face
            </p>
        </div>
        <div style="position: absolute; top: 72.5%; left: 20%; transform: translate(-10%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                <span style="color: #d95293;">{{ $data['name'] }}</span> frets.<br>
                <span style="text-transform: capitalize">{{ $data['gender']['subject_pronoun'] }}</span> cannot draw his face.<br>
                <span style="text-transform: capitalize">{{ $data['gender']['subject_pronoun'] }}</span> cannot recall what {{ $data['gender']['possessive_adjective'] }} face looks like.<br><br>
                At the end of the class, everyone is ready to go home.<br>
                But, <span style="color: #d95293;">{{ $data['name'] }}’s</span> canvas is still blank!<br>
                Miss Nasha walks to <span style="color: #d95293;">{{ $data['name'] }}</span> and hands {{ $data['gender']['object_pronoun'] }} a fancy gold-coloured<br>
                mirror. “Cheer up, <span style="color: #d95293;">{{ $data['name'] }}</span>. You just need more reflection of yourself!”<br>
                Says Miss Nasha.<br>
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_7.png') }}" class="artwork_area">
        @if($data['image_4'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_4'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_4']) }}" style="position: absolute; z-index: -1; left: 32.5%; top: 29%; width: 35%; height: 35%;">
        @endif
        <div style="position: absolute; top: 13%; left: 12%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Your Name is not quite understood.<br>
                <span style="text-transform: capitalize">{{ $data['gender']['subject_pronoun'] }}</span> looks at the mirror and all<br>
                {{ $data['gender']['subject_pronoun'] }} can see is his face.
            </p>
        </div>
        <div style="position: absolute; top: 89%; left: 72%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Hey, this is exactly<br>
                how my face<br>
                looks like! 
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_8.png') }}" class="artwork_area">
        @if($data['image_4'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_4'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_4']) }}" style="position: absolute; z-index: -1; left: 32.5%; top: 29%; width: 35%; height: 35%;">
        @endif
        <div style="position: absolute; top: 12%; left: 20%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “Thank you, Miss Nasha!” <span style="color: #d95293">{{ $data['name'] }}</span> is intrigued by {{ $data['gender']['possessive_adjective'] }} findings and quickly<br>
                runs outside where {{ $data['gender']['subject_pronoun'] }} finds an ice cream stall across the street.
            </p>
        </div>
        <div style="position: absolute; top: 86%; left: 25%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                <span style="color: #d95293">{{ $data['name'] }}</span> takes the mirror and sees how {{ $data['gender']['possessive_adjective'] }} smile stretches<br>
                from cheek to cheek.<br>
                Oh, this is how {{ $data['gender']['subject_pronoun'] }} looks when {{ $data['gender']['subject_pronoun'] }} sees ice cream!
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_9.png') }}" class="artwork_area">
        @if($data['image_4'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_4'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_4']) }}" style="position: absolute; z-index: -1; left: 32.5%; top: 29%; width: 35%; height: 35%;">
        @endif
        <div style="position: absolute; top: 14%; left: 17%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                <span style="color: #d95293">{{ $data['name'] }}</span> gets {{ $data['gender']['possessive_adjective'] }} feet in front of the stall to get {{ $data['gender']['possessive_adjective'] }} favourite ice cream.<br>
                But wait, {{ $data['gender']['subject_pronoun'] }} brings no penny! How does {{ $data['gender']['subject_pronoun'] }} get the ice cream without<br>
                any money?
            </p>
        </div>
        <div style="position: absolute; top: 86%; left: 20%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                <span style="color: #d95293">{{ $data['name'] }}</span> sighs while looking at the mirror in {{ $data['gender']['possessive_adjective'] }} hands.<br>
                This is the face {{ $data['gender']['subject_pronoun'] }} made when {{ $data['gender']['subject_pronoun'] }} couldn’t get the ice cream.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_10.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 18%; left: 15%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Just when <span style="color: #d95293">{{ $data['name'] }}</span> is about to leave, an ice cream appears right before<br>   
                {{ $data['gender']['possessive_adjective'] }} eyes.<br>   
                “No one is leaving the stall without an ice cream!”<br>   
                Says the vendor while handing out the cone.<br>   
                “Is it for me?” <span style="color: #d95293">{{ $data['name'] }}</span> asks, just wanting to be sure.<br>   
                The vendor nods with a wide smile.
            </p>
        </div>
        <div style="position: absolute; top: 83.5%; left: 15%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “Yay, thank you!” <span style="color: #d95293">{{ $data['name'] }}</span> happily takes the ice cream.<br>  
                The day couldn’t get any better. <span style="color: #d95293">{{ $data['name'] }}</span> gets to discover more about<br>  
                {{ $data['gender']['reflexive_pronoun'] }} and gets a treat of delicious ice cream.
            </p>
        </div>
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
        <img src="{{ public_path('/images/artbooks/level_1/artventure_with_the_mirror/page_11.jpg') }}" class="artwork_area">
        <div style="font-size: 26px; text-align: center; letter-spacing: 0.05em; position: absolute; top: 35%; left: 49.9%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="candy_beans" style="display: inline-block; color: #d95293;">{{ $data['name'] }}'s</p> 
            <p class="candy_beans" style="display: inline-block; color: #f68b22;">Artventure</p> 
            <p class="candy_beans" style="display: inline-block; color: #13a8b5;">with the Mirror</p>
        </div>
        <div style="text-align: center; letter-spacing: 0em; position: absolute; top: 48%; left: 24%; transform: translate(-5%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 16px; letter-spacing: 0.05em; line-height: 0.95rem">
                In the Miss Nasha’s Art Class, <span style="color: #d95293">{{ $data['name'] }}</span> with {{ $data['gender']['possessive_adjective'] }} friends<br>
                dive into a world of shapes, learning how to draw humans<br>
                and their amazing facial features. Their mission? Create a<br>
                self-portrait masterpiece! But uh-oh, <span style="color: #d95293">{{ $data['name'] }}’s</span> feeling a bit<br>
                puzzled about {{ $data['gender']['possessive_adjective'] }} own features.<br><br>
                Guess what? Miss Nasha comes to the rescue with a<br>
                magical gold mirror, setting Jebat on a thrilling journey to<br>
                discover {{ $data['gender']['possessive_adjective'] }} many expressions and uncover {{ $data['gender']['possessive_adjective'] }}<br>
                real self.
            </p>
        </div>
    </div>
</body></html>