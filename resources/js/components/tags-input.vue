<template>
    <div>
        <input v-for="elem,key in selected" :value="elem" type="hidden" :name="'tags['+key+']'">
        <v-combobox
                v-model="selected"
                :items="items"
                hide-selected
                label="Tagi"
                item-text="tag"
                item-value="tag"
                multiple
                @change="updateField"
                small-chips
                :loading="loading"
                flat
        >
            <template  v-slot:selection="{ attrs, item, parent, index }">
                <v-chip
                        color="primary"
                        small
                >
                  <span class="pr-2">
                    {{ item }}
                  </span>
                    <v-icon
                            small
                            @click="selected.splice(index, 1)"
                    >mdi-close</v-icon>
                </v-chip>
            </template>
        </v-combobox>
    </div>
</template>
<script>
    import {getTags} from "../api/tags";

    export default {
        props:{value: Array},
        data(){
            return{
                colors: ['green', 'purple', 'indigo', 'cyan', 'teal', 'orange'],
                loading: false,
                selected: null,
                items:[]
            }
        },
        mounted() {
            if(this.value){
                this.selected = this.value.map(item => {
                    return item.tag;
                });
            }
            this.getTags();
        },
        methods:{
            updateField(data){
                this.selected = data.map(item => {
                    if(typeof item == 'object') return item.tag;
                    return item;
                })
            },
            getTags(){
                this.loading = true;
                getTags().then(res => {
                    this.loading = false;
                    this.items = res;
                })
            },
            saveTag(){
                console.log(this.selected);
            }
        }
    }
</script>