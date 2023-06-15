***********************************-->
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Dashboard</li>
            <li><a class="{{Request::is('dashboard') ? 'active' : ''}}" href="{{route('dashboard')}}"><i class="icon-speedometer"></i><span class="nav-text">Dashboard</span></a></li>
            <li><a class="{{Request::is('admin/bus') ? 'active' : ''}}" href="{{route('bus.index')}}"><i class="icon-star"></i><span class="nav-text">Bus</span></a></li>
            <li><a class="{{Request::is('admin/route') ? 'active' : ''}}" href="{{route('route.index')}}"><i class="icon-star"></i><span class="nav-text">Route</span></a></li>
            <li><a class="{{Request::is('admin/stoppage') ? 'active' : ''}}" href="{{route('stoppage.index')}}"><i class="icon-star"></i><span class="nav-text">Stoppage</span></a></li>
            <li><a class="{{Request::is('admin/owner') ? 'active' : ''}}" href="{{route('owner.index')}}"><i class="icon-user-follow"></i><span class="nav-text">Bus Owner</span></a></li>
            <li><a class="{{Request::is('admin/customer') ? 'active' : ''}}" href="{{route('customer.index')}}"><i class="icon-user-unfollow"></i><span class="nav-text">Customer</span></a></li>
            <li class="{{Request::is('admin/driver') ? 'active' : ''}}">
                <a class="has-arrow" aria-expanded="false">
                    <i class="icon-user-following "></i><span class="nav-text">Employee</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('driver.index')}}">Driver</a></li>
                    <li><a href="{{route('driver.index')}}">TT</a></li>
                    <li><a href="{{route('driver.index')}}">Helper</a></li>
                </ul>
            </li>
            <li class="{{Request::is('admin/get-basic') ? 'active' : ''}}">
                <a class="has-arrow" aria-expanded="false">
                    <i class="icon-settings "></i><span class="nav-text">Basic Setting</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('get-basic')}}">Website Basic</a></li>
                </ul>
            </li>
            <li>
                <a class="{{Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/users/*/edit') ? 'active' : ''}}" href="{{route('users.index')}}"><i class="icon-user"></i><span class="nav-text">System User</span></a>
            </li>
            <li class="{{Request::is('admin/permissions') || Request::is('admin/permissions/create') || Request::is('admin/permissions/*/edit') ||Request::is('admin/roles') || Request::is('admin/roles/create') || Request::is('admin/roles/*/edit') ? 'active' : ''}}">
                <a class="has-arrow" aria-expanded="false">
                    <i class="icon-settings menu-icon"></i><span class="nav-text">Role & Permission</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="{{Request::is('admin/permissions') || Request::is('admin/permissions/create') || Request::is('admin/permissions/*/edit') ? 'active' : ''}}" href="{{route('permissions.index')}}">Permission</a></li>
                    <li><a class="{{Request::is('admin/roles') || Request::is('admin/roles/create') || Request::is('admin/roles/*/edit') ? 'active' : ''}}" href="{{route('roles.index')}}">Role</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!--**********************************
