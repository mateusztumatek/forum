<template>
    <div class="col-md-12">
        <div id="page_builder">
        </div>
        <input type="hidden" name="css" :value="css">
        <input type="hidden" name="html" :value="html">
    </div>
</template>
<script>
    import 'grapesjs/dist/css/grapes.min.css';
    import 'grapesjs-preset-webpage/dist/grapesjs-preset-webpage.min.css';
    import grapesjs from 'grapesjs';
    import 'grapesjs-preset-webpage/dist/grapesjs-preset-webpage.min';
    import {getUploads} from "../api/upload";
    import 'grapesjs-lory-slider/dist/grapesjs-lory-slider.min';
    import 'grapesjs-blocks-flexbox/dist/grapesjs-blocks-flexbox.min';
    export default {
        props:['data'],
        data:() => {
            return {
                editor: null,
                html: null,
                css: null,
                assets:[],
            }
        },
        mounted() {
            this.getMedia().then(res => {
                this.init();
            })
        },
        methods:{
            getMedia(){
                return new Promise((resolve, reject) => {
                    getUploads({folder: '//page_builder'}).then(response => {
                        var tmp = [];
                        response.forEach(item => {
                            if(item.type == 'image/png' || item.type == 'item/jpg'){
                                tmp.push(item.path);
                            }
                        })
                        this.assets = tmp;
                        resolve();
                    })
                })
            },
            init(){
                setTimeout(() => {
                    if(this.data){
                        this.html = this.data.html;
                        this.css = this.data.css;
                    }else{
                        this.html = '';
                        this.css = '';
                    }
                    this.editor = grapesjs.init({
                        container: '#page_builder',
                        height: '900px',
                        width: 'auto',
                        plugins: ['gjs-preset-webpage', 'gjs-blocks-flexbox'],
                        components: this.html,
                        style: this.css,
                        assetManager: {
                            autoAdd: 1,
                            assets: this.assets,
                            uploadName: 'file',
                            multiUpload: false,
                            upload: base_url+'/admin/media/upload',
                            params: {
                                is_builder: true,
                                upload_path: '//page_builder'
                            },
                        },
                        storageManager: {
                            autoload: false,
                        },
                    });

                    this.editor.on('storage:start', () => {
                        this.html = this.editor.getHtml();
                        this.css = this.editor.getCss();
                    });
                }, 50)
            }
        }

    }
</script>