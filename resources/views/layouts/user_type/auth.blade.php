@extends('layouts.app')

@section('auth')

    @if(\Request::is('static-sign-up'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')

    @elseif (\Request::is('static-sign-in'))
        @include('layouts.navbars.guest.nav')
            @yield('content')
        @include('layouts.footers.guest.footer')

    @elseif (\Request::is('laporan-pdf'))
        {{-- @include('layouts.navbars.auth.sidebar')<!-- -user--> --}}
        <main class="main-content position-relative h-100 mt-2 border-radius-lg ">{{-- {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}; max-height-vh-100: kalo ini hilang, bisa print all  --}}
            {{-- @include('layouts.navbars.auth.nav') --}}
            <div class="container-fluid py-3">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>
    @else
        @include('layouts.navbars.auth.sidebar')<!-- -user-->
        <main class="main-content position-relative h-100 mt-2 border-radius-lg ">{{-- {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}; max-height-vh-100: kalo ini hilang, bisa print all  --}}
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-3">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>
        {{-- @include('components.fixed-plugin') --}}
    @endif
        {{-- @if(\Request::is('rtl'))
        @include('layouts.navbars.auth.sidebar-rtl')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
            @include('layouts.navbars.auth.nav-rtl')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main> --}}

        {{--
        @if (\Request::is('profile'))
            @include('layouts.navbars.auth.sidebar')
            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
                @include('layouts.navbars.auth.nav')
                @yield('content')
            </div>
        @elseif (\Request::is('virtual-reality'))
            @include('layouts.navbars.auth.nav')
            <div class="border-radius-xl mt-3 mx-3 position-relative" style="background-image: url('../assets/img/vr-bg.jpg') ; background-size: cover;">
                @include('layouts.navbars.auth.sidebar')
                <main class="main-content mt-1 border-radius-lg">
                    @yield('content')
                </main>
            </div>
            @include('layouts.footers.auth.footer') --}}
    {{-- @endif --}}
@endsection
