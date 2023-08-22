***********************************-->
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Dashboard</li>
            @role('admin')
            <li><a class="{{Request::is('dashboard') ? 'active' : ''}}" href="{{route('dashboard')}}"><i class="icon-speedometer"></i><span class="nav-text">Dashboard</span></a></li>
            @endrole
            @role('admin|customer')
            <li><a class="{{Request::is('ticket') ? 'active' : ''}}" href="{{route('ticket')}}"><i class="fa fa-ticket"></i><span class="nav-text">Ticket</span></a></li>
            @endrole
            @role('admin|checker|customer')
            <li><a class="{{Request::is('admin/purchase-history') ? 'active' : ''}}" href="{{route('purchase.history')}}"><i class="fa fa-history"></i><span class="nav-text">Purchase History</span></a></li>
            @endrole
            @role('admin|owner|checker|helper|driver')
            <li><a class="{{Request::is('admin/trip') ? 'active' : ''}}" href="{{route('trip.index')}}"><i class="icon-star"></i><span class="nav-text">Trip</span></a></li>
            @endrole
            @role('admin|owner')
            <li><a class="{{Request::is('admin/bus') ? 'active' : ''}}" href="{{route('bus.index')}}"><i class="fa fa-bus"></i><span class="nav-text">Bus</span></a></li>
            @endrole
            @role('admin|owner')
            <li class="{{Request::is('admin/driver') || Request::is('admin/driver/*/edit') || Request::is('admin/ticket-checker') || Request::is('admin/ticket-checker/*/edit') || Request::is('admin/helper') || Request::is('admin/helper/*/edit') ? 'active' : ''}}">
                <a class="has-arrow" aria-expanded="false">
                    <i class="icon-user-following "></i><span class="nav-text">Employee</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('driver.index')}}">Driver</a></li>
                    <li><a href="{{route('ticket-checker.index')}}">Ticket Checker</a></li>
                    <li><a href="{{route('helper.index')}}">Helper</a></li>
                </ul>
            </li>
            @endrole
            @role('admin|owner|checker|customer')
            <li><a class="{{Request::is('admin/ticketValidation') ? 'active' : ''}}" href="{{route('ticket.validate')}}"><i class="fa fa-calculator"></i><span class="nav-text">Ticket Validation</span></a></li>
            @endrole
            @role('admin')
            <li><a class="{{Request::is('admin/fare') ? 'active' : ''}}" href="{{route('fare.index')}}"><i class="fa fa-calculator"></i><span class="nav-text">Fare Calculation</span></a></li>
            @endrole
            @role('admin')
            <li><a class="{{Request::is('admin/route') ? 'active' : ''}}" href="{{route('route.index')}}"><i class="fa fa-road"></i><span class="nav-text">Route</span></a></li>
            @endrole
            @role('admin')
            <li><a class="{{Request::is('admin/stoppage') ? 'active' : ''}}" href="{{route('stoppage.index')}}"><i class="fa fa-stop-circle"></i><span class="nav-text">Stoppage</span></a></li>
            @endrole
            @role('admin')
            <li><a class="{{Request::is('admin/owner') ? 'active' : ''}}" href="{{route('owner.index')}}"><i class="icon-user-follow"></i><span class="nav-text">Bus Owner</span></a></li>
            @endrole
            @role('admin')
            <li><a class="{{Request::is('admin/customer') ? 'active' : ''}}" href="{{route('customer.index')}}"><i class="icon-user-unfollow"></i><span class="nav-text">Customer</span></a></li>
            @endrole
            @role('admin')
            <li class="{{Request::is('admin/get-basic') ? 'active' : ''}}">
                <a class="has-arrow" aria-expanded="false">
                    <i class="icon-settings "></i><span class="nav-text">Basic Setting</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('get-basic')}}">Website Basic</a></li>
                </ul>
            </li>
            @endrole
            @role('admin')
            <li>
                <a class="{{Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/users/*/edit') ? 'active' : ''}}" href="{{route('users.index')}}"><i class="icon-user"></i><span class="nav-text">System User</span></a>
            </li>
            @endrole
            @role('admin')
{{--            <li class="{{Request::is('admin/permissions') || Request::is('admin/permissions/create') || Request::is('admin/permissions/*/edit') ||Request::is('admin/roles') || Request::is('admin/roles/create') || Request::is('admin/roles/*/edit') ? 'active' : ''}}">--}}
{{--                <a class="has-arrow" aria-expanded="false">--}}
{{--                    <i class="icon-settings menu-icon"></i><span class="nav-text">Role & Permission</span>--}}
{{--                </a>--}}
{{--                <ul aria-expanded="false">--}}
{{--                    <li><a class="{{Request::is('admin/permissions') || Request::is('admin/permissions/create') || Request::is('admin/permissions/*/edit') ? 'active' : ''}}" href="{{route('permissions.index')}}">Permission</a></li>--}}
{{--                    <li><a class="{{Request::is('admin/roles') || Request::is('admin/roles/create') || Request::is('admin/roles/*/edit') ? 'active' : ''}}" href="{{route('roles.index')}}">Role</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
            @endrole
            
        </ul>
    </div>
</div>
<!--**********************************
