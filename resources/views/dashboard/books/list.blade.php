@extends('dashboard.index')

@section('layouts')
    <x-table 
        tableTitle="{{$data['tableTitle']}}" 
        tableDesc="{{$data['tableDesc']}}"
        :usefilter="$data['usefilter']"
        :filtering="$data['filtering']"
        :column="$data['column']"
        :row="$data['data']"
        :excel="$data['excel']"
        formLink="book/create"
    ></x-table>
@endsection