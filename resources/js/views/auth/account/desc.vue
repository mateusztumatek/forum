<template>
    <div>
        <form :action="$root.base_url+'/user/'+user.id+'/update'" method="POST">
            <input type="hidden" name="_token" :value="$root.csrf_token" />
            <input type="hidden" name="tab" value="desc">
            <trumbowyg  name="desc" :value="user.desc" class="form-control"></trumbowyg>
            <v-btn color="primary" type="submit">Zapisz</v-btn>
        </form>
    </div>
</template>
<script>
    import Trumbowyg from 'vue-trumbowyg';

    import 'trumbowyg/dist/ui/trumbowyg.css';
    export default {
        props:['user'],
        components:{
            Trumbowyg
        }
    }
</script>