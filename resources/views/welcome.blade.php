<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Search Engine System</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                min-height: 100vh;
                margin: 0;
            }

            .full-height {
                min-height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .content input {
                width: 300px;
                height: 25px;
            }

            .content button {
                height: 33px;
                width: 100px;
                border: none;
            }

            .content button:hover {
                background-color: #979c9f;
                cursor: pointer;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .results {
                margin-top: 30px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Search Engine System
                </div>
                <div class="links">
                    <input type="text" placeholder="Введите слово или фразу для поиска">
                    <button>Найти</button>
                </div>
                @isset($results)
                <div class="results">
                    <b>Результаты поиска</b><br>
                    @foreach ($results as $result)
                        <a>{{ $result }}</a><br>
                    @endforeach
                </div>
                @endisset
            </div>
        </div>
    </body>
</html>
