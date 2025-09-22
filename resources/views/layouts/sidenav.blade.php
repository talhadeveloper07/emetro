<style>
    .header-nav-logo{
        display: none;
    }
</style>
<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark d-print-none">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autolight" style="padding: 10px;height: 75px;">
            <a href="{{env('PORTAL_URL')}}" class="text-decoration-none">
                @if(env('APP_LOGO'))
                    <img src="{{asset(env('APP_LOGO'))}}" alt="{{env('APP_NAME')}}" class="navbar-brand-image desktop-logo">
                    <img src="{{asset('/logo_dark.png')}}" alt="{{env('APP_NAME')}}" class="navbar-brand-image mobile-logo">

                @else
                    <span class="navbar-brand-heading ">{{env('APP_NAME')}}</span>
                @endif
            </a>
        </h1>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item @if(request()->is('/'))active @endif " >
                    <a class="nav-link " href="{{route('home')}}" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    <svg  class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                  </span>
                        <span class="nav-link-title ">
                    Home
                  </span>
                    </a>
                </li>
                <li class="nav-item   @if(request()->is('roles*'))active @endif " >
                    <a class="nav-link" href="{{route('roles.index')}}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users-group"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>
                        </span>
                        <span class="nav-link-title ">Role Management</span>
                    </a>
                </li>
                <li class="nav-item   @if(request()->is('organizations*'))active @endif " >
                    <a class="nav-link" href="{{route('org.index')}}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-buildings"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15" /><path d="M16 8h2c1 0 2 1 2 2v11" /><path d="M3 21h18" /><path d="M10 12v0" /><path d="M10 16v0" /><path d="M10 8v0" /><path d="M7 12v0" /><path d="M7 16v0" /><path d="M7 8v0" /><path d="M17 12v0" /><path d="M17 16v0" /></svg>
                        </span>
                        <span class="nav-link-title ">Organizations</span>
                    </a>
                </li>
                <li class="nav-item   @if(request()->is('records*'))active @endif " >
                    <a class="nav-link" href="{{route('records.index')}}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg  class="icon"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round" ><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 12h.01" /><path d="M4 6h.01" /><path d="M4 18h.01" /><path d="M8 18h2" /><path d="M8 12h2" /><path d="M8 6h2" /><path d="M14 6h6" /><path d="M14 12h6" /><path d="M14 18h6" /></svg>
                        </span>
                        <span class="nav-link-title ">Records</span>
                    </a>
                </li>


                {{--<li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle show" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="true" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" /><line x1="12" y1="12" x2="20" y2="7.5" /><line x1="12" y1="12" x2="12" y2="21" /><line x1="12" y1="12" x2="4" y2="7.5" /><line x1="16" y1="5.25" x2="8" y2="9.75" /></svg>
                  </span>
                        <span class="nav-link-title">
                    Interface
                  </span>
                    </a>
                    <div class="dropdown-menu show">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item active" href="./empty.html" >
                                    Empty page
                                </a>
                                <a class="dropdown-item " href="./accordion.html" >
                                    Accordion
                                </a>
                            </div>
                        </div>
                    </div>
                </li>--}}

            </ul>
        </div>
    </div>
</aside>
