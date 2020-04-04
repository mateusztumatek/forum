<div class="w-100" {{--@click="changeLocation('{{route('posts.show', ['id' => $post->id])}}')"--}}>
    <div class="post_small">
        <div class="row" @click="changeLocation('{{route('posts.show', ['id' => $post->id])}}')">
            <div class="col-auto">
                <a href="{{route('account.index', ['id' => $post->user_id])}}">
                    <v-avatar :size="60">
                        <img src="{{url('/storage/'.$post->user->avatar)}}">
                    </v-avatar>
                </a>
            </div>
            <div class="col-md-10">
                <a href="{{$post->url}}">{{$post->title}} <br>
                    <span class="text-muted">{{$post->subtitle}}</span>
                </a>
                <div class="d-flex flex-wrap">
                    <p class="text-muted mb-0 mr-2 mt-3">{{$post->user->name}}</p>
                    <p class="mb-0 mr-2 mt-3 text-muted"><v-icon class="body-1">mdi-calendar</v-icon>{{$post->created_at->format('Y-m-d')}}</p>
                    @if($post->published_at)
                    <p class="mb-0 mr-2 mt-3 text-muted"><v-icon class="body-1">mdi-dialpad</v-icon>{{$post->published_at->format('Y-m-d')}}</p>
                    @endif
                </div>
                <div class="d-flex justify-space-between flex-wrap mt-2">
                    <div>
                        @foreach($post->tags as $tag)
                            <v-chip href="{{$tag->url}}" small color="primary" class="mr-1">{{$tag->tag}}</v-chip>
                        @endforeach
                    </div>

                    <div class="d-flex avatar-group">
                        @php
                            $latest = $post->latestComments->unique('user_id')->values();
                        @endphp
                        @foreach($latest as $comment)
                            @if($comment->user)
                                <v-avatar size="50">
                                    <img  src="{{url('/storage/'.$comment->user->avatar)}}">
                                </v-avatar>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="actions d-flex align-items-center">
            <rates-component table="posts" id="{{$post->id}}" :data="JSON.parse('{{$post->rates}}')" :user="$user.user"></rates-component>
            @if($post->user_id == Auth::id())
            <v-menu bottom left>
                <template v-slot:activator="{ on }">
                    <v-btn
                            @click.stop.pro
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
    </div>
</div>
