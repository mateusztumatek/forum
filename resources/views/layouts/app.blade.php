<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <v-app id="app">
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
                <v-app-bar-nav-icon small></v-app-bar-nav-icon>

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

                    <v-list>
                        <v-list-item dense @click="login()">
                            <v-list-item-title>{{__('my.Zaloguj się')}}</v-list-item-title>
                        </v-list-item>
                        <v-list-item dense @click="register()">
                            <v-list-item-title>{{__('my.Zarejestruj się')}}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </div>
        </v-app-bar>
        <v-content>
            <div class="container">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </v-content>
    </v-app>
</body>
<script>
    var base_url = '{{url('/')}}';
    var user = JSON.parse('{!! json_encode(\Illuminate\Support\Facades\Auth::user()) !!}');
    @if(isset($login) && $login)
        var login = true;
        @else
        var login = false;
    @endif
            @if(isset($register) && $register)
                var register = true;
            @else
                var register = false;
    @endif
</script>
<script src="{{ asset('js/app.js') }}" defer></script>

</html>
