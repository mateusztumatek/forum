@foreach ($items as $index => $item)
    <v-list-item two-line href="{{$item->url}}" class="slideInTop" style="animation-delay: {{$index + 1}}00ms">
        <v-list-item-content>
            <v-list-item-title><v-icon class="mr-5">{{$item->icon_class}}</v-icon><a href="{{url('/')}}">{{$item->title}}</a></v-list-item-title>
        </v-list-item-content>
    </v-list-item>
    @endforeach