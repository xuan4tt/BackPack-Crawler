@extends('layouts.main')

@section('title', 'Detail')
@section('content')

    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
            <div class="lg:w-5/6 md:w-1/2 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
                <div class="lg:max-w-lg md:w-1/3 w-1/6 mb-10 md:mb-0">
                    <img class="object-cover object-center rounded" alt="hero" src="https://dummyimage.com/720x600">
                </div>
                <div
                    class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                    <h1 class="title-font sm:text-4xl text-3xl mb-4 font-black text-gray-900">
                        {{ $exam->name }}
                    </h1>
                    <p class="mb-4 leading-relaxed">Khối: <b>{{ $exam->class_rom->name }}</b></p>
                    <p class="mb-4 leading-relaxed">Môn thi: <b>{{ $exam->category->name }}</b></p>
                    <p class="mb-4 leading-relaxed">Thời gian: <b>120 phút</b></p>
                    <p class="mb-4 leading-relaxed">Số câu hỏi: <b>{{ $exam->questions->count() }} câu hỏi</b></p>
                    
                    @if($exam->questions->count() > 0 && Auth::check())
                    <div class="flex justify-center">
                        <a href="{{ route('home.doing', ['exam' => $exam->id]) }}">
                        <button
                            class="inline-flex text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg">Tham gia
                        </button>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="lg:w-1/6 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0 text-center">
                <h2 class="text-gray-900 text-lg mb-1 font-black title-font">Các đề thi liên quan</h2>

                
                <div class="relative mb-4">
                    eeeee
                </div>

            </div>
        </div>
    </section>
@endsection
