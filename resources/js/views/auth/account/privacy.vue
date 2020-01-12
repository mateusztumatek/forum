<template>
    <div v-if="edit_user">
        <input type="hidden" name="tab" value="privacy">
        <v-text-field hint="Jeśli nie chcesz zmieniać adresu email wystarczy że zostawisz te pole takie same." :error-messages="errors['new_email']" label="Nowy adres email" outlined name="new_email" v-model="edit_user.new_email"></v-text-field>
        <v-text-field label="Nowe hasło" v-model="edit_user.new_password" outlined name="new_password" :error-messages="errors['new_password']" type="password"></v-text-field>
        <v-text-field label="Powtórz nowe hasło" outlined v-model="edit_user.new_password_confirmation" name="confirm_new_password" type="password"></v-text-field>
        <v-btn @click="save()" class="mt-4" tile color="primary">Zapisz</v-btn>
        <v-alert class="mt-5" v-for="m in messages" type="success">{{m}}</v-alert>
        <v-dialog :value="(confirm && confirm.id)? true : false" persistent max-width="600px">

            <v-card v-if="confirm">
                <v-card-title>
                    <span class="headline">Wpisz kod</span>
                </v-card-title>
                <v-card-text>
                  <p>Wpisz kod wysłany na twój adres email: {{confirm.email}}</p>
                    <v-text-field v-model="code" outlined></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn :loading="loading" class="w-100" color="primary" dark text @click="update()">Zatwierdź</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    import {updateUser} from "../../../api/auth";

    export default {
        props:{user: Object},
        data(){
            return{
                edit_user:null,
                errors:[],
                confirm: null,
                code: null,
                loading:false,
                messages:[],
            }
        },
        mounted(){
            this.edit_user = this.user;
            this.edit_user.settings = {};
            this.edit_user.tab = 'privacy';
        },
        methods:{
            save(){
                this.loading = true;
                updateUser(user.id, this.edit_user).then(response => {
                    this.confirm = response;
                    this.loading = false;
                }).catch(e => {
                    if(e.response.data.errors) this.errors = e.response.data.errors;
                    this.loading = false;
                });
            },
            update(){
                this.loading = true;
                updateUser(user.id, {...this.edit_user, ...{'code': this.code}}).then(response => {
                    this.confirm = null;
                    this.loading = false;
                    this.messages.push('Udało sie zaktualizować konto');
                }).catch(e => {
                    if(e.response.data.errors) this.errors = e.response.data.errors;
                    this.loading = false;
                });
            }
        }
    }
</script>
