

<header class="navbar navbar-expand-md d-print-none navbar-light"  style="height: 76px;">
    <div class="container-xl">
        <!-- BEGIN NAVBAR TOGGLER -->
        {{--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>--}}
        <!-- END NAVBAR TOGGLER -->
        <!-- BEGIN NAVBAR LOGO -->
        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{route('home')}}" class="text-decoration-none header-nav-logo d-flex align-items-center gap-1">
                <img src="{{asset('/logo_small.png')}}" alt="{{env('APP_NAME')}}" class="navbar-brand-image">
                <span class="h1 p-0 m-0 text-dark">Portal+</span>

            </a>
        </div>
        <!-- END NAVBAR LOGO -->
        <div class="navbar-nav flex-row order-md-last w-50">
            <div class="nav-item d-flex me-3 w-100">
                <div class="input-icon">
                    <input type="text" value="" class="form-control" placeholder="Search…">
                    <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                  </svg>
                                </span>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-color:transparent;background-image: url({{asset('/default_user.png')}})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div class="mb-1 small">HI</div>
                        <div>{{auth()->user()->name}}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
