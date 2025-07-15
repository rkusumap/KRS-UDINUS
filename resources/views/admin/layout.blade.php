<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    @include('admin.metadata')

</head>
<style>
    .main-sidebar {
        overscroll-behavior-y: contain;
    }
</style>
<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                </ul>

                </form>
                @include('admin.header')
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{url('/home')}}">{{$optionAppServiceProvider->name_app_option}}</a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{url('/home')}}">{{$optionAppServiceProvider->acronym_name_app_option}}</a>
                </div>
                @include('admin.navigation')


                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            @include('admin.footer')
        </div>
    </div>

    @include('admin.script')
    @yield('script')
</body>
</html>
