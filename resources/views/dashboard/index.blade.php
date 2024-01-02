@extends('index')


@section('content')
    <div class="flex justify-start w-full">
        <div class="md:w-2/12 md:max-h-screen h-screen border-r border-r-gray-200 
                py-10 px-3 font-semibold block">
            <x-sidemenu></x-sidemenu>
        </div>
        <div class="w-full md:py-10 md:px-10">
            @yield('layouts')
        </div>
    </div>
@endsection