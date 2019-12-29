@extends('layouts.app')
@section('content')
    <div v-cloak>
        <v-card dark color="primary" class=" py-6 w-100 mx-0" tile>
            <div class="container">
                <div class="d-flex">
                    <v-card-title class="col-md-4" style="padding-bottom: 180px">
                        <h1 class="font-weight-bold">{{$user->name}}</h1>
                        <p style="font-size: 0.8rem">
                            <v-icon style="font-size: 1rem">mdi-clock</v-icon> Data dołączenia {{$user->created_at->format('Y-m-d')}}<br>
                            @if($user->city)
                            <v-icon style="font-size: 1rem">mdi-city</v-icon> Miasto: {{$user->city}}<br>
                            @endif
                        </p>
                        <v-avatar size="200" class="card-avatar">
                            <img  elevation="3"
                                src="{{url('/storage/'.$user->avatar)}}"
                                alt="{{$user->name}}"
                            >
                        </v-avatar>
                    </v-card-title>
                    <v-card-text style="padding-top: 15px">
                        fwa wa aw awpwa gawpigh wa fwa wa aw awpwa gawpigh wa fwa wa aw awpwa gawpigh wafwa wa aw awpwa gawpigh wa fwa wa aw awpwa gawpigh wa
                    </v-card-text>
                </div>
            </div>
        </v-card>
        @if($user->hasVerifiedEmail())
        <div style="padding-top: 100px">
            <div class="container">
                <div class="row">
                    <div class="col-md-4" style="height: fit-content; position: sticky; top: 60px">
                        <v-navigation-drawer flat permanent>
                            <v-list
                                flat
                                dense
                                nav
                            >
                                <v-list-item href="{{route('account.index', ['id' => $user->id])}}" link>
                                    <v-list-item-icon>
                                        <v-icon>mdi-file-document-box-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Posty</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item href="{{route('account.index', ['id' => $user->id, 'tab' => 'comments'])}}" link>
                                    <v-list-item-icon>
                                        <v-icon>mdi-comment-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Komentarze</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                @if($user->id == Auth::id())
                                <v-divider></v-divider>
                                <v-list-item link href="{{route('account.index', ['id' => $user->id, 'tab' => 'account'])}}">
                                    <v-list-item-icon>
                                        <v-icon>mdi-account-edit-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Konto</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item link href="{{route('account.index', ['id' => $user->id, 'tab' => 'privacy'])}}">
                                    <v-list-item-icon>
                                        <v-icon>mdi-account-lock-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Prywatność</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item link>
                                    <v-list-item-icon>
                                        <v-icon>mdi-cart-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Twoje zakupy</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item link>
                                    <v-list-item-icon>
                                        <v-icon>mdi-clipboard-text-multiple-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Opis</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-divider></v-divider>
                                <v-list-item link>
                                    <v-list-item-icon>
                                        <v-icon>mdi-close-octagon-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Wyloguj się</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                    @endif
                            </v-list>
                        </v-navigation-drawer>
                    </div>
                    <div class="col-md-8">
                        @if(!$tab || $tab == '')
                                @include('auth.partials.posts')
                            @elseif($tab == 'comments')
                                KOMENTARZE
                            @elseif($tab == 'account')
                                @include('auth.partials.account')
                            @elseif($tab == 'privacy')
                                <account-privacy :user="{{$user->load('settings')}}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
            @elseif(\Illuminate\Support\Facades\Auth::id() == $user->id)
            <div class="container pt-13 mt-10">
                <div class="row pt-10">
                    <div class="col-md-12 text-center">
                        <h2>Musisz zweryfikować swój email {{$user->email}}</h2>
                        <form action="{{route('send_verification_link')}}" method="post">
                            @csrf
                            <v-btn type="submit">Wyślij email weryfikacyjny jeszcze raz</v-btn>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @endsection
