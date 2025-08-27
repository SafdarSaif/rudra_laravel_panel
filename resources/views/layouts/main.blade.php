@include('panels.header-top')

@yield('styles')

@include('panels.header-bottom')
@include('panels.menu')
@yield('content')
@include('panels.footer-top')
@yield('scripts')
@include('panels.footer-bottom')
