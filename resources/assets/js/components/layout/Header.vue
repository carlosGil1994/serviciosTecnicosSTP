<template>
    <div class="container-fluid">
        <hr>
        <div class="row">
            <slot name="options">

            </slot>
            <div class="col-2">
                <form v-on:submit.prevent="logout">
                    <button class="btn btn-danger">
                        Cerrar Sesion
                    </button>
                </form>
            </div>
            <slot name="sesion">

            </slot>
        </div>
        <hr>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        methods: {
            logout () {
                var urlLogout = 'logout'
                axios.post(urlLogout).then(function(response){
                    location.href="http://127.0.0.1:8080/"
                })
            }
        },
    }
</script>

<style scoped>

</style>