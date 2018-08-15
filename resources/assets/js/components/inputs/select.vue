<template>
    <div class="form-group">
        <label :for="forComputed">{{ etiquetaComputed }}</label>
        <select>
                <option disabled value="">Por favor escoja una opcion</option>
                <option v-for="option in options" :key="option.id">{{option.name}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        props: {
            options:{
                type:Object,
            },
            for: {
                type: String
            },
            etiqueta:{
                type: String,
                default: ''
            },
            clases:{
                type: String
            },
            id:{
                type: String
            },
            name:{
                type: String,
                required: true  
            }
        },
        computed: {
            idComputed() {
                return this.id || this.name;
            },
            etiquetaComputed(){
                return this.etiqueta ||  this.name.charAt(0).toUpperCase() + this.name.slice(1);
            },
            forComputed(){
                return this.for || this.idComputed;
            }
        },
    }
</script>

<style scoped>

</style>