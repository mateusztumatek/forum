@foreach($posts as $post)
        @include('posts.small', ['post' => $post])
    @endforeach
{{$posts->links()}}
