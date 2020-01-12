<template>
    <div>
        <input v-for="elem,key in values" :value="elem" type="hidden" :name="'categories['+key+']'">
        <v-autocomplete
                v-model="values"
                :items="items"
                outlined
                dense
                chips
                item-text="name"
                item-value="id"
                small-chips
                label="Outlined"
                :loading="loading"
                multiple
        >
            <template v-slot:item="{item}">
                <v-list-item-avatar>
                    <img :src="$root.getSrc(item.image)">
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title v-html="item.name"></v-list-item-title>
                    <v-list-item-subtitle v-html="item.name"></v-list-item-subtitle>
                </v-list-item-content>
            </template>
        </v-autocomplete>
    </div>
</template>
<script>
    import {getCategories} from "../api/categories";

    export default {
        props:{value: Array},
        data(){
            return{
                values: null,
                items:[],
                loading: false,
            }
        },
        mounted() {
            this.getCategories();
            if(this.value){
                this.values = this.value.map(item => {
                    return item.id;
                })
            }
        },
        methods:{
            getCategories(){
                this.loading = true;
                getCategories().then(res => {
                    this.items = res;
                    this.loading = false;
                })
            },
        }
    }
</script>