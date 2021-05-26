@extends('layouts.main')
@section('title', 'exam')

@section('content')
@livewire('test', ['class_id' => $class_id])
@endsection
