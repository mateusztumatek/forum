<template>
    <div class="notifications">
        <transition-group name="fade">
            <v-alert :key="'not'+k" border="left" min-width="400px" elevation="2" v-for="(notification,k) in notifications" dismissible color="primary" :icon="notification.icon">
                <v-row align="center">
                    <v-col class="grow py-0">{{notification.text}}</v-col>
                    <v-col class="shrink py-0" v-if="notification.action">
                        <v-btn outlined dense small :href="notification.action.url">{{notification.action.text}}</v-btn>
                    </v-col>
                </v-row>
            </v-alert>
            <v-alert :key="'err'+k" border="left" min-width="400px" elevation="2" v-for="(notification,k) in errors" dismissible type="error" :icon="notification.icon">
                <v-row align="center">
                    <v-col class="grow py-0">{{notification.text}}</v-col>
                    <v-col class="shrink py-0" v-if="notification.action">
                        <v-btn outlined dense small :href="notification.action.url">{{notification.action.text}}</v-btn>
                    </v-col>
                </v-row>
            </v-alert>
        </transition-group>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                errors:[],
                notifications:[]
            }
        },
        mounted() {
            if(typeof errors != 'undefined'){
                this.errors = errors;
                setTimeout(() => this.errors = [], 3000)
            }
            if(typeof notifications != 'undefined'){
                this.notifications = notifications;
                setTimeout(() => this.notifications = [], 3000)
            }
            this.$root.$eventBus.$on('addError', data => {
                this.errors.push(data);
            })
            this.$root.$eventBus.$on('addNotification', data => {
                this.notifications.push(data);
            })
        }
    }
</script>
<style lang="scss">
    .notifications{
        position: fixed;
        right:3vw;
        top: 20vh;
        z-index: 10000;
    }
</style>
