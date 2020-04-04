@extends('layouts.app')
@section('content')
    <div class="container">
        @if(count($category->shop_categories) > 0)
        <v-alert type="info" class="mt-4 elevation-4">Niektóre elementy z tej kategorii są płatne. Żeby mieć do nich dostęp, wykup subskrypcję na tę kategorię.</v-alert>
            @endif
        <div class="row" v-cloak>
            <div class="col-md-8">
                @foreach($posts as $post)
                        @include('posts.small', ['post' => $post])
                    @endforeach
                <div style="min-height: 1200px"></div>
            </div>
            <div class="col-md-4">
                <div class="sticky-top" style="top: 80px">
                    @include('partials.latest')
                    <div class="mt-3">
                        @include('partials.statistic')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection