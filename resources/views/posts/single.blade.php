@extends('layouts.app')
@section('content')
    <div class="container give-me-space">
        <div class="row">
            <div class="col-md-9">
                <v-card v-cloak>
                    <div class="actions d-flex align-items-center">
                        <rates-component table="posts" id="{{$post->id}}" :data="JSON.parse('{{$post->rates}}')" :user="user"></rates-component>
                        @if($post->user_id == Auth::id())
                            <v-menu bottom left>
                                <template v-slot:activator="{ on }">
                                    <v-btn
                                            icon
                                            v-on="on"
                                    >
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>

                                <v-list>
                                    <v-list-item href="{{route('posts.edit', ['id' => $post->id])}}">Edytuj</v-list-item>
                                </v-list>
                            </v-menu>
                        @endif
                    </div>
                    <v-card-title>
                        <div class="row mx-0">
                            <a href="{{route('account.index', ['id' => $post->user_id])}}">
                                <v-avatar class="mr-2">
                                    <v-img src="{{url('/storage/'.$post->user->avatar)}}"></v-img>
                                </v-avatar>
                            </a>

                            <h1 class="title">{{$post->title}}</h1>
                        </div>

                        <p class="text-muted body-2 w-100 mt-2">{{$post->subtitle}}</p>
                        <div class="row mx-0">
                            <p class="text-muted caption"><v-icon class="body mr-2">mdi-calendar-month</v-icon>{{$post->created_at->format('Y-m-d')}}</p>
                            <a href="{{route('account.index', ['id' => $post->user->id])}}" class="caption ml-2"><v-icon class="body mr-2">mdi-account-outline</v-icon>{{$post->user->name}}</a>
                        </div>
                    </v-card-title>
                    <v-card-text>
                        @if($post->hasAccess(\Illuminate\Support\Facades\Auth::user()))
                        {!! $post->content !!}
                        @if($post->attachments)
                            <div class="row">
                                @foreach(json_decode($post->attachments) as $attachment)
                                    <div class="col-md-3 d-flex align-items-center">
                                        <v-icon>mdi-file</v-icon>
                                        <a href="{{url('/storage/'.$attachment)}}">Pobierz plik</a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                            @else
                            <div class="must-pay">
                                <h3 class="text-muted">Ten post jest płatny aby zobaczyć jego treść musisz wykupić dostęp do tej części forum</h3>
                            </div>
                            <payment-component :data=""></payment-component>
                        @endif
                    </v-card-text>

                </v-card>
                @if($post->hasAccess(\Illuminate\Support\Facades\Auth::user()))
                <post-comments post_id="{{$post->id}}" :user="user"></post-comments>
                @endif
            </div>
        </div>
    </div>
    @endsection