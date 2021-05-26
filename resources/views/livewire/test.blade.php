<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex items-center mb-5 md:mb-6 group lg:max-w-xl">
            <a href="/" aria-label="Item" class="mr-3">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50">
                    <svg class="w-12 h-12 text-deep-purple-accent-400" stroke="currentColor" viewBox="0 0 52 52">
                        <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                            points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                    </svg>
                </div>
            </a>
            <h3 class="font-sans text-3xl font-black leading-none tracking-normal text-gray-900 sm:text-4xl">
                <span class="inline-block mb-2">{{ $class->name }}</span>
                <div
                    class="h-1 ml-auto duration-300 origin-left transform bg-deep-purple-accent-200 scale-x-30 group-hover:scale-x-100">
                </div>
            </h3>
        </div>
        <div class="flex flex-wrap p-6">
            @foreach ($subject as $item)
                <a href="{{ route('home.exams', [
                    'class_id' => $class->id,
                    'subject' => $item[0]->category->id
                    ]) }}">
                    <div class="p-2 w-1/8">
                        <div class="border-2 text-center {{ $item[0]->category->id == $category_id ? "bg-green-500 text-white" : "" }}  border-gray-200 hover:bg-green-500 hover:text-white px-4 py-3 rounded-lg">
                            <p>{{ $item[0]->category->name }}</p>
                        </div>
                    </div>
                </a>
            @endforeach

            <div class="flex flex-wrap -m-4 p-6">
                @foreach ($exams as $key => $item)
                    <div class="p-6 lg:w-1/3">
                        <a href="{{ route('home.exam_detail', ['url_id' => $item->id]) }}">
                            <div
                                class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
                                <img alt="team"
                                    class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4 transform hover:-translate-y-1 hover:scale-110"
                                    src="https://dummyimage.com/201x201">
                                <div class="flex-grow sm:pl-8 text-center ">
                                    <h2 class="title-font font-black text-lg text-gray-900">Mã bộ đề
                                        {{ $item->id }}
                                    </h2>
                                    <p class="mb-6">{{ $item->name }}</p>

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="p-6 lg:w-full">
                    {!! $exams->links() !!}
                </div>
            </div>
        </div>
</section>
