<template>
    <div v-if="edit_user">
        <input type="hidden" name="tab" value="privacy">
        <v-switch v-model="edit_user.settings.subscription" true-value="1" false-value="0" label="Wysyłać nowości drogą mailową?"></v-switch>
        <v-text-field hint="Jeśli nie chcesz zmieniać adresu email wystarczy że zostawisz te pole takie same." :error-messages="errors['new_email']" label="Nowy adres email" outlined name="new_email" v-model="edit_user.new_email"></v-text-field>
        <v-text-field label="Nowe hasło" v-model="edit_user.new_password" outlined name="new_password" :error-messages="errors['new_password']" type="password"></v-text-field>
        <v-text-field label="Powtórz nowe hasło" outlined v-model="edit_user.confirmation_new_password" name="confirm_new_password" type="password"></v-text-field>
        <v-btn @click="save()" class="mt-4" tile color="primary">Zapisz</v-btn>
    </div>
</template>
<script>
    import {updateUser} from "../../../api/auth";

    export default {
        props:{user: Object},
        data(){
            return{
                edit_user:null,
                errors:[]
            }
        },
        mounted(){
            this.edit_user = this.user;
            this.edit_user.settings = {};
            if(!this.edit_user.settings.subscription){
                this.edit_user.settings.subscription = 0;
            }
            this.edit_user.tab = 'privacy';
        },
        methods:{
            save(){
                updateUser(user.id, this.edit_user).then(response => {
/*
                    window.location.reload();
*/
                }).catch(e => {
                    if(e.response.data.errors) this.errors = e.response.data.errors;
                });
            }
        }
    }
</script>
