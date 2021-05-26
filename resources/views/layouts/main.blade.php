<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content = "{{csrf_token ()}}" name = "csrf-token">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>
        @yield('title')
    </title>
    @livewireStyles
</head>
<body>
    @include('layouts._share.header')
    @livewire('notification')
    @yield('hero')

    @yield('content')

    {{--    FOOTER--}}
    @include('layouts._share.footer')

    {{--    SCRIPT--}}
        @livewireScripts

        <script>window.laravel_echo_port=6001;</script>
        <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
        <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>

        @if(Auth::check()))

            <script>
                Echo.private('data.'+{{Auth::user()->id}})
                    .listen('.server-created', function(data){
                        console.log(data)
                        Livewire.emit('notificationForm', data)

                })

            </script>
        @endif

        @yield('script')
</body>
</html>
