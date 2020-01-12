<template>
    <div>
        <v-card class="my-2">
            <v-card-text>
                <div class="row">
                    <div class="col-md-2 text-center">
                        <v-avatar v-if="comment.user">
                            <v-img :src="$root.getSrc(comment.user.avatar)"></v-img>
                        </v-avatar>
                        <p v-if="comment.user" style="font-size: 0.8rem" class="mt-2 mb-0">{{comment.user.name}}</p>
                        <p v-if="!comment.user" style="font-size: 0.8rem" class="mt-2 mb-0">{{comment.email}}</p>
                    </div>
                    <div class="col-md-10">
                        <span class="text-muted caption"><v-icon style="font-size: 0.8rem">mdi-calendar</v-icon>{{comment.created_at}}</span>
                        <div>
                            <div v-if="!edit_comment.id" v-html="comment.comment"></div>
                            <div v-if="edit_comment.id">
                                <trumbowyg v-model="edit_comment.comment"></trumbowyg>
                                <span v-if="edit_comment && edit_comment.errors && edit_comment.errors.comment" style="color: red; font-size: 0.8rem">{{edit_comment.errors.comment[0]}}</span>
                            </div>
                        </div>
                        <div class="row" v-if="!edit_comment.id">
                            <div v-for="attachment in comment.attachments" class="ma-2 text-center">
                                <v-icon style="font-size:2rem">mdi-file</v-icon>
                                <a download :href="$root.getSrc(attachment)">Pobierz plik</a>
                            </div>
                        </div>
                        <div v-if="edit_comment.id">
                            <files-component :files="edit_comment.attachments" v-model="edit_comment.attachments"></files-component>
                            <v-btn :loading="loading" @click="updateComment()" color="primary">Zapisz</v-btn>
                            <div class="mt-3">
                                <div  v-for="err in edit_comment.errors">
                                    <v-alert type="error" v-for="e in err">{{e}}</v-alert>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </v-card-text>
            <div class="actions d-flex align-items-center">
                <rates-component table="comments" :id="comment.id" :data="comment.rates" :user="user"></rates-component>

                <v-menu bottom left>
                    <template v-slot:activator="{ on }">
                        <v-btn
                                icon
                                v-on="on"
                        >
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>

                    <v-list>
                        <v-list-item v-if="isOwner" @click="edit_comment = comment">Edytuj</v-list-item>
                        <v-list-item v-if="isOwner" @click="deleteComment()">Usuń</v-list-item>
                        <v-list-item>Zgłoś</v-list-item>
                    </v-list>
                </v-menu>
            </div>
        </v-card>
    </div>
</template>
<script>
    import Trumbowyg from 'vue-trumbowyg';
    import {updateComment, deleteComment} from "../../api/comments";

    export default {
        props:{comment: Object, user: null},
        components:{
            Trumbowyg
        },
        data(){
            return{
                edit_comment:{},
                loading: false,
            }
        },
        computed:{
            isOwner(){
                if(!this.user) return false;
                return this.user.id == this.comment.user_id;
            }
        },
        methods:{
            deleteComment(){
                deleteComment(this.comment.id).then(res => {
                    this.$emit('deleted');
                }).catch(e => {
                    this.$root.$eventBus.$emit('addError', {text: e.response.data.message});
                })
            },
            updateComment(){
                this.loading = true;
                updateComment(this.edit_comment.id, this.edit_comment).then(res => {
                    this.$emit('update', res);
                    this.$set(this, 'edit_comment', {});
                    this.loading = false;
                }).catch(e => {
                    if(e.response){
                        this.$set(this.edit_comment, 'errors', e.response.data.errors);
                    }
                    this.loading = false;
                })
            }
        }
    }
</script>