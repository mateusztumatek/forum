<template>
    <div>
        <div class="d-flex justify-center my-5" v-if="loading">
            <v-progress-circular
                    indeterminate
                    color="primary"
            ></v-progress-circular>
        </div>

        <v-btn v-if="!addComment" color="primary" class="w-100 my-5" style="min-height:60px" @click="addComment = true">Dodaj komentarz</v-btn>
        <v-card class="my-5" v-if="addComment">
            <v-card-title>Dodaj nowy komentarz</v-card-title>
            <v-card-text>
                <v-text-field :error="comment.errors && comment.errors.email" :error-messages="(comment.errors)? comment.errors.email : null" :disabled="user != null" v-model="comment.email" outlined label="Twój adres email"></v-text-field>
                <trumbowyg v-model="comment.comment"></trumbowyg>
                <span v-if="comment.errors && comment.errors.comment" style="color: red; font-size: 0.8rem">{{comment.errors.comment[0]}}</span>

                <files-component v-model="comment.attachments"></files-component>
                <v-btn color="primary" @click="saveComment()">Dodaj</v-btn>
            </v-card-text>
        </v-card>
        <div v-if="comments">
            <div v-for="comment,key in comments.data">
                <comment-component @deleted="deleteComment(key)" @update="updateComment" :user="user" :comment="comment"></comment-component>
            </div>
        </div>
    </div>
</template>
<script>
    import {getPostComments, addComment} from "../../api/comments";
    import Trumbowyg from 'vue-trumbowyg';

    export default {
        components:{
            Trumbowyg
        },
        props:['post_id', 'user'],
        watch:{
            user: function(){
                if(this.user){
                    this.comment.email = this.user.email
                }
            }
        },
        data(){
            return{
                addComment: false,
                comment:{type:'posts'},
                props:{},
                comments:null,
                loading: true,
            }
        },
        mounted() {
          this.getComments();
          this.comment.foreign_key = this.post_id;
        },
        methods:{
            deleteComment(key){
                this.comments.data.splice(key, 1);
            },
            saveComment(){
                this.loading = true;
                addComment(this.comment).then(res => {
                    this.loading = false;
                    this.addComment = false;
                    this.getComments();
                }).catch(e => {
                    if(e.response){
                        this.comment.errors = e.response.data.errors;
                    }

                    this.loading = false;
                })
            },
            updateComment(data){
                var index = this.comments.data.findIndex(x => x.id == data.id);
                if(index != -1) this.comments.data[index] = data;
            },
            getComments(){
                getPostComments(this.post_id, this.params).then(response => {
                    this.comments = response;
                    this.loading = false;
                }).catch(e => {
                    this.$root.$eventBus.$emit('addError', {text: 'Nie udało się pobrać komentarzy do tego postu.'});
                })
            }
        }
    }
</script>