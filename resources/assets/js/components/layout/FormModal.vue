<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                <div class="modal-header">
                    <slot name="header">
                        default header
                    </slot>
                </div>

                <div class="modal-body">
                    <form enctype="multipart/form-data" name="name_form" id="id_form" @submit.prevent="ModalCreated" :action="route" :method="method">
                            <slot name="body">
                            
                            </slot>
                        <button class="btn btn-primary">{{ button }}</button>
                    </form>

                    <div id="get-content">

                    </div>
                </div>
                
                <div class="modal-footer">
                    <slot name="footer">
                        default footer
                        <button class="btn btn-primary" @click="$emit('close')">
                            OK
                        </button>
                    </slot>
                </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import axios from 'axios';
var serialize = require('form-serialize');
    export default {
        data() {
            return {
                inputs: [],
                input2: '',
                array: []
            }
        },
        props: {
            route: {
                type: String,
                default: ''
            },
            method:{
                type: String,
                default: 'GET'
            },
            button:{
                type: String,
                default: 'Ok'
            }
        },
        methods: {
            ModalCreated: function() {
                var URL = this.route;
                var form = document.getElementById('id_form');
                var ob = {};
                var elements = form.querySelectorAll( "input, select, textarea" );

                for( var i = 0; i < elements.length; ++i ) {
                    var element = elements[i];
                    var name = element.name;
                    var value = element.value;

                    if( name ) {
                        ob[ name ] = value;
                    }
                }
                
                if(this.method == 'POST'){
                    axios.post(URL,ob).then(response =>{
                        // location.reload();
                    })
                }
                else if(this.method=='GET'){
                    axios.get(URL).then(response=>{
                        var div_get = document.getElementById('get-content');
                        div_get.innerHTML += response.data;
                    })
                }
            }
        },
    }
</script>

<style scoped>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 800px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }

    .modal-default-button {
        float: right;
    }

    /*
    * The following styles are auto-applied to elements with
    * transition="modal" when their visibility is toggled
    * by Vue.js.
    *
    * You can easily play with the modal transition by editing
    * these styles.
    */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
    img{
       width: 300px;
       height: 200px; 
    }
</style>