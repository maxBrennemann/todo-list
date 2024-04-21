<template>
    <show-to-dos></show-to-dos>
</template>

<script>
import ShowToDos from "../components/ShowToDos.vue";

export default {
    name: "Lists",
    components: {
        ShowToDos,
    },
    data() {
        return {
            currentList: 0,
        }
    },
    watch: {
        
    },
    methods: {

    },
}
</script>

<style>

</style>