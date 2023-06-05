

<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> {{$page_title}} | {{$site_title}}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/favicon.png') }}">
    <link href="{{asset('public/assets/admin/css/style.css')}}" rel="stylesheet">

</head>

<body class="h-100">

<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
        </svg>
    </div>
</div>
<!--*******************
    Preloader end
********************-->

<div class="login-form-bg h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-6">
                <div class="form-input-content">

                    <div class="card login-form mb-0">
                        @if (session()->has('message'))
                            <div class="alert alert-warning alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-icon-left alert-warning alert-dismissible mb-1" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {!!  $error !!}
                                </div>

                            @endforeach
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!--**********************************
    Scripts
***********************************-->
<script src="{{asset('public/assets/admin/plugins/common/common.min.js')}}"></script>
<script src="{{asset('public/assets/admin/js/custom.min.js')}}"></script>
<script src="{{asset('public/assets/admin/js/settings.js')}}"></script>
<script src="{{asset('public/assets/admin/js/gleek.js')}}"></script>
<script src="{{asset('public/assets/admin/js/styleSwitcher.js')}}"></script>
</body>
</html>





