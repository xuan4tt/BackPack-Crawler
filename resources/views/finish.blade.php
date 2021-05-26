@extends('layouts.main')
@section('title', 'finish')
@section('content')
    <section class="text-gray-600 py-8 body-font">
        <div class="flex flex-col text-center w-full  my-2.5">
            <h1 class="sm:text-3xl text-2xl font-black title-font mb-4 text-gray-900">Kết quả bài thi</h1>
        </div>
        <div class="container px-5 py-24 mx-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                            Tài khoản
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                            Đề thi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                            Kết quả
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                                        alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        Jane Cooper
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        jane.cooper@example.com
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                            <div class="text-sm text-gray-500">Optimization</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            30/50
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Pass
                            </span>
                        </td>
                        
                    </tr>

                    <!-- More people... -->
                </tbody>
            </table>
        </div>
    </section>
@endsection
