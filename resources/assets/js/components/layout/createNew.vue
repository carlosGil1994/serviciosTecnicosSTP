<template>
    <div class="card bg-primary">
        <div class="card-header">
            <button class="btn" @click="showForm = true">+</button>
        </div>
        <div v-show="showForm" class="card-body">
            <form @submit.prevent="createRow" id="formulario">
                <slot name="inputs">

                </slot>

                <button class="btn btn-info">Agregar</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
var serialize = require('form-serialize')
    export default {
        data() {
            return {
                showForm: false
            }
        },
        props: {
            route: {
                type: String,
                required: true 
            },
        },
        methods: {
            createRow() {
                var URL = this.route;
                var form = document.querySelector('#formulario');
                var obj = serialize(form, {hash:true});
                axios.post(URL, obj).then(res=>{
                    console.log('retorne bien');
                    this.showForm = false;
                })
            }
        },
    }
</script>

<style scoped>

</style>