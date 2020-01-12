<template>
    <div>
      <div class="d-flex flex-wrap">
          <v-chip x-small v-bind:class="{'emote-active': userRate && userRate.type == icon.type}" class="emote elevation-1 mr-2" color="transparent" v-for="icon in icons">
              <img @click="(userRate && userRate.type == icon.type)? deleteRate() : setRate(icon.type)" class="mr-2" :src="$root.getSrc(icon.img)"><span class="font-weight-bold">{{getTypeCount(icon.type)}}</span>
          </v-chip>
      </div>
    </div>
</template>
<script>
    import {getRates, setRate, deleteRate} from "../../api/rates";

    export default {
        props:{table: String, id: null, data:Array, user: null},
        data(){
            return{
                icons:[
                    {
                        img: '/default/like.png',
                        type: 1
                    },
                    {
                        img: '/default/love.png',
                        type: 2
                    },
                    {
                        img: '/default/haha.png',
                        type: 3
                    },
                    {
                        img: '/default/woo.png',
                        type: 4
                    },
                    {
                        img: '/default/angry.png',
                        type: 5
                    }
                ],
                rates:null,
            }
        },
        computed:{
            userRate(){
                if(this.user){
                    if(this.rates){
                        var arr = this.rates.filter(item => {
                            return item.user_id == this.user.id;
                        })
                        if(arr.length > 0){
                            return arr[0];
                        }
                    }
                }
                return null;
            }
        },
        mounted() {
            if(this.data){
                this.rates = this.data;
            }else{
                this.getRates();
            }
        },
        methods:{
            deleteRate(){
                deleteRate(this.userRate.id).then(res => {
                    var index = this.rates.findIndex(x => x.id == this.userRate.id);
                    if(index != -1) this.rates.splice(index, 1);
                })
            },
            setRate(rate){
                if(!this.user){
                    this.$login();
                    return null;
                }
                setRate({foreign_key: this.id, table: this.table, type: rate}).then(res => {this.rates = res});
            },
            getRates(){
                getRates({table: this.table, id: this.id}).then(response => {this.rates = response;})
            },
            getTypeCount(type){
              if(this.rates){
                  return this.rates.filter(item => {
                      return item.type == type;
                  }).length;
              }
              return 0;
            },
        }

    }

</script>
<style lang="scss">
    .emote{
        cursor: pointer;
        overflow: visible;
        padding: 0px 3px !important;
        padding-left: 20px !important;
        transition: all 200ms;
        img{
            max-width: 14px;
            transition: all 200ms;
            position: absolute;
            left: 1px;
        }

        &:hover{
            padding-left: 30px !important;

            img{
                max-width: 25px;
                animation-name: icon;
                animation-duration: 1.2s;
                animation-fill-mode: forwards;
                animation-timing-function: ease-out;
            }
        }
    }
    .emote-active{
        padding-left: 30px !important;
        img{
            max-width: 25px;
            animation-name: icon;
            animation-duration: 1.2s;
            animation-fill-mode: forwards;
            animation-timing-function: ease-out;
        }
    }
    @keyframes icon {
        0%{
            transform: rotate(-0deg);
        }
        25%{
            transform: rotate(-45deg);
        }
        50%{
            transform: rotate(-0deg);
        }
        75%{
            transform: rotate(45deg);
        }
        100%{
            transform: rotate(0deg);
        }
    }
</style>