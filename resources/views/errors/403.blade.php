<!DOCTYPE html>
<html>
    <head>
        <title>Forbidden</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="{{{ asset('assets/images/favicon.png') }}}">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }

            .back {
                text-decoration: none;
                border-bottom: 1px dashed #B0BEC5;
                color: #6a7377;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">You're Not Authorized</div>
                <p><a class="back" href="{{ url('/') }}">< Back to home</a></p>
            </div>
        </div>
    </body>
</html>
