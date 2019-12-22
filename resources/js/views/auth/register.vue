<template>
    <div>
        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <div class="w-100 d-flex justify-content-between">
                        <div>
                            <span class="headline">{{$t('Zarejestruj się')}}</span>
                        </div>
                        <div>
                            <v-btn @click="close()" icon fab x-small><v-icon>mdi-close</v-icon></v-btn>
                        </div>
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-text-field :error-messages="errors['name']" :error="errors['name'] && errors['name'].length > 0" v-model="user.name" :label="$t('Imię i nazwisko')" required></v-text-field>
                    <v-text-field :error-messages="errors['email']" :error="errors['email'] && errors['email'].length > 0" v-model="user.email" :label="$t('Adres email')" required></v-text-field>

                    <v-text-field :error-messages="errors['password']" :error="errors['password'] && errors['password'].length > 0" v-model="user.password" type="password" :label="$t('Hasło')" required></v-text-field>
                    <v-text-field :error-messages="errors['password_confirmation']" :error="errors['password_confirmation'] && errors['password_confirmation'].length > 0" v-model="user.password_confirmation" type="password" :label="$t('Potwierdź hasło')" required></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" raised @click="register()">Zarejestruj się</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    import {register} from "../../api/auth";

    export default {
        props:[],
        data(){
            return{
                dialog: true,
                user: {},
                errors:[],
            }
        },
        mounted() {
        },
        methods:{
            register(){
                register(this.user).then(res => {
                    this.$emit('logged', res);
                }).catch(e => {
                    this.errors = e.response.data.errors;
                })
            },
            close(){
                this.$emit('close')
            }
        }
    }
</script>
