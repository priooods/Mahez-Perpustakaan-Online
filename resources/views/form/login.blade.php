@extends('index')


@section('content')
    <div class="w-full flex justify-center items-center h-screen">
        <div class="w-2/6 px-6 py-10">
            <h1 class="text-3xl font-bold">Masuk</h1>
            <p class="text-sm mb-10">Masukan informasi akun anda untuk masuk</p>

            <form action="{{ url('postlogin') }}" 
                method="post" class="grid grid-cols-1 gap-5">
                @csrf
                <x-input label="Email" inputType="email" name="email" required></x-input>
                <x-input label="Password" inputType="password" name="password" required></x-input>
                @isset($failure)
                    <x-alert variant="{{$failure['response_notification']['color']}}" 
                        title="{{$failure['response_notification']['title']}}" 
                        description="{{$failure['response_notification']['description']}}"></x-alert>
                @endisset
                @isset($throwable)
                    <x-alert variant="red" 
                        title="Something Wrong" 
                        description="{{$throwable}}"></x-alert>
                @endisset
                <x-button variant="blue" label="Masuk"></x-button>
            </form>
            <p class="text-xs text-center mt-2">Belum memiliki akun ? 
                <a href="/register" class="text-blue-500 hover:text-blue-600 underline">Buat akun</a></p>
        </div>
    </div>
@endsection