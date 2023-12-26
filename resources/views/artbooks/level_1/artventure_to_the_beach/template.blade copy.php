
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Order#{{ $data['order_number'] }}</title>
    <style type="text/css">
        @font-face {
            font-family: 'Candy Beans';
            font-weight: 400;
            font-style: normal;
            src: url('{{ public_path("/images/artbook/font/Candy Beans.ttf") }}') format('truetype');
        }
        @page { margin: 0px; }
        body { margin: 0px; }
        .candy_beans{
            font-family: 'Candy Beans', sans-serif;
        }
        .student_name_container{    
            position: fixed;
            right: 20%;
            text-align: center;
            padding: 19px;
            top: 10%;
        }
        .student_name{
            z-index: 1;
            text-align: center;
            color: rgb(241,99,153);
            font-size: 55px;
        }
        .front-page{
            width: 100%; 
            height: 100%;
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
    <div class="artwork_container">
        <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/images/cover.jpg') }}">" alt="" style="width: 100%;">
        <div class="student_name_container">
            <p class="candy_beans student_name"><?php echo $student_name?></p>
        </div>
    </div>
    <div class="page_break">
        <div class="artwork_container">
            <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/images/sketch.png') }}" class="artwork_area" alt="">
            <img src="{{ public_path('/images/artbook/templates/level_1/artventure_to_the_beach/images/level_1.jpg') }}" class="artwork" alt="">
        </div>
    </div>
</body></html>