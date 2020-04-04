/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
require('./utilis/default');
window.Vue = require('vue');
require('./register_components.js');
import vuetify from './plugins/vuetify';
import { i18n } from "./plugins/i18n";
import User from './plugins/user';
require('./dependencies');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.prototype.$user = new Vue(User);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.prototype.$eventBus = new Vue();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import mixins from './mixins';
Vue.mixin(mixins);
const app = new Vue({
    i18n,
    vuetify,
    el: '#app',

    data(){
        return{
            menu: false,
            base_url:'',
            csrf_token: null,
        }
    },
    mounted() {
        this.csrf_token = csrf_token;
        this.base_url = base_url;
        this.$user.setUser(user);
        if(login) this.$user.login();
        if(register) this.$user.register();

    },
    methods:{
        toggleMenu(){
            this.$set(this, 'menu', !this.menu );
        },
        changeLocation(url){
            window.location.href = url;
        },

        udateInput(field, data){
            console.log($('input[name="'+field+'"]'));
            $('input[name="'+field+'"]').val(data);
        },
    }
});