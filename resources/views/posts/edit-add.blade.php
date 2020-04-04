@extends('layouts.app')
@section('content')
    <div class="col-md-12">

    </div>
    <div class="give-me-space">

        <form v-cloak @if(isset($post)) action="{{route('posts.update', ['id' => $post->id])}}" @else action="{{route('posts.store')}}" @endif method="post" >
            @if(isset($post)) <input name="_method" type="hidden" value="PUT"> @endif
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <v-card>
                            <v-card-title><span style="font-size: 1.3rem">Okno dodawania postu</span></v-card-title>
                            <v-card-text>
                                <v-text-field @if($errors->has('title')) error error-messages="{{$errors->get('title')[0]}}" @endif @if(isset($post)) value="{{$post->title}}" @endif outlined label="Nazwa postu" name="title"></v-text-field>
                                <v-text-field @if(isset($post)) value="{{$post->subtitle}}" @endif outlined label="Podtytuł" name="subtitle"></v-text-field>
                                <desc-component @if(isset($post)) value="{{$post->content}}" @endif @if($errors->has('content')) error error-messages="{{$errors->get('content')[0]}}" @endif></desc-component>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn color="primary" depressed tile class="w-100" type="submit">Zapisz</v-btn>
                            </v-card-actions>
                        </v-card>
                    </div>
                    <div class="col-md-4">
                        <v-card>
                            <v-card-title><span style="font-size: 1.3rem">Tagi</span></v-card-title>
                            <v-card-text>
                                <tags-component @if(isset($post)) :value="JSON.parse('{{json_encode($post->tags)}}')" @endif></tags-component>
                            </v-card-text>
                        </v-card>
                        <v-card class="mt-8">
                            <v-card-title><span style="font-size: 1.3rem">Kategorie</span></v-card-title>
                            <v-card-text>
                                <categories-component @if(isset($post)) :value="JSON.parse('{{json_encode($post->categories)}}')" @endif></categories-component>
                            </v-card-text>
                        </v-card>
                        <v-card class="mt-8">
                            <v-card-title><span style="font-size: 1.3rem">Załączniki</span></v-card-title>
                            <v-card-text>
                                <files-component  @if(isset($post) && $post->attachments != '') :value="JSON.parse('{{$post->attachments}}')" @endif></files-component>
                            </v-card-text>
                        </v-card>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @endsection