import {login, register} from "../api/auth";

export default {
    data:() => {
        return{
            user:null,
            login:{},
            register:{},
            is_login: false,
            is_register: false,
            birth_date: null,
        }
    },
    methods:{
        setUser(user){
            this.user = user;
        },
        showLogin(){
            this.is_login = !this.is_login;
        },
        showRegister(){
            this.is_register = !this.is_register;
        },
        processLogin(){
            return new Promise((resolve, reject) => {
                login(this.login).then(res => {
                    this.user = res;
                    resolve(res);
                }).catch(e => {
                    reject(e);
                })
            })

        },
        processRegister(){
            return new Promise((resolve, reject) => {
                register(this.register).then(user => {
                    this.user = user;
                    resolve(user);
                }).catch(e => {
                    reject(e);
                })
            })

        }
    }
}