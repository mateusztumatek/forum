import {upload} from "./api/upload";
import {updateUser} from "./api/auth";

export default {
    data: () => {
        return{
            base_url: null,
        }
    },
    mounted(){
        this.base_url = base_url;
    },
    methods:{
        getSrc(path){
            return this.base_url+'/storage/'+path;
        },
        updateAvatar(event){
            var formData = new FormData();
            formData.append('file', event.target.files[0]);
            upload(formData, 'users').then(response => {
                var data = {...this.$root.user, avatar: response.data[0]};
               updateUser(this.$root.user.id, data).then(response => {
                   this.$root.$eventBus.$emit('addNotification', ({text: 'Zaktualizowano użytkownika'}));
                   this.$root.$eventBus.$emit('updateUser', data);
               })
            })
        }
    }
}