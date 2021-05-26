@extends('layouts.main')
@section('title', 'Test')
@section('content')


@endsection
@section('script')
    <script>
        //console .log(window.Echo.channel('test').listen('.Test-Event'))
        Echo.channel('laravel_database_test').listen('.Test-Event', function(data){
            console.log(data);
        })
    </script>
@endsection
