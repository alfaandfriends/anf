
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Artbook</title>
    <style type="text/css">
        @font-face {
            font-family: 'Century Gothic';
            src: url('{{ public_path("/images/artbook/fonts/Century Gothic.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Candy Beans';
            src: url('{{ public_path("/images/artbook/fonts/Candy Beans.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Myriad Pro';
            src: url('{{ public_path("/images/artbook/fonts/Myriad Pro Regular.ttf") }}') format('truetype');
        }
        @page { margin: 0px; }
        body { margin: 0px; }
        .candy_beans{
            font-family: 'Candy Beans', sans-serif;
        }
        .century_gothic{
            font-family: 'Century Gothic', sans-serif;
        }
        .myriad_pro{
            font-family: 'Myriad Pro', sans-serif;
        }
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
        }
        .artwork{
            height: 663px;
            position: absolute;
            left: 14%;
            z-index: -1;
            top: 18%;
            width: 77%;
        }
        .page_break { 
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div style="position: relative;">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/cover.jpg') }}" style="width: 100%">
        <div style="position: absolute; top: 12.1%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <p class="candy_beans" style="text-align: center; font-size: 40px; color: #d95293; letter-spacing: 0em;">Hamza Ya</p>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="page_break"></div>
    <div class="position: relative;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <div style="text-align: center; ">
                <span class="myriad_pro" style="font-size: 40px; color: #414042; letter-spacing: 0.05rem; line-height: 2rem">Jebat’s Artventure to the Beach</span>
            </div>
            <div style="text-align: center; ">
                <span class="myriad_pro" style="font-size: 20px; color: #414042; letter-spacing: 0.05rem; line-height: 2rem">Story by:</span>
            </div>
            <div style="text-align: center; ">
                <span class="myriad_pro" style="font-size: 20px; color: #414042; letter-spacing: 0.05rem; line-height: 2rem">ALFA and Friends</span>
            </div>
            <div style="text-align: center; ">
                <span class="myriad_pro" style="font-size: 20px; color: #414042; letter-spacing: 0.05rem; line-height: 2rem">Illustrated by:</span>
            </div>
            <div style="text-align: center; ">
                <span class="myriad_pro" style="font-size: 20px; color: #414042; letter-spacing: 0.05rem; line-height: 2rem">ALFA and Friends and Jebat</span>
            </div>
        </div>
    </div>
    <div class="position: relative;">
        <div style="position: absolute; top: 50%; left: 50%; text-align: center; ">
            <span class="myriad_pro" style="font-size: 12px; color: #414042; letter-spacing: 0.05rem; line-height: 0rem">
                Copyright © 2023 ALFA and Friends Sdn. Bhd. All rights reserved. All characters and story contained therein this book is the sole property of the publisher. No part of the content may be reproduced or transmitted in any form or by means, electronic or mechanical, including photocopying, recording, or by any information storage and retrievel system without written permission.
            </span>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_1.jpg') }}" class="artwork_area">
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_2.jpg') }}" class="artwork_area">
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_3.jpg') }}" class="artwork_area">
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_4.jpg') }}" class="artwork_area">
    </div>
    <div class="page_break"></div>
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/page_5.jpg') }}" class="artwork_area">
    </div>
</body></html>