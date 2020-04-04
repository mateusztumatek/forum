@php
    $posts = \App\Services\LayoutService::getSliderPosts();
@endphp
@if(Crawler::isCrawler())
<div class="container">
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-3">
                <div class="pa-3">
                    <v-card class="elevation-9" style="border-radius: 16px">

                        <v-card-title>{{$post->user->name}}</v-card-title>
                        <v-card-text>
                            <v-avatar size="80" style="position: absolute; top: -40px">
                                <img src="{{url('/storage/'.$post->user->avatar)}}">
                            </v-avatar>
                        </v-card-text>
                    </v-card>
                </div>
            </div>
        @endforeach
    </div>
</div>
@else
    <slider-component :posts="{{$posts->load('user')}}"></slider-component>
    @endif