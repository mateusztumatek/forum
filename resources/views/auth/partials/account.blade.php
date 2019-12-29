<form id="tab_account" action="{{route('account.update', ['id' => $user->id])}}" method="post">
    @CSRF
    <v-text-field label="Login" @if($errors->has('login')) :error="true" error-messages="{{$errors->get('login')[0]}}" @endif  outlined name="login" value="{{$user->login}}"></v-text-field>
    <v-text-field label="Imię i nazwisko" outlined name="name" value="{{$user->name}}"></v-text-field>
    <v-text-field label="Miasto" outlined name="city" value="{{$user->city}}"></v-text-field>
    <v-text-field label="Ulica" outlined name="street" value="{{$user->street}}"></v-text-field>
    <v-text-field label="Kod pocztowy" outlined name="postal" value="{{$user->postal}}"></v-text-field>
    <div class="w-100">
        <input type="hidden" name="birth_date">
        <v-date-picker label="Data urodzenia" @change="updateInput('birth_date', $event)"  @if($user->birth_date) value="{{$user->birth_date->format('Y-m-d')}}" @endif></v-date-picker>
    </div>
    <v-btn type="submit" class="mt-4" tile color="primary">Zapisz</v-btn>
</form>
