@extends('dashboard.index')

@section('layouts')
    <x-table 
        tableTitle="{{$data['tableTitle']}}" 
        tableDesc="{{$data['tableDesc']}}"
        usefilter="{{$data['usefilter']}}"
        :column="$data['column']"
        :row="$data['data']"
        formLink="category/create"
    ></x-table>
@endsection