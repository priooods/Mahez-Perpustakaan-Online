@extends('index')


@section('content')
    <div class="w-full flex justify-center items-center h-screen">
        <div class="w-2/6 px-6 py-10">
            <h1 class="text-3xl font-bold">Buat Akun</h1>
            <p class="text-sm mb-10">Pastikan melengkapi informasi dibawah dengan benar</p>

            <form action="{{ url('user') }}" 
                method="post" class="grid grid-cols-1 gap-5">
                @csrf
                <x-input label="Fullname" type="text" name="fullname" required></x-input>
                <x-input label="Email" inputType="email" name="email" required></x-input>
                <x-input label="Password" inputType="password" name="password" required></x-input>
                @isset($failure)
                    <x-alert variant="{{$failure['response_notification']['color']}}" 
                        title="{{$failure['response_notification']['title']}}" 
                        description="{{$failure['response_notification']['description']}}"></x-alert>
                @endisset
                @isset($throwable)
                    <x-alert variant="red" 
                        title="Something wrong" 
                        description="{{$throwable}}"></x-alert>
                @endisset
                <x-button type="submit" variant="blue" label="Buat Akun"></x-button>
            </form>
            <p class="text-xs text-center mt-2">Sudah memiliki akun ? 
                <a href="/" class="text-blue-500 hover:text-blue-600 underline">Masuk</a></p>
        </div>
    </div>
@endsection