
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Artbook</title>
    <style type="text/css">
        @page { margin: 0px; }
        @font-face {
            font-family: 'Candy Beans';
            src: url('{{ public_path("/images/artbook/fonts/candy_beans/Candy Beans.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Century Gothic';
            src: url('{{ public_path("/images/artbook/fonts/century_gothic/GOTHIC.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Century Gothic Bold';
            src: url('{{ public_path("/images/artbook/fonts/century_gothic/GOTHICB.ttf") }}') format('truetype');
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
            height: 69.6%;
            position: absolute;
            z-index: -1;
            left: 16%;
            top: 16%;
            width: 69.6%;
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
    <!-- <div style="position: relative;">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/cover.jpg') }}" style="width: 100%">
        <div style="position: absolute; top: 12.1%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="candy_beans" style="text-align: center; font-size: 40px; color: #d95293; letter-spacing: 0em;">{{ $data['name'] }}'s</p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="position: relative;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="century_gothic bold" style="font-size: 40px; letter-spacing: 0.05rem; line-height: 2rem;">{{ $data['name'] }}'s Artventure to the Beach</span>
            </div>
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="century_gothic" style="display: block; font-size: 18px; letter-spacing: 0.05rem; line-height: 1.5rem">Story by:</span>
                <span class="century_gothic" style="display: block; font-size: 18px; letter-spacing: 0.05rem; line-height: 1.5rem">ALFA and Friends</span>
            </div>
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="century_gothic" style="display: block; font-size: 18px; letter-spacing: 0.05rem; line-height: 1.5rem">Illustrated by:</span>
                <span class="century_gothic" style="display: block; font-size: 18px; letter-spacing: 0.05rem; line-height: 1.5rem">ALFA and Friends and Jebat</span>
            </div>
        </div>
        <div style="position: absolute; top: 82%; left: 16%; transform: translate(-10%, 0%); text-align: justify;">
            <p class="century_gothic" style=" font-size: 13px; letter-spacing: 0.05rem; line-height: 0.8rem">
                Copyright © 2023 ALFA and Friends Sdn. Bhd. All rights reserved. All characters and story contained therein this book is the sole property of the publisher. No part of the content may be reproduced or transmitted in any form or by means, electronic or mechanical, including photocopying, recording, or by any information storage and retrievel system without written permission.
            </p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_1.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 18%; left: 39%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                <span style="color: #d95293;">{{ $data['name'] }}</span> 
                along with Alfa and his friends are going to the beach to paint the scenery. The blue sky greets them at the beach. They find a place to sit and lay down their picnic mat.
            </p>
        </div>
        <div style="position: absolute; top: 88%; left: 30%; transform: translateX(-20%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                “Wow, what a wonderful view!” Says Piper in admiration.
            </p>
        </div>
        <div class="page_number_left">
            <p class="century_gothic" style="text-align: center; font-size: 17px; letter-spacing: 0.05em; line-height: 1.25rem">
                1
            </p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_2.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 14%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                The children take out their sketchbooks and start painting. 
            </p>
        </div>
        <div style="position: absolute; top: 22%; left: 53%; transform: translate(-55%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                “But… how do we start painting?”
                <span style="color: #d95293;">{{ $data['name'] }}</span> asks.
            </p>
        </div>
        <div style="position: absolute; top: 75%; left: 48%; transform: translateX(-30%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                “Let’s start by drawing the lines first!”<br>
                Piper suggests.<br>
                “Can you see any straight lines, wavy lines,<br>
                or curvy lines in the scenery?” She asks.<br>
            </p>
        </div>
        <div class="page_number_right">
            <p class="century_gothic" style="text-align: center; font-size: 17px; letter-spacing: 0.05em; line-height: 1.25rem">
                2
            </p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_3.png') }}" class="artwork_area">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/level_1.jpg') }}" style="
            height: 100%;
            position: absolute;
            left: 0;
            z-index: -1;
            top: 0;
            width: 100%;">
        <div style="position: absolute; top: 12%; left: 25%; transform: translate(-15%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “Look at the end of the sea. That is a straight line!” Says Alfa.<br>
                “The tides! It looks just like a wavy line!” Says Patch.<br>
                “And the clouds… They are curved lines!” Says Ollie.
            </p>
        </div>
        <div style="position: absolute; top: 76%; left: 15%; transform: translateX(-5%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
            “Brilliant! Lines are the simplest element in design.<br>
            If you can draw the lines, then you can draw almost everything!”<br>
            Exclaims Piper.<br>
            With that in mind, everyone starts drawing on their canvas.
            </p>
        </div>
        <div class="page_number_left">
            <p class="century_gothic" style="text-align: center; font-size: 17px; letter-spacing: 0.05em; line-height: 1.25rem">
                3
            </p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_4.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 14%; left: 40%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “But…how about the sailboat and the<br>
                lighthouse? There are so many lines<br>
                and they go in so many directions!”<br>
                <span style="color: #d95293;">{{ $data['name'] }}</span> is confused all over again. <br>
            </p>
        </div>
        <div style="position: absolute; top: 80%; left: 35%; transform: translateX(-5%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                “That is true indeed!” Says Piper. Then she continues,<br>
                “How about we break down those tricky objects<br>
                into several shapes like circle, triangle, square and<br>
                rectangle.”
            </p>
        </div>
        <div class="page_number_right">
            <p class="century_gothic" style="text-align: center; font-size: 17px; letter-spacing: 0.05em; line-height: 1.25rem">
                4
            </p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_5.jpg') }}" class="artwork_area">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/level_1.jpg') }}" style="
            height: 100%;
            position: absolute;
            left: 0;
            z-index: -1;
            top: 0;
            width: 100%;">
        <div style="position: absolute; top: 25%; left: 15%; transform: translate(-20%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “Oh, I know! The sail of the boat is<br>
                made up of a giant triangle!” Says<br>
                Patch.<br><br>
                “The skipper room is a rectangle<br>
                with a square window,” says Ollie.<br><br>
                “And the boat is a combination of<br>
                a long rectangle and a triangle<br>
                at both ends.” Says Alfa.
            </p>
        </div>
        <div style="position: absolute; top: 79%; left: 35%; transform: translateX(-13%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem;">
                “Well done, everyone! Shapes are the basic design<br>
                element just like the lines. So, if you are able to draw<br>
                shapes, you can draw almost everything!” Says Piper.
            </p>
        </div>
        <div class="page_number_left">
            <p class="century_gothic" style="text-align: center; font-size: 17px; letter-spacing: 0.05em; line-height: 1.25rem">
                5
            </p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_6.png') }}" class="artwork_area">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/level_1.jpg') }}" class="artwork">
        <div style="position: absolute; top: 10%; left: 20%; transform: translate(-10%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                Now everyone can put their mind to their sketchbook.<br>
                Their blank canvas is now filled with all kinds of lines and shapes.
            </p>
        </div>
        <div class="page_number_right">
            <p class="century_gothic" style="text-align: center; font-size: 17px; letter-spacing: 0.05em; line-height: 1.25rem">
                6
            </p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_7.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 16%; left: 19%; transform: translate(-20%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: left; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “Look over there! It is a huge whale!”<br>
                <span style="color: #d95293;">{{ $data['name'] }}</span> points to the far end of the sea.<br>
                “Let’s draw the whale too!” Suggests Alfa.<br>
                “And crabs!” Ollie adds.<br>
                “And don’t forget the turtle and starfish too!” Says Piper.
            </p>
        </div>
        <div class="page_number_left">
            <p class="century_gothic" style="text-align: center; font-size: 17px; letter-spacing: 0.05em; line-height: 1.25rem">
                7
            </p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <!-- <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_8.png') }}" class="artwork_area">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/level_1.jpg') }}" class="artwork">
        <div style="position: absolute; top: 10%; left: 30%; transform: translate(-20%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
            There are really so many things to draw at the beach.<br>
            The children take their time drawing and colouring all the<br>
            animals they find.
            </p>
        </div>
        <div class="page_number_right">
            <p class="century_gothic" style="text-align: center; font-size: 17px; letter-spacing: 0.05em; line-height: 1.25rem">
                8
            </p>
        </div>
    </div> -->
    <!-- <div class="page_break"></div> -->
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_9.jpg') }}" class="artwork_area">
        <div style="position: absolute; top: 16%; left: 13%; transform: translate(-5%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                “I wonder, what more can we add to our scenery?” <span style="color: white">{{ $data['name'] }}</span> asks.<br><br>
                “Just add whatever fun things come to your mind<br>
                when you think of the beach,” says Piper.
            </p>
        </div>
        <div style="position: absolute; top: 45%; left: 30%; transform: translate(-20%, -50%); z-index: 1;">
            <p class="century_gothic" style="text-align: center; font-size: 19px; letter-spacing: 0.05em; line-height: 1.1rem">
                <span style="color: white">{{ $data['name'] }}</span> grins and pulls out his box full of paints.<br>
                “I think I know what..”<br>
                And so everyone begins painting,<br>
                watched by the Sun as it settles down.
            </p>
        </div>
        <div class="page_number_left">
            <p class="century_gothic" style="text-align: center; font-size: 17px; letter-spacing: 0.05em; line-height: 1.25rem">
                9
            </p>
        </div>
    </div>
</body></html>