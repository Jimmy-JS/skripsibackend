<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{{ asset('assets/images/favicon.png') }}}">
        <title>
            @section('title')
            | Alumni Backend
            @show
        </title>
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/fonts/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet">
        <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/sweetalert/dist/sweetalert.css') }}">
        <!-- Custom styling plus plugins -->
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
        <!-- <script src="{{ asset('assets/js/nprogress.js') }}"></script> untuk loading d atas yang warna biru -->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        @yield('header_styles')
        <!--end of page level css-->
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('partials.left-menu')
                @include('partials.top-nav')
                <div class="right_col" role="main">
                    @yield('content')
                </div>
                <!-- /page content -->
            </div>
        </div>
        <div id="custom_notifications" class="custom-notifications dsp_none">
            <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
            </ul>
            <div class="clearfix"></div>
            <div id="notif-group" class="tabbed_notifications"></div>
        </div>
        <!-- Global Script -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/livicons/minified/raphael-min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/livicons/minified/livicons-1.4.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/nicescroll/jquery.nicescroll.min.js') }}"></script>
        <!-- Sweet Alert notifications  -->
        <script>
            @if(Session::has('notif_success'))
                swal("Success", "{!! Session::get('notif_success') !!}", "success");
            @endif
            @if(Session::has('notif_error'))
                swal("Error", "{!! Session::get('notif_error') !!}", "error");
            @endif
            @if(Session::has('notif_info'))
                swal("Info", "{!! Session::get('notif_info') !!}", "info");
            @endif
        </script>
        <!-- Sweet Alert end -->

        <script>
            $(function() {
              var cnt = 10; //$("#custom_notifications ul.notifications li").length + 1;
              TabbedNotification = function(options) {
                var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
                  "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";
            
                if (document.getElementById('custom_notifications') == null) {
                  alert('doesnt exists');
                } else {
                  $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
                  $('#custom_notifications #notif-group').append(message);
                  cnt++;
                  CustomTabs(options);
                }
              }
            
              CustomTabs = function(options) {
                $('.tabbed_notifications > div').hide();
                $('.tabbed_notifications > div:first-of-type').show();
                $('#custom_notifications').removeClass('dsp_none');
                $('.notifications a').click(function(e) {
                  e.preventDefault();
                  var $this = $(this),
                    tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
                    others = $this.closest('li').siblings().children('a'),
                    target = $this.attr('href');
                  others.removeClass('active');
                  $this.addClass('active');
                  $(tabbed_notifications).children('div').hide();
                  $(target).show();
                });
              }
            
              CustomTabs();
            
              var tabid = idname = '';
              $(document).on('click', '.notification_close', function(e) {
                idname = $(this).parent().parent().attr("id");
                tabid = idname.substr(-2);
                $('#ntf' + tabid).remove();
                $('#ntlink' + tabid).parent().remove();
                $('.notifications a').first().addClass('active');
                $('#notif-group div').first().css('display', 'block');
              });
            })
        </script>
        <!-- End Tabbed Notifications -->

        @yield('footer_styles')

        <!-- pace -->
        <script src="{{ asset('assets/js/pace/pace.min.js') }}"></script> <!-- Untuk loading atas yg warna ijo -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        <!-- 
        <script>
            NProgress.done(); //untuk loading d atas yang warna biru
        </script>
        -->
        <!-- /datepicker -->
        <!-- /footer content -->
    </body>
</html>