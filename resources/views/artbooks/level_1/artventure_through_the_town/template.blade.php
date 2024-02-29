
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $data['name'] }}'s Artventure through the Town</title>
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
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/cover.jpg') }}" style="width: 100%">
        <div style="position: absolute; top: 17%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="candy_beans" style="text-align: center; font-size: 40px; color: #d95293; letter-spacing: 0em;">{{ $data['name'] }}'s</p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="page_break"></div>
    <div class="position: relative;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="century_gothic bold" style="font-size: 40px; letter-spacing: 0.05rem; line-height: 2rem;">{{ $data['name'] }}'s Artventure through the Town</span>
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
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_1.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 19%; left: 16%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                The class ends a bit early.<br>
                <span style="color: #d95293;">{{ $data['name'] }}</span> invites {{ $data['gender']['possessive_adjective'] }} friends to come over to {{ $data['gender']['possessive_adjective'] }} house to play.<br><br>
                “It’s just around the corner. We could just walk from here!” Says <span style="color: #d95293;">{{ $data['name'] }}</span>.<br><br>
                They start walking and immediately see some tall and thin buildings<br>
                across the school.
            </p>
        </div>
        <div style="position: absolute; top: 83.5%; left: 15%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                “Is that apartment yours?” Asks Alfa.<br>
                “What a tall house you have. I can barely see the top!” Says Ollie.<br>
                “It has so many windows and floors. Which one is yours?” Asks Piper.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_2.png') }}" class="artwork_area">
        @if($data['image_1'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_1'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_1']) }}" style="height: 100%; width: 100%; position: absolute; left: 0; z-index: -1; top: 0;">
        @endif
        <div style="position: absolute; top: 39%; left: 63%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “No, no! That is not my<br>
                house. We have to walk a<br>
                bit more,” says <span style="color: #d95293;">{{ $data['name'] }}</span>.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_3.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 26.5%; left: 30%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.05rem">
                They continue walking and spot some<br>
                more houses next to the road.<br><br>
                “Those are terrace houses! Are they<br>
                yours?” Asks Alfa.<br><br>
                “What a long house you have. I can<br>
                barely see the end!” Says Ollie.<br><br>
                “They are stacked side by side.<br>
                It must be lovely to live in a close<br>
                neighbourhood.” Says Patch.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_4.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 82.5%; left: 61%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “No, no! That is not my house.<br>
                We have to walk a bit more,”<br>
                says Jebat.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_5.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 26.5%; left: 30%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.05rem">
                They continue walking and pass by some<br>
                big houses along the road.<br><br>
                “Those are the bungalows. Which one is<br>
                yours?” Asks Alfa.<br>
                “What a huge house you have. There<br>
                must be plenty of rooms<br>
                to play hide and seek!” Says Ollie.<br>
                “The fence is too high, I wonder if there is<br>
                a huge pool inside.” Says Piper.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_6.png') }}" class="artwork_area">
        @if($data['image_2'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_2'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_2']) }}" style="height: 100%; width: 100%; position: absolute; left: 0; z-index: -1; top: 0;">
        @endif
        <div style="position: absolute; top: 82.5%; left: 60%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “No, no! That is not my house.<br>
                We have to walk a bit more,”<br>
                says <span style="color: #d95293;">{{ $data['name'] }}</span>.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_7.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 19%; left: 12%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.05rem">
                They walk a bit more past the river and<br>
                find some traditional wooden houses with tall legs.<br><br>
                “Those are the traditional Malay houses. Is this one yours?” Asks Alfa.<br><br>
                The legs raise the house higher so that the flood won’t get in the<br>
                house.” Says Piper.
            </p>
        </div>
        <div style="position: absolute; top: 86.5%; left: 57%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “What a unique house you<br>
                have. I haven’t seen a house<br>
                with legs before!” Says Ollie.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_8.png') }}" class="artwork_area">
        @if($data['image_3'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_3'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_3']) }}" style="height: 100%; width: 100%; position: absolute; left: 0; z-index: -1; top: 0;">
        @endif
        <div style="position: absolute; top: 82.5%; left: 60%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “No, no! That is not my house.<br>
                We have to walk a bit more,”<br>
                says <span style="color: #d95293;">{{ $data['name'] }}</span>.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_9.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 23.5%; left: 12%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.05rem">
                They continue walking and see another wooden house.<br><br>
                “This is rumah panjang. It is long enough for the whole family to live<br>
                together. Are you living here as well?” Asks Alfa.<br><br>
                “It is long enough to be a running track. It must take a while to run<br>
                from one end to another,” says Ollie.<br><br>
                “Wow, it must be fun to live with your whole family and relatives!”<br>
                Chimes Piper.
            </p>
        </div>
        <div style="position: absolute; top: 88%; left: 45%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “No, it’s not mine! Keep walking, we are
                almost there,” says <span style="color: #d95293;">{{ $data['name'] }}</span>.<br>
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_10.png') }}" class="artwork_area">
        @if($data['image_4'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_4'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_4']) }}" style="height: 100%; width: 100%; position: absolute; left: 0; z-index: -1; top: 0;">
        @endif
        <div style="position: absolute; top: 14%; left: 15%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.05rem">
                Finally, they reach <span style="color: #d95293;">{{ $data['name'] }}’s</span> house.<br>
                It is a wonderful home with a space to play and a cosy place to rest.<br>
                They play together and have some cookies and tea.
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
        <img src="{{ public_path('/images/artbooks/level_1/artventure_through_the_town/page_11.jpg') }}" class="artwork_area">
        <div style="font-size: 26px; text-align: center; letter-spacing: 0.05em; position: absolute; top: 38%; left: 45%; transform: translate(-40%, -50%); z-index: 1;">
            <p class="candy_beans" style="display: inline-block; color: #d95293;">{{ $data['name'] }}'s</p> 
            <p class="candy_beans" style="display: inline-block; color: #f68b22;">Artventure</p> 
            <p class="candy_beans" style="display: inline-block; color: #13a8b5;">through the Town</p>
        </div>
        <div style="text-align: center; letter-spacing: 0em; position: absolute; top: 48%; left: 24%; transform: translate(-5%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 16px; letter-spacing: 0.05em; line-height: 0.95rem">
                <span style="color: #d95293">{{ $data['name'] }}</span> is throwing a super fun house playdate, and {{ $data['gender']['subject_pronoun'] }}<br>
                has invited all {{ $data['gender']['possessive_adjective'] }} friends. On their way to <span style="color: #d95293">{{ $data['name'] }}’s</span><br>
                house, they spot a bunch of houses, each with its own<br>
                special shapes and cool patterns. But hold on – can they<br>
                figure out which one is <span style="color: #d95293">{{ $data['name'] }}’s</span>? They stop at every single<br>
                house, putting on their best guessing game faces. Who can<br>
                come out with the best guess?
            </p>
        </div>
    </div>
</body></html>