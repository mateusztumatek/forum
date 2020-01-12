<form method="POST" action="{{route('account.update', ['id' => $user->id])}}">
    @CSRF
    <input type="hidden" name="tab" value="settings">
    <input name="settings[subscription]" type="hidden" @if($s = $settings->where('type', 'subscription')->first()) value="{{$s->value}}" @else value="" @endif>
    <v-switch @change="updateInput('settings[subscription]', $event)" true-value="1" false-value="0"  @if($s = $settings->where('type', 'subscription')->first()) input-value="{{$s->value}}" @endif  label="Subskrypcja email?"></v-switch>
    <input name="settings[profil_private]" type="hidden" @if($s = $settings->where('type', 'profil_private')->first()) value="{{$s->value}}" @else value="" @endif>
    <v-checkbox @change="updateInput('settings[profil_private]', $event)" true-value="1" false-value="0"  @if($s = $settings->where('type', 'profil_private')->first()) input-value="{{$s->value}}" @endif  label="Profil prywatny"></v-checkbox>
    <v-btn type="submit" color="primary">Zapisz</v-btn>
</form>