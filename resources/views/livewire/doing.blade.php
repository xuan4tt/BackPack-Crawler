@php
// $key_url = $key_link_arr[0];
// $question = $questions[$key_url];
$doc = new DOMDocument();
libxml_use_internal_errors(true);

@endphp
<section class="text-gray-600 body-font">
    <div class="lg:w-full m-auto p-6 inline-flex ml-5 lg:ml-0">
        <button id="time"
            class="inline-flex items-center bg-green-500 text-white py-1 px-3 focus:outline-none rounded text-base mt-4 md:mt-0">90:00
        </button>
    </div>
    
    <div class="flex flex-col text-center w-full  my-2.5">
        <h1 class="sm:text-3xl text-2xl font-black title-font mb-4 text-gray-900">Bài thi</h1>
    </div>

    <div class="p-2 w-full">
        <a href="{{ route('home.finish', ['exam' => $url_exam_id]) }}">
        <button
            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"> Nộp bài
        </button>
        </a>
    </div>

    <div class="container px-5 py-24 mx-auto">
        @foreach ($questions as $key => $item)
            <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
                <h3 class="p-3 sm:w-full text-2xl font-black  title-font text-gray-900 mb-4">
                    @php
                        @$doc->loadHTML(mb_convert_encoding($item->content, 'HTML-ENTITIES', 'UTF-8'));
                        $elements = $doc->getElementsByTagName('script');
                        for ($i = $elements->length; --$i >= 0; ) {
                            $href = $elements->item($i);
                            $href->parentNode->removeChild($href);
                        }
                    @endphp
                    {{ $questions->currentPage() }}. {!! $doc->saveHTML($doc->getElementsByTagName('body')[0]) !!}
                </h3>
            </div>
            <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
                @foreach ($item->answers as $value)
                    @php
                        @$doc->loadHTML(mb_convert_encoding($value->content, 'HTML-ENTITIES', 'UTF-8'));
                        $elements = $doc->getElementsByTagName('script');
                        for ($i = $elements->length; --$i >= 0; ) {
                            $href = $elements->item($i);
                            $href->parentNode->removeChild($href);
                        }
                    @endphp
                    <div class="p-2 sm:w-1/2 w-full"
                       >

                        <div
                         wire:click="$emit('Click', {{ $value->id }}, {{ $item->id }})"
                            class=" {{ isset($select) && $value->id == $select->answer_id ? "bg-green-500 text-white" : "" }} bg-gray-100 rounded flex p-4 h-full items-center hover:bg-green-500 hover:text-white">
                            <span class="title-font font-medium">
                                {!! $doc->saveHTML($doc->getElementsByTagName('body')[0]) !!}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        {{ $questions->links() }}
    </div>
</section>

