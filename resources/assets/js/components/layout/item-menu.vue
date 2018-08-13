<template>
    <li class="list-group-item">
        <span :class="icon"></span>
        <a :href="route">{{ mensaje }}</a>
    </li>
</template>

<script>
    export default {
        props: {
            route: {
                type: String,
                default: ''
            },
            icon:{
                type: String,
                default: ''
            },
            mensaje:{
                type: String,
                default: ''
            }
        },
    }
</script>

<style scoped>

</style>