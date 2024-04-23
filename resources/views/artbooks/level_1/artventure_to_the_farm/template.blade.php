
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $data['name'] }}'s Artventure to the Farm</title>
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
            position: absolute;
            z-index: -1;
            left: 15%;
            top: 15%;
            width: 71%;
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
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/cover.jpg') }}" style="width: 100%">
        <div style="position: absolute; top: 64%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="candy_beans" style="text-align: center; font-size: 40px; color: #d95293; letter-spacing: 0em;">{{ $data['name'] }}'s</p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="page_break"></div>
    <div class="position: relative;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="century_gothic bold" style="font-size: 40px; letter-spacing: 0.05rem; line-height: 2rem; white-space: nowrap;">{{ $data['name'] }}'s Artventure<br> to the Farm</span>
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
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_1.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 12.1%; left: 35%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                <span class="century_gothic bold"><span style="font-size: 22px;">HONK!</span> HONK!</span><br>
                The bus honks twice.<br>
                “They are here!” Shouts <span style="color: #d95293;">{{ $data['name'] }}</span>.<br>
                He puts on his backpack and runs over to the bus.<br>
            </p>
        </div>
        <div style="position: absolute; top: 76.5%; left: 31%; transform: translateX(-20%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                “We are off to the farm!” Shouts Alfa.<br>
                Everyone cheers and starts singing.<br>
                They are so excited to go on a trip to a country farm.<br>
                They have been waiting for this day all week long!<br>
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_2.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 14%; left: 18%; transform: translate(-10%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                <span class="century_gothic bold" style="font-size: 22px;">Cockadoodle-doo!</span><br>
                The rooster greets the children’s arrivals.<br>
                “Wow, what a large farmhouse,” says Piper.<br>
                “There are so many animals to see!” Says Ollie.<br>
                “I can already smell the yummy milk and cheese!” Says Patch.<br>
            </p>
        </div>
        <div style="position: absolute; top: 83.5%; left: 17%; transform: translate(-10%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “I wish I had my camera with me. I want to show all<br>
                these animals to my mommy and daddy,” says Piper.<br>
                “We can draw them in our sketchbook!<br>
                We bring it all the time,” Suggests Alfa.<br>
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_3.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 10%; left: 12%; transform: translate(-10%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                The children take a look at the great green field.<br>
                There is a coop for the chicken family,<br>
                a small pond for the ducks to swim in,<br>
                and a large field for the horses to run daily.<br>
            </p>
        </div>
        <div style="position: absolute; top: 85%; left: 48.5%; transform: translate(-50%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem; white-space: nowrap;">
                “What about the barn? Who is living inside the barn?”<br>
                <span style="color: #d95293;">{{ $data['name'] }}</span> points at a huge red wooden house. They all rush<br>
                to the barn to see what kind of animal lives inside.<br>
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_4.png') }}" class="artwork_area">
        @if($data['image_1'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_1'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_1']) }}" style="
                height: 100%;
                position: absolute;
                left: 0;
                z-index: -1;
                top: 0;
                width: 100%;">
        @endif
        <div style="position: absolute; top: 85.5%; left: 29.5%; transform: translateX(-5%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                Oh, there are horses, cows and sheeps!
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_5.png') }}" class="artwork_area">
        @if($data['image_2'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_2'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_2']) }}" style="
                height: 100%;
                position: absolute;
                left: 0;
                z-index: -1;
                top: 0;
                width: 100%;">
        @endif
        <div style="position: absolute; top: 6.2%; left: 18.5%; transform: translateX(-5%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                Suddenly, they hear some noises coming from the haystack.<br>
                What could it be? <span style="color: #d95293;">{{ $data['name'] }}</span> walks closer and finds…<br>
            </p>
        </div>
        <div style="position: absolute; top: 85.5%; left: 33%; transform: translateX(-5%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                Oh, it’s just a hen and its chicks!
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_6.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 13%; left: 17%; transform: translate(-10%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                The children hold their artventure to take a bit of rest.<br>
                Alfa’s grandma holds quite a big banquet for them.<br>
                There is fresh milk, plenty of eggs, buttered corn<br>
                and a cheesecake on the big mat.<br>
            </p>
        </div>
        <div style="position: absolute; top: 83.5%; left: 54%; transform: translate(-10%, -40%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                The children enjoy the brunch,<br>
                and so did the friendly farm animals.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_7.png') }}" class="artwork_area">
        @if($data['image_3'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_3'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_3']) }}" style="position: absolute; z-index: -1; left: 48%; bottom: 0%; width: 33%; height: 33%;">
        @endif
        <div style="position: absolute; top: 16.5%; left: 24.5%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Then, the children took their time<br>
                to draw the ducks family. Unlike chicken, all the ducks<br>
                look similar to each other!<br><br>
                How do we tell them apart?
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_8.jpg') }}" class="artwork_area">
        @if($data['image_3'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_3'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_3']) }}" class="artwork">
        @endif
        <div style="position: absolute; top: 85%; left: 34%; transform: translate(-20%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                They even draw all the animal houses such as<br>
                barn, coop and the green wide field.<br><br>
                All the farm animals are curious of what their<br>
                outcome will be.<br>
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_9.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 13%; left: 12%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Soon, the Sun sets, marking the end of their short adventure.<br>   
                The children wave goodbye to the animals as they return to their homes.
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_10.png') }}" class="artwork_area">
        @if($data['image_4'] && file_exists(storage_path('app/public/art_gallery/' . $data['image_4'])))
            <img src="{{ public_path('/storage/art_gallery/'.$data['image_4']) }}" style="height: 86%; width: 86%; position: absolute; z-index: -1; left: 9.3%; top: 7.3%;">
        @endif
        <div style="position: absolute; top: 15%; left: 52.5%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem; white-space: nowrap;">
                “I think we have made a good memory here,”<br>
                Says <span style="color: #d95293">{{ $data['name'] }}</span> while looking at the painting in his sketchbook.
            </p>
        </div>
    </div>
    <div class="artwork_container">
        <div style="position: absolute; top: 50%; left: 20%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Soon, the bus starts moving, leaving the peaceful country<br>
                to be remembered in their hearts and their drawings.<br>
                <span class="century_gothic bold" style="line-height: 2rem; font-size: 21px;">The end.</span>
            </p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbooks/level_1/artventure_to_the_farm/page_11.jpg') }}" class="artwork_area">
        <div style="font-size: 26px; text-align: center; letter-spacing: 0.05em; position: absolute; top: 26%; left: 50%; transform: translate(-50%, -50%); z-index: 1; white-space: nowrap;">
            <p class="candy_beans" style="display: inline-block; color: #d95293;">{{ $data['name'] }}'s</p> 
            <p class="candy_beans" style="display: inline-block; color: #f68b22;">Artventure</p> 
            <p class="candy_beans" style="display: inline-block; color: #13a8b5;">to the Farm</p>
        </div>
        <div style="text-align: center; letter-spacing: 0em; position: absolute; top: 47%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 15px; letter-spacing: 0.05em; line-height: 0.95rem; white-space: nowrap;">
                Alfa invites everyone to come to his grandpa farm. There,<br>
                they discover varieties of farm animals.<br><br>
                <span style="color: #d95293">{{ $data['name'] }}</span> wonders what animal lives inside the barn and goes<br>
                to investigate.<br><br>
                Then <span style="color: #d95293">{{ $data['name'] }}</span> come across a family of chicken and study how<br>
                each of them are different.<br><br>
                Unlike the chicken, the duck family at the pond look so<br>
                much alike from each other. How to tell them apart?<br><br>
                Lastly, <span style="color: #d95293">{{ $data['name'] }}</span> put all the animals together with their houses<br>
                to complete the farm scenery.
            </p>
        </div>
    </div>
</body></html>