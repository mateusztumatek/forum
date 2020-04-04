@extends('layouts.app')

@section('content')
    <div class="container">
        {!! $page->html !!}
    </div>
@endsection
@section('css')
    <style>{!! $page->css !!}</style>
    @endsection