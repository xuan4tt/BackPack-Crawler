<header class="text-gray-600 body-font bg-gray-100">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round"
                stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-green-500 rounded-full"
                viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <span class="ml-3 text-xl">VIET JACK - J97</span>
        </a>
        <nav
            class="md:mr-auto md:ml-4 md:py-1 md:pl-4 md:border-l md:border-gray-400 flex flex-wrap items-center text-base justify-center">
            <a href="{{ route('home.index') }}" class="mr-5 hover:text-green-900 hover:bg-white">TRANG CHỦ</a>
            <a href="{{ route('home.class') }}" class="mr-5 hover:text-green-900 hover:bg-white">THI ONLINE</a>
            <a href="{{ route('home.index') }}" class="mr-5 hover:text-green-900 hover:bg-white">TÀI LIỆU</a>
            <a href="{{ route('home.index') }}" class="mr-5 hover:text-green-900 hover:bg-white">GIỚI THIỆU</a>
        </nav>
        <div class="w-full md:w-auto md-6 md:mb-0 text-center dropdown inline-block">
            @if (!Auth::check())
                <button class="inline-block no-underline  bg-green-500 text-white text-sm py-2 px-3">
                    <a href="{{ route('login') }}" class="hover:underline">Đăng nhập</a> /
                    <a href="#" class="hover:underline">Đăng ký</a>
                </button>
            @else
                <style>
                    .dropdown:hover>.dropdown-content {
                        display: block;
                    }

                </style>
                <a href="#">
                    <svg xmlns="{{ Auth::user()->avatar }}" class=" w-20 h-20 text-gray-600" viewbox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-center font-black">
                        {{ Auth::user()->name }}
                    </p>

                </a>
            @endif
            <ul class="dropdown-content absolute hidden text-gray-600 pt-5">
                <li><a class="rounded-t bg-gray-100 hover:bg-gray-400 hover:text-white py-2 px-4 block whitespace-no-wrap"
                        href="#">Thông tin</a></li>
                <li><a class="rounded-b bg-gray-100 hover:bg-gray-400 hover:text-white py-2 px-4 block whitespace-no-wrap"
                        href="{{ route('logout') }}">Thoát</a></li>
            </ul>
        </div>








</header>
