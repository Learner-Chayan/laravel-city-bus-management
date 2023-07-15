***********************************-->
<div class="nav-header">
    <div class="brand-logo">
        <a href="{{route('dashboard')}}">
            <b class="logo-abbr"><img src="{{asset('public/logo.png') }}" alt=""> </b>
            <span class="brand-title">
                <img style="margin-top: -39px;width: 200px; height: 100px;" src="{{asset('public/logo.png') }}" alt="">
            </span>
        </a>
    </div>
</div>
<!--**********************************
    Nav header end
***********************************-->

<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content clearfix">

        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>

        <div class="header-right">
            <ul class="clearfix">
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                        @if(Auth::user()->image != null)
                            <img height="40" width="40" src="{{ asset('public/images/user') }}/{{ Auth::user()->image }}" class="user-image" alt="User Image">
                        @else
                            <img src="{{ asset('public/default.png') }}" class="user-image" alt="User Image">
                        @endif
                    </div>
                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="{{route('edit-profile')}}"><i class="icon-user"></i> <span>Profile</span></a>
                                </li>
{{--                                <li>--}}
{{--                                    <a href="{{route('purchase.history')}}"><i class="icon-user"></i> <span>Purchase History </span></a>--}}
{{--                                </li>--}}
                                <hr class="my-2">
                                <li>
                                    <a href="{{route('password')}}"><i class="icon-lock"></i> <span>Change Password</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();"><i class="icon-key"></i> <span>Logout</span></a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--**********************************
