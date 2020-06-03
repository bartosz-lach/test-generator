<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ URL::asset('css/app.css') }} "> --}}
    <style>

        body { font-family: DejaVu Sans, sans-serif; }

        .container{

            /* padding: 2cm; */
            /* margin: 2cm; */
        }

        .header{
            font-size: 16px;
            font-weight: 600;
            display: inline-block;

        }

        .version-name{
            float: right;
            font-size: 16px;
        }

        table, th, td {

            border: 1px solid black;
            /* border-collapse: collapse; */
        }

        li{
            font-size: 12px;
        }

        .question{
            margin-bottom: 9px;
        }

        .cell-table{
            height: 0.7cm;
            width: 0.7cm;
            text-align: center;
        }

        .false-answer{
            background-color: black;
            /* height: 1cm;
            width: 1cm; */
        }
        .true-answer{
            background-color: white;
            /* height: 1cm;
            width: 1cm; */
        }

        .student-info{
            margin-top: .7cm;
        }

        .name-box{
            height: 1.2cm;
            width: 4.25cm;
            border: 1px solid black;
            display: inline-block;
            margin-right: 0.2cm;
        }

        .caption{
            margin:  0.15cm;
            font-size: 8px;
            display: block;
        }

        .questions-table{
            margin-top: 0.7cm;
        }
</style>
    <title>Document</title>
</head>
<body>
        <div class="container">
                <p class="header">{{ $version['content']['subject'] }} - {{$version['content']['name'] }} </p> 
                <p class="version-name">{{ $version['name'] }}</p>
                @yield('content')
        </div>
</body>
</html>