@component('mail::panel')
    Kod weryfikacyjny do zaktualizowania konta {{$user->name}} to:<br>
    <h2 style="text-align: center; font-weight: bold; font-size: 3rem">{{$user->update_code}}</h2>
@endcomponent
