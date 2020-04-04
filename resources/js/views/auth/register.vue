<template>
    <div>
        <v-dialog v-model="$user.is_register" :width="width">
            <v-card style="overflow: hidden">
                <div class="row">
                    <div class="col-md-6">
                        <v-card-text class="pa-8" v-if="!registered">
                            <v-form ref="register_form">
                                <div style="animation-delay: 200ms" class="my-header slideInTop">
                                    <h2>Zarejestruj się</h2>
                                    <span>I czerp nieograniczoną wiedzę z naszego forum.</span>
                                </div>
                                <v-text-field prepend-icon="mdi-account" class="slideInTop" style="animation-delay: 300ms" :error-messages="errors.name"  v-model="$user.register.name" :label="$t('Imię i nazwisko')" required></v-text-field>
                                <v-text-field prepend-icon="mdi-email" class="slideInTop" style="animation-delay: 400ms" :error-messages="errors['email']" v-model="$user.register.email" :label="$t('Adres email')" required></v-text-field>

                                <v-text-field prepend-icon="mdi-shield-check" class="slideInTop" style="animation-delay: 500ms" :error-messages="errors['password']" v-model="$user.register.password" type="password" :label="$t('Hasło')" required></v-text-field>
                                <v-text-field prepend-icon="mdi-shield-check" class="slideInTop" style="animation-delay: 600ms" :error-messages="errors['password_confirmation']" v-model="$user.register.password_confirmation" type="password" :label="$t('Potwierdź hasło')" required></v-text-field>
                                <v-switch v-model="$user.register.rules" :rules="[validations.required, validations.accepted]" label="Rozumiem regulamin forum i go akceptuję"></v-switch>
                                <div class="row justify-center mt-3 slideInTop" style="animation-delay: 700ms">
                                    <v-btn class="m-auto" outlined color="primary" :loading="loading" raised @click="register()">Zarejestruj się</v-btn>
                                </div>
                            </v-form>
                        </v-card-text>
                        <v-card-text v-else>
                            <p>Zweryfikuj swój adres email klikając w link wysłany w wiadomości email na konto: {{registered.email}}</p>
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
    import {register} from "../../api/auth";

    export default {
        props:[],
        data(){
            return{
                validations:{
                    required: v => !!v || 'Ten element jest wymagany',
                    accepted: v => v == true || 'Musisz potwierdzić ten element'
                },
                user: {},
                errors:[],
                registered:null,
                loading: false,
            }
        },
        computed:{
          width(){
              if(this.$vuetify.breakpoint.smAndDown) return '98%';
              if(this.$vuetify.breakpoint.smAndUp && this.$vuetify.breakpoint.mdAndDown) return '80%';
              if(this.$vuetify.breakpoint.mdAndUp) return '60%';
          }
        },
        methods:{
            register(){
                if(this.$refs.register_form.validate()){
                    this.loading = true;
                    this.$user.processRegister().then(response => {
                        this.registered = response;
                        this.loading = false;
                    }).catch(e => {
                        this.errors = e.response.data.errors;
                        this.loading = false;
                    })
                }
            },
            close(){
                this.$emit('close')
            }
        }
    }
</script>
