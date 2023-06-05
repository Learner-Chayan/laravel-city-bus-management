<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title> {{$page_title}} | {{$site_title}}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/favicon.png') }}">
    <link href="{{asset('public/assets/admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/admin/plugins/toastr/css/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!-- Toggle css -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/toggle.min.css')}}">
    <!-- file css -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/file/bootstrap-fileinput.css')}}">
    <!-- summer note css -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/plugins/summernote/dist/summernote.css')}}">
    <!-- data table -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/advanceTable/datatable.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/advanceTable/datatable.button.min.css')}}">
    @stack('css')

</head>

<body>

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


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
        @include('admin.partial.topbar')
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
        @include('admin.partial.sidebar')
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">

        <div class="container-fluid mt-3">
            @if($errors->any())
                @foreach ($errors->all() as $error)

                    <div class="row">
                        <div class="col-md-8 offset-2">
                            <div class="alert alert-icon-left alert-warning alert-dismissible mb-1" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {!!  $error !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @yield('content')
        </div>
        <!-- #/ container -->
    </div>
    <!--**********************************
        Content body end
    ***********************************-->


    <!--**********************************
        Footer start
    ***********************************-->
    <div class="footer">
        <div class="copyright text-center">
           <p>{!! $basic->copy !!}</p>
        </div>
    </div>
    <!--**********************************
        Footer end
    ***********************************-->
</div>
<!--**********************************
    Main wrapper end
***********************************-->

<!--**********************************
    Scripts
***********************************-->
<script src="{{asset('public/assets/admin/plugins/common/common.min.js')}}"></script>
<script src="{{asset('public/assets/admin/js/custom.min.js')}}"></script>
<script src="{{asset('public/assets/admin/js/settings.js')}}"></script>
<script src="{{asset('public/assets/admin/js/gleek.js')}}"></script>
<script src="{{asset('public/assets/admin/js/styleSwitcher.js')}}"></script>
<script src="{{asset('public/assets/admin/js/dashboard/dashboard-1.js')}}"></script>
<!-- Toastr js -->
<script src="{{asset('public/assets/admin/plugins/toastr/js/toastr.min.js')}}"></script>
<!-- Toggle js -->
<script src="{{asset('public/assets/admin/js/toggle.min.js')}}"></script>

<!-- File js -->
<script src="{{asset('public/assets/admin/file/bootstrap-fileinput.js')}}"></script>
<!-- summer note js -->
<script src="{{asset('public/assets/admin/plugins/summernote/dist/summernote.min.js')}}"></script>
<script src="{{asset('public/assets/admin/plugins/summernote/dist/summernote-init.js')}}"></script>
<!-- Select 2 -->
<script src="{{asset('public/assets/admin/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Data table js -->
<script src="{{asset('public/assets/admin/advanceTable/datatable.min.js')}}"></script>
<script src="{{asset('public/assets/admin/advanceTable/datatable.button.min.js')}}"></script>
<script src="{{asset('public/assets/admin/advanceTable/pdf-maker.min.js')}}"></script>
<script src="{{asset('public/assets/admin/advanceTable/zip.min.js')}}"></script>
<script src="{{asset('public/assets/admin/advanceTable/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/assets/admin/advanceTable/pdf.vs_font.min.js')}}"></script>

<script>
    //toastr alert

    @if(Session::has('message'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.success("{{ session('message') }}");
    @endif

        @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.error("{{ session('error') }}");
    @endif

        @if(Session::has('info'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.info("{{ session('info') }}");
    @endif

        @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.warning("{{ session('warning') }}");
    @endif

//select2
    $(document).ready(function() {
        $('.select2').select2();
    });
//Data table
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50,100, -1 ],
                [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
            ],
            buttons: [
                {
                    extend: 'pageLength',
                },

                {
                    extend: 'excelHtml5',
                    title: '{{$basic->title}} Data Export',

                },
                {
                    extend: 'pdfHtml5',
                    title: '{{$basic->title}} Data Export',
                },

                // 'pageLength',
                // 'excelHtml5',
                // 'pdfHtml5'
            ]
        } );

    } );

</script>
 @stack('js')
</body>

</html>
