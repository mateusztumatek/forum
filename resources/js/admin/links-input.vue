<template>
    <div>
        <div class="col-md-12">
            <button type="button" @click class="btn btn-primary" @click="component_data.links.push({})">Dodaj link</button>
            <div v-for="(item,index) in component_data.links" style="padding: 15px">
                <div class="card">
                    <div class="form-group">
                        <label>Link</label>
                        <input class="form-control" v-model="item.url">
                    </div>
                    <div class="form-group">
                        <label>Text w linku</label>
                        <input class="form-control" v-model="item.text">
                    </div>
                    <button type="button" class="btn btn-danger" @click="component_data.links.splice(index, 1)">Usun link</button>
                </div>
            </div>
            <div class="form-group">
                <label>Wyrównanie</label>
                <select class="form-control" v-model="component_data.alignment">
                    <option value="left">Wyrównanie do lewej</option>
                    <option value="right">Wyrównanie do prawej</option>
                    <option value="center">Wyrównanie do środka</option>
                </select>
            </div>
            <input name="data" :value="jsonData" type="hidden">
        </div>
    </div>
</template>
<script>
    export default {
        props:['data'],
        computed:{
          jsonData(){
              return JSON.stringify(this.component_data);
          }
        },
        data:() => {
            return{
                component_data:{
                    links:[],
                },
            }
        },
        mounted() {
            if(this.data && this.data.data){
                this.component_data = JSON.parse(this.data.data);
            }
        }
    }
</script>