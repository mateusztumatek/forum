@php
    $posts_count = \App\Post::active()->count();
    $users_count = \App\User::count();
    $comments_count = \App\Comment::count();

@endphp
<v-card>
    <v-card-title>
        Statystyki forum
    </v-card-title>
    <v-card-text>
        <v-list>
            <v-list-item>
                <v-list-item-content class="text-muted">Ilość postów:</v-list-item-content>
                <v-list-item-action class="font-weight-bold">{{$posts_count}}</v-list-item-action>
            </v-list-item>
            <v-list-item>
                <v-list-item-content class="text-muted">Ilość komentarzy:</v-list-item-content>
                <v-list-item-action class="font-weight-bold">{{$comments_count}}</v-list-item-action>
            </v-list-item>
            <v-list-item>
                <v-list-item-content class="text-muted">Ilość użytkowników:</v-list-item-content>
                <v-list-item-action class="font-weight-bold">{{$users_count}}</v-list-item-action>
            </v-list-item>
        </v-list>
    </v-card-text>
</v-card>