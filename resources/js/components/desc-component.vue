<template>
    <div>
        <trumbowyg name="content" :value="value" class="form-control"></trumbowyg>
        <span v-if="errorMessages" style="color: red; font-size: 0.8rem">{{errorMessages}}</span>
    </div>
</template>
<script>
    import Trumbowyg from 'vue-trumbowyg';

    import 'trumbowyg/dist/ui/trumbowyg.css';
    export default {
        props:['value', 'error', 'errorMessages'],
        components:{
            Trumbowyg
        },
    }
</script>