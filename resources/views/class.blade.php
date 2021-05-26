@extends('layouts.main')

@section('title', 'Class')
@section('content')
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
                @foreach ($class as $item)
                @if($item->urlExams->where('status', 1)->count() > 0)
                <div class="p-2 sm:w-1/2 w-full">
                    <a href="{{ route('home.exams', ['class_id' => $item->id]) }}">
                    <div class="bg-gray-100 rounded flex p-4 h-full items-center hover:bg-gray-200">
                        <span class="title-font font-black">{{ $item->name }} ({{ $item->urlExams->where('status', 1)->count() }} đề)</span>
                    </div>
                    </a>
                </div>
                @endif
                @endforeach
            </div>
            </div>
    </section>

@endsection
