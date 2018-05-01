<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                box-sizing: border-box;
                padding-top: 25px;
                height: 100vh;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                font-weight: bold;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 25px;
            }

            .github-button {
                background-color: #699943;
                color: #ffffff;
                border: 0;
                padding: 25px;
                font-size: 25px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <img src="/img/trees.svg">
                    {{ config('app.name') }}
                </div>

                <div class="links m-b-md">
                    <a href="https://bouncefirst.com">Bouncefirst</a>
                    <a href="https://laravel.com">Laravel</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://reddit.com/r/laravel">Reddit</a>
                    <a href="https://github.com">GitHub</a>
                </div>

                <div>
                    <a href="{{ action('Auth\LoginController@redirectToProvider') }}">
                        <button class="github-button">Login with GitHub</button>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
