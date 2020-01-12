<v-app-bar
    v-cloak
    app
    color="#fcb69f"
    dark
    src="https://picsum.photos/1920/1080?random"
    scroll-target="#scrolling-techniques"
>
    <template v-slot:img="{ props }">
        <v-img
            v-bind="props"
            gradient="to top right, rgba(19,84,122,.5), rgba(128,208,199,.8)"
        ></v-img>
    </template>
    <div class="container v-toolbar__content">
        <v-app-bar-nav-icon class="ml-0" small></v-app-bar-nav-icon>

        <v-toolbar-title small>Title</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
            <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>mdi-heart</v-icon>
        </v-btn>

        <v-menu
            bottom
            origin="center center"
            transition="scale-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn
                    icon
                    v-on="on"
                >
                    <v-icon>mdi-account</v-icon>
                </v-btn>
            </template>
            @if(!\Illuminate\Support\Facades\Auth::check())
                <v-list>
                    <v-list-item dense @click="login()">
                        <v-list-item-title>{{__('my.Zaloguj się')}}</v-list-item-title>
                    </v-list-item>
                    <v-list-item dense @click="register()">
                        <v-list-item-title>{{__('my.Zarejestruj się')}}</v-list-item-title>
                    </v-list-item>
                </v-list>
            @else
                <form ref="logoutForm" method="POST" action="{{route('logout')}}">
                    @CSRF
                </form>
                <v-list>
                    <v-list-item dense href="{{route('account.index', ['id' => Auth::id()])}}">
                        <v-list-item-title>
                            {{__('my.Zobacz konto')}}
                        </v-list-item-title>
                    </v-list-item>
                    <v-list-item dense @click="$refs.logoutForm.submit()">
                        <v-list-item-title>
                            {{__('my.Wyloguj się')}}
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            @endif
        </v-menu>
    </div>
</v-app-bar>
@include('layouts.carousel')
@include('layouts.categories')