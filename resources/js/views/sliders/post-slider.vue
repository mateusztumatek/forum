<template>
    <div>
        <div class="container">
            <hooper :itemsToShow="4" :infiniteScroll="true">
                <slide v-for="post in posts" >
                    <div class="mt-8 mb-8 pa-4">
                        <v-card class="elevation-9" style="border-radius: 16px">
                            <v-card-title>{{post.user.name}}</v-card-title>
                            <v-card-text>
                                <v-avatar size="80" style="position: absolute; top: -40px">
                                    <img :src="$root.getSrc(post.user.avatar)">
                                </v-avatar>
                            </v-card-text>
                        </v-card>
                    </div>
                </slide>
            </hooper>
        </div>
    </div>
</template>
<script>
    import { Hooper, Slide } from 'hooper';
    import 'hooper/dist/hooper.css';
    export default {
        props:['posts'],
        components: {
            Hooper,
            Slide
        }
    }
</script>
<style lang="scss">
    .hooper-track{
        padding-left: 0px !important;
        .hooper-slide[class~="is-next"]{
            margin-left: 300px;
        }
    }
    .hooper-slide{
        transition: all 400ms;
    }
    .hooper-slide[class~="is-current"]{
        width: 40% !important;
        margin-right: 20%;
    }
    .hooper-slide[class~="is-active"]:not(.is-current){
        .v-card{
            box-shadow: 0 5px 6px -3px rgba(0,0,0,.09)!important;
        }
        margin-left: -190px;
        .v-card__title, .v-card__text{
            opacity: 0.6;
        }
    }
    @media screen and (max-width: 1500px){
        .hooper-slide[class~="is-current"]{
            margin-right: 30%;
        }
        .hooper-slide[class~="is-active"]:not(.is-current){
            margin-left: -100px;
        }
    }
</style>