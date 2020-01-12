@php
    $posts = \App\Post::orderBy('created_at')->active()->take(3)->get();
@endphp
<v-card>
    <v-card-title>Ostatnie posty:</v-card-title>
    <v-card-text>
        @foreach($posts as $post)
            <div class="row">
                <div class="col-2">
                    <v-avatar :size="40">
                        <v-img src="{{url('/storage/'.$post->user->avatar)}}"></v-img>
                    </v-avatar>
                </div>
                <div class="col-10">
                    <a class="my-link" href="{{$post->url}}">
                        <h3 style="font-size: 1rem" class="mb-0">{{str_limit($post->title, 30, '...')}}</h3>
                        <p class="text-muted mb-0">{{str_limit($post->subtitle, 50, '...')}}</p>
                    </a>
                    <span><v-icon style="font-size: 1rem" class="mr-1">mdi-calendar</v-icon>{{$post->created_at->format('Y-m-d')}}</span>
                    <div class="d-flex flex-wrap mt-2">
                        @foreach($post->tags as $tag)
                                <v-chip href="{{$tag->url}}" class="mr-1" small color="primary">{{$tag->tag}}</v-chip>
                        @endforeach
                    </div>
                    <div class="d-flex flex-wrap">
                        @foreach($post->categories as $category)
                           <a href="{{$category->url}}" class="mr-1 caption">{{$category->name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>

        @endforeach
    </v-card-text>
</v-card>
