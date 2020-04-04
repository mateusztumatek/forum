<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        @if(config('app.env') == 'production' || 1 == 1)
            [v-cloak]{
                opacity: 0;
                transition: all 200ms;
            }
            @endif
    </style>
    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    <v-app id="app" :class="{'blured-application': $user.is_login}">
        <div v-cloak>
            @include('layouts.header')
            <v-content>
                <div>
                    <main>
                        @yield('content')
                    </main>
                </div>
            </v-content>
            <login-component></login-component>
            <register-component></register-component>
            @include('layouts.menu')
            @include('layouts.footer')
            @include('layouts.notifications')
        </div>
    </v-app>
</body>
<script>
    var csrf_token = '{{csrf_token()}}';
    var base_url = '{{url('/')}}';
    @if(Auth::check())
    var user = {!! json_encode(\Illuminate\Support\Facades\Auth::user()->toArray(), JSON_HEX_TAG) !!};
    @else var user = null; @endif
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
    var notifications = [];
    var errors = [];
    @if(Auth::check() && !Auth::user()->city && Auth::user()->first_login)
        notifications.push({
            text: 'Uzupełnij swoje dane osobowe',
            action:{
                text: 'Uzupełnij',
                url: base_url+'/konto/{{Auth::id()}}'
            }
        });
        @endif
    @foreach($errors->all() as $error)
         errors.push({
            text: '{{$error}}'
        })
         @endforeach
</script>
<script src="{{ asset('js/app.js') }}"></script>

</html>
