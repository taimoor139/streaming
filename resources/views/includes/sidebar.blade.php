<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            @if(Auth::user()->hasRole('Admin'))
            <a class="header-brand1" href="{{ url('/dashboard')}}">
                @endif
                @if(Auth::user()->hasRole('Guard'))
                <a class="header-brand1" href="{{ url('/dashboard')}}">
                    @endif
                @if(Auth::user()->hasRole('BuildingAdmin'))
                <a class="header-brand1" href="{{ url('/dashboard')}}">
                    @endif
                @if(Auth::user()->hasRole('Integrator'))
                <a class="header-brand1" href="{{ url('/dashboard')}}">
                    @endif
                    @if(Auth::user()->hasRole('Tenant'))
                    <a class="header-brand1" href="{{ url('/appointment/list')}}">
                        @endif

                        <img src="{{asset(env('APP_LOGO'))}}" class="header-brand-img desktop-logo" alt="logo1s" style="height:40x !important;">
                        <img src="{{asset(env('APP_LOGO'))}}" class="header-brand-img toggle-logo" alt="logo2s" style="height:40x !important;">
                        <img src="{{asset(env('APP_ICON'))}}" class="header-brand-img light-logo" alt="logo3s" style="height:40x !important;">
                        <img src="{{asset(env('APP_LOGO'))}}" class="header-brand-img light-logo1" alt="logo4s" style="height:40x !important;">
                    </a>
                    <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg></div>
            <ul class="side-menu">
                <li class="sub-category">
                    <h3>Main</h3>
                </li>
                <li class="slide">
                    @if(Auth::user()->hasRole('Admin'))
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/dashboard')}}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                    @endif
                    @if(Auth::user()->hasRole('BuildingAdmin'))
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/dashboard')}}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                    @endif
                    @if(Auth::user()->hasRole('Integrator'))
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/dashboard')}}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                    @endif
                    @if(Auth::user()->hasRole('Tenant'))
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/appointment/list')}}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                    @endif
                    @if(Auth::user()->hasRole('Guard'))
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/dashboard')}}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                    @endif
                </li>

                @if(Auth::user()->hasRole('Admin'))
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Users</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('/user/list')}}" class="slide-item"> User list</a></li>

                        <li><a href="{{ url('/user/add')}}" class="slide-item"> User add</a></li>
                        <!-- <li><a href="{{ url('/user/role')}}" class="slide-item"> User role</a></li> -->
                    </ul>
                </li>


                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-bar-chart-2"></i><span class="side-menu__label">Sites</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('/site/list')}}" class="slide-item"> Site list</a></li>

                        <li><a href="{{ url('/site/add')}}" class="slide-item"> Site add</a></li>

                        <!-- <li><a href="{{ url('/user/role')}}" class="slide-item"> User role</a></li> -->
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasRole('Tenant'))
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Employees</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('tenant/user/list')}}" class="slide-item"> Employees list</a></li>

                        <li><a href="{{ url('tenant/user/add')}}" class="slide-item"> Employee add</a></li>
                        <!-- <li><a href="{{ url('/user/role')}}" class="slide-item"> User role</a></li> -->
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-camera"></i><span class="side-menu__label">Cameras</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('tenant/user/list')}}" class="slide-item"> Dumi camera</a></li>
                    </ul>
                </li>
                @endif
                
                @if(Auth::user()->hasRole('Employee'))
                 <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-calendar"></i><span class="side-menu__label">Visitors</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('employee/visitor/list')}}" class="slide-item">Visitors list</a></li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasRole('BuildingAdmin'))
                  <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Users</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('building/user/list')}}" class="slide-item"> User list</a></li>

                        <li><a href="{{ url('building/user/add')}}" class="slide-item"> User add</a></li>
                        <!-- <li><a href="{{ url('/user/role')}}" class="slide-item"> User role</a></li> -->
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-calendar"></i><span class="side-menu__label">Appointments</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('building/appointment/list')}}" class="slide-item"> Appointment list</a></li>

                        <li><a href="{{ url('building/appointment/add')}}" class="slide-item"> Appointment add</a></li>

                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasRole('Integrator'))
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-bar-chart-2"></i><span class="side-menu__label">Sites</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('integrator/site/list')}}" class="slide-item"> Site list</a></li>

                        <li><a href="{{ url('integrator/site/add')}}" class="slide-item"> Site add</a></li>

                        <!-- <li><a href="{{ url('/user/role')}}" class="slide-item"> User role</a></li> -->
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Building Admins</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('/integrator/user/list')}}" class="slide-item"> Building Admin list</a></li>

                        <li><a href="{{ url('/integrator/user/add')}}" class="slide-item"> Building Admin add</a></li>
                        <!-- <li><a href="{{ url('/user/role')}}" class="slide-item"> User role</a></li> -->
                    </ul>
                </li>
                @endif
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{url('/profile')}}"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
                </li>
                @if(Auth::user()->hasRole('Guard') )
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fa fa-qrcode"></i><span class="side-menu__label">Scan</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('/qr-scan')}}" class="slide-item">QR Code Scan</a></li>
                        <li><a href="{{ url('document/scan')}}" class="slide-item">ID Parsing Scan</a></li>
                    </ul>
                </li>
                @endif

                <li class="slide">
                    <form method="post" action="{{route('logout')}}">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <i class="side-menu__icon fe fe-log-out"></i>
                            <span class="side-menu__label text-dark">{{ __('Log out') }}</span>
                        </button>
                    </form>
                </li>

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>
    <!--/APP-SIDEBAR-->
</div>