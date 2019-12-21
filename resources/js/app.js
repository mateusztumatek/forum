/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');
import vuetify from './plugins/vuetify';
import prototypes from './plugins/auth';
import { i18n } from "./plugins/i18n";

Vue.use(prototypes);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    i18n,
    vuetify,
    el: '#app',
    data(){
        return{
            user:null,

            base_url:'',
        }
    },
    mounted() {
        this.base_url = base_url;
        this.user = user;
        if(login) this.login();
        if(register) this.register();
    },
    methods:{
        login(){
            this.$login().then(user => {
                this.user = user.user;
            })
        },
        register(){
            this.$register().then(user => {
                this.user = user;
            })
        }
    }

});
