<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('top')
</head>

<body>
    <div id="app">
        <!-- Page Wrapper -->
        <div id="wrapper">

            @auth
                @include('layouts.partials._sidebar')    
            @endauth

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    @auth
                        @include('layouts.partials._topbar')
                    @endauth

                    <main>
                        @yield('content')
                    </main>

                </div>
                <!-- End of Main Content -->
                @include('layouts.partials._footer')   

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('bottom')
</body>

</html>