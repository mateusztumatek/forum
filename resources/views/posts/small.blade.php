<div class="w-100">
    <div class="post_small elevation-2">
        <div class="row">
            <div class="col-auto">
                <v-avatar :size="60">
                    <img src="{{url('/storage/'.$post->user->avatar)}}">
                </v-avatar>
            </div>
            <div class="col-md-10">
                <a>{{$post->title}} <br>
                    <span class="text-muted">{{$post->subtitle}}</span>
                </a>
                <div class="d-flex flex-wrap">
                    <p class="mb-0 mr-2 mt-3 text-muted"><v-icon class="body-1">mdi-calendar</v-icon>{{$post->created_at->format('Y-m-d')}}</p>
                    <p class="mb-0 mr-2 mt-3 text-muted"><v-icon class="body-1">mdi-dialpad</v-icon>{{$post->created_at->format('Y-m-d')}}</p>
                </div>

            </div>
        </div>
    </div>
</div>
