<template>
    <div>
        <input :error="errors.length > 0" :error-messages="errors" type="hidden" v-for="file in files" :name="'attachments['+file+']'" :value="file">
        <v-file-input label="Dodaj pliki" multiple ref="files" @change="uploadFiles"></v-file-input>
        <v-list>
            <v-list-item v-for="file,key in files">
                <v-list-item-content>Plik {{key}} <span class="text-muted">{{file}}</span>
                <a download :href="$root.getSrc(file)" target="_blank">Pobierz plik</a>
                </v-list-item-content>
                <v-list-item-action><v-btn color="danger" @click="files.splice(key, 1)" icon><v-icon>mdi-delete</v-icon></v-btn></v-list-item-action>
            </v-list-item>
        </v-list>
        <v-alert v-for="err in errors" type="error">{{err}}</v-alert>
    </div>
</template>
<script>
    import {upload} from "../api/upload";

    export default {
        props:{value: Array, path: null},
        watch:{
            files: function () {
                this.$emit('input', this.files);
            }
        },
        data(){
            return{
                files:[],
                errors:[]
            }
        },
        mounted(){
          if(this.value){
              this.files = this.value;
          }
        },
        methods:{
            uploadFiles(files){
                var formData = new FormData();
                files.forEach((index, item) => {
                    formData.append('files['+item+']', index);
                })
                var path = '';
                (this.path)? path = this.path : path = 'posts';
                upload(formData, path).then(res => {
                    res.data.forEach(i => {
                        this.files.push(i);
                    })
                }).catch(e => {
                    this.errors.push('Coś poszło nie tak, plik może być zbyt duży');
                    setTimeout(() => {this.errors = []}, 5000);
                })
            }
        }
    }
</script>