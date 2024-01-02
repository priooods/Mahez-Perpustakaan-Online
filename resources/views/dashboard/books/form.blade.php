@extends('dashboard.index')

@section('layouts')
    <h1 class="text-xl font-bold">
        @if(isset($form['update']))
            {{$form['update']['title']}}
        @else
            Form Buku
        @endif
    </h1>
    <p>
        @if (isset($form['update']))
            {{$form['update']['description']}}
        @else
            Harap lengkapi informasi dibawah ini
        @endif
    </p>
    <form method="POST" action="{{ isset($form['update']) 
        ? url('book/update/'. $form['update']['id']) : url('book') }}" enctype="multipart/form-data">
        @csrf
        <div class="mt-7 grid md:grid-cols-3 grid-cols-1 gap-5">
            <x-input name="title" label="Judul Buku" placeholder="Masukan judul buku" 
                value="{{$form['detail']['title'] ?? ''}}"></x-input>
            <x-input name="m_category_tabs_id" inputType="select" 
                label="Kategori" :selectOptions="$form['category']"></x-input>
            <x-input name="count" inputType="number" label="Jumlah" 
                value="{{$form['detail']['count'] ?? null}}" placeholder="Masukan jumlah"></x-input>
            <x-input name="description" inputType="textarea" 
                label="Deskripsi" placeholder="Masukan deskripsi buku" 
                defaulttextarea="{{$form['detail']['description'] ?? null}}"></x-input>
            <x-input name="book_file" inputType="file" label="Ebook" placeholder="Masukan deskripsi buku"
                acceptFile="application/pdf"></x-input>
            <x-input name="book_cover" inputType="file" label="Cover Buku" placeholder="Masukan deskripsi buku" 
                acceptFile="image/jpeg, image/jpg, image/png"></x-input>
        </div>
        <div class="mt-3">
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
            <div class="mt-5 text-end">
                @if (isset($form['update']))
                    <x-button variant="green" label="Update Data" type="submit"></x-button>
                @else
                    <x-button variant="blue" label="Tambah Baru" type="submit"></x-button>
                @endif
            </div>
        </div>
    </form>
@endsection