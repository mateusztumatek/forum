<form action="{{route('account.index', ['id' => $user->id])}}" method="GET">
    <v-text-field @if(request('term')) value="{{request('term')}}" @endif outlined label="Szukaj" name="term">
        <template v-slot:append-outer>
            <div >
                <v-btn type="submit" color="primary" fab><v-icon>mdi-magnify</v-icon></v-btn>
            </div>
        </template>
    </v-text-field>
</form>
@if(Auth::id() == $user->id)
<v-btn :href="'/posts/create'" class="mb-3" color="primary">Dodaj nowy post</v-btn>
@endif
@foreach($posts as $post)
        @include('posts.small', ['post' => $post])
    @endforeach
{{$posts->links()}}