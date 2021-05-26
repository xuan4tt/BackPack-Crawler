@extends('layouts.main')
@section('title', 'sz')
@section('content')


@endsection
@section('script')
    <script>
        //console .log(window.Echo.channel('test').listen('.Test-Event'))
        Echo.channel('laravel_database_xuan4t').listen('.Test2', function(data){
            console.log(data.xuan);
        })
    </script>
@endsection
