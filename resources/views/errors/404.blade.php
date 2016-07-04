<!DOCTYPE html>
<html>
    <head>
        <title>Not Found</title>

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
                color: #3fa9c1;
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
                border-bottom: 1px dashed #3fa9c1;
                color: #3fa9c1;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <object type="image/svg+xml" data="{{ asset('assets/images/404.svg') }}" width="300px">
                    404
                </object>
                <div class="title">Page Not Found :(</div>
                <p><a class="back" href="{{ url('/') }}">< Back to home</a></p>
            </div>
        </div>
    </body>
</html>
