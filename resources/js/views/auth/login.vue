<template>
    <div>
        <v-dialog v-model="$user.is_login" :width="width">
            <v-card style="overflow: hidden">
                <div class="row">
                    <div class="col-md-6">
                        <v-card-text class="pa-8">
                            <div style="animation-delay: 200ms" class="my-header slideInTop">
                                <h2>Zaloguj się</h2>
                                <span>I czerp nieograniczoną wiedzę z naszego forum.</span>
                            </div>
                            <v-text-field prepend-icon="mdi-email" class="slideInTop" style="animation-delay: 300ms" :error-messages="mergeErrors"  v-model="$user.login.email" :label="$t('Adres email')" required></v-text-field>
                            <v-text-field prepend-icon="mdi-shield-check" class="slideInTop" style="animation-delay: 400ms" :error-messages="errors.password" v-model="$user.login.password" type="password" :label="$t('Hasło')" required></v-text-field>
                            <div class="row justify-center mt-3 slideInTop" style="animation-delay: 500ms">
                                <v-btn class="m-auto" outlined color="primary" :loading="loading" raised @click="login()">Zaloguj się</v-btn>
                            </div>
                            <div class="mt-10">
                                <div class="row justify-center">
                                    <v-btn class="ma-2" color="grey" :href="$root.base_url+'/auth/google'" dark depressed><v-icon class="mr-3">mdi-google</v-icon>Google</v-btn>
                                    <v-btn class="ma-2" color="grey" :href="$root.base_url+'/auth/facebook'"  dark depressed><v-icon class="mr-3">mdi-facebook</v-icon>Facebook</v-btn>
                                </div>
                            </div>
                        </v-card-text>
                    </div>
                    <div class="col-md-6 py-0">
                        <v-img class="w-100" :src="$root.getSrc('default/login.jpg')" :min-height="($vuetify.breakpoint.smAndUp)? '60vh' : '35vh'"></v-img>
                    </div>
                </div>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    import {login} from "../../api/auth";

    export default {
        props:[],
        data(){
            return{
                loading:false,
                errors:{},
            }
        },
        computed:{
            mergeErrors(){
              if(this.errors.login) return this.errors.login;
              if(this.errors.email) return this.errors.email;
              return null;
            },
            width(){
                if(this.$vuetify.breakpoint.smAndDown) return '95%';
                if(this.$vuetify.breakpoint.smAndUp && this.$vuetify.breakpoint.mdAndDown) return '80%';
                if(this.$vuetify.breakpoint.mdAndUp) return '60%';
            },
        },
        methods:{
            login(){
                this.loading = true;
                this.$user.processLogin().then(response => {
                    this.loading = false;
                    this.close();
                }).catch(e => {
                    this.errors = e.response.data.errors;
                    this.loading = false;
                })
            },
            close(){
                this.$emit('close')
            }
        }
    }
</script>
