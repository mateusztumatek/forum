import vuetify from "../plugins/vuetify";
import Login from '../views/auth/login';
import Register from '../views/auth/register';
import {i18n} from '../plugins/i18n';
export default {
    install: (Vue, options) => {
        Vue.prototype.$login = () => {
            return new Promise((resolve, reject) => {
                const dialog = new Vue({
                    vuetify,
                    i18n,
                    methods: {
                        closeHandler(arg) {
                            resolve(arg);
                            dialog.$destroy();
                            dialog.$el.remove();
                        },
                        close(){
                            reject();
                            dialog.$destroy();
                            dialog.$el.remove();
                        }
                    },
                    mounted(){
                      this.dialog = true;
                    },
                    data(){
                      return{
                          dialog: false,
                      }
                    },
                    render(h) {
                        return h(Login, {
                            props: {
                                dialog,
                            },
                            on: {
                                logged: this.closeHandler,
                                close: this.close,
                            }
                        });
                    }
                }).$mount();
                var app = document.getElementsByClassName('v-application--wrap')[0];
                app.appendChild(dialog.$el);
            })
        };
        Vue.prototype.$register = () => {
            return new Promise((resolve, reject) => {
                const dialog = new Vue({
                    vuetify,
                    i18n,
                    methods: {
                        closeHandler(arg) {
                            resolve(arg);
                            dialog.$destroy();
                            dialog.$el.remove();
                        },
                        close(){
                            reject();
                            dialog.$destroy();
                            dialog.$el.remove();
                        }
                    },
                    mounted(){
                        this.dialog = true;
                    },
                    data(){
                        return{
                            dialog: false,
                        }
                    },
                    render(h) {
                        return h(Register, {
                            props: {
                                dialog,
                            },
                            on: {
                                registered: this.closeHandler,
                                close: this.close,
                            }
                        });
                    }
                }).$mount();
                var app = document.getElementsByClassName('v-application--wrap')[0];
                app.appendChild(dialog.$el);
            })
        };
    }
}
