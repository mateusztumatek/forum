<v-app-bar
    v-cloak
    app
    scroll-target="#scrolling-techniques"
>
    <template v-slot:img="{ props }">
        <v-img
            v-bind="props"
            gradient="to top right, rgba(19,84,122,.5), rgba(128,208,199,.8)"
        ></v-img>
    </template>
    <div class="container v-toolbar__content">
        <v-toolbar-title small>
            <img style="max-width: 100px" src="{{url('/storage/default/logo.png')}}">
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn @click="toggleMenu()" class="mx-2" color="transparent" depressed><v-img max-width="20px" class="mr-2" :src="$root.getSrc('default/menu.svg')"></v-img>MENU</v-btn>
        <v-btn class="mx-2" icon>
            <v-icon>mdi-magnify</v-icon>
        </v-btn>
        <v-menu
                offset-y
                bottom
                transition="scale-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn
                        class="mx-2 mr-0"
                        icon
                        v-on="on"
                >
                    <v-avatar size="30" v-if="$user.user">
                        <v-img :src="$root.getSrc($user.user.avatar)"></v-img>
                    </v-avatar>
                    <v-icon v-else>mdi-account</v-icon>
                </v-btn>
            </template>
            @if(!\Illuminate\Support\Facades\Auth::check())
                <v-list>
                    <v-list-item dense @click="$user.showLogin()">
                        <v-list-item-title>{{__('my.Zaloguj się')}}</v-list-item-title>
                    </v-list-item>
                    <v-list-item dense @click="$user.showRegister()">
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