@extends('layouts.layout')

@section('content')
    @foreach($tags as $tag)
        <h1>{{ $tag->name }}</h1>
    @endforeach
@endsection
