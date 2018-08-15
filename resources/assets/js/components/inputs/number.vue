<template>
    <div class="form-group">
        <label :for="forComputed">{{ etiquetaComputed }}</label>
        <input type="number" :class="clases+' form-control'" :id="idComputed" :name="name">
    </div>
</template>

<script>
    export default {
        props: {
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