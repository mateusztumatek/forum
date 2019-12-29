@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div v-if="user">
                        Użytkownik:
                        @{{user}}
                        <v-btn @click="$root.$eventBus.$emit('addNotification', {
                            'text': 'SIEMANKO'
                        })">Dodaj notification</v-btn>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
