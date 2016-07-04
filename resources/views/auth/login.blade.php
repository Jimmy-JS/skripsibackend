<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Alumni Backend</title>
        <link rel="shortcut icon" href="{{{ asset('assets/images/favicon.png') }}}">
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/fonts/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet">
        <!-- Custom styling plus plugins -->
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/icheck/flat/green.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/sweetalert/dist/sweetalert.css') }}">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="background:#F7F7F7;">
        <div class="">
            <div id="wrapper">
                <div id="login" class="animate form">
                    <section class="login_content">
                        <img src="{{ asset('assets/images/logo.png') }}" width="150px" alt="" class="img-circle" style="border: 1px solid #cfd3d8;padding: 3px;">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}
                            <h1>Login</h1>
                            <div class="{{ $errors->has('email') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" name="email" placeholder="Email" required=""  value="{{ old('email') }}" />
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="{{ $errors->has('password') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" name="password" placeholder="Password" required="" value="{{ old('password') }}" />
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i>  Login
                                    </button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator"></div>
                        </form>
                        <!-- form -->
                    </section>
                    <!-- content -->
                </div>
            </div>
        </div>

        <!-- Sweet Alert notifications  -->
        <script>
            @if(Session::has('notif_error'))
                swal({
                    title: "Error",
                    text: "{{{ Session::get('notif_error') }}}",
                    type: "error",
                    html: true
                });
            @endif
        </script>
        <!-- Sweet Alert end -->
    </body>
</html>