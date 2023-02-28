<template>
    <div>
        <div v-for="toDo in toDos" class="m-2 bg-emerald-400">
            <input type="text" v-bind:value="toDo.title" class="w-full text-xl p-2 bg-emerald-400">
            <textarea class="text-sm mt-2 w-5/6 p-2 bg-emerald-400">{{ toDo.content }}</textarea>
            <edit-to-do></edit-to-do>
            <delete-to-do></delete-to-do>
        </div>
        <add-to-do></add-to-do>
    </div>
</template>

<script>
import EditToDo from "../components/EditToDo.vue";
import DeleteToDo from "../components/DeleteToDo.vue";
import AddToDo from "../components/AddToDo.vue";

export default {
    name: "Lists",
    components: {
        EditToDo,
        DeleteToDo,
        AddToDo,
    },
    data() {
        return {
            toDos: [
                {
                    id: 0,
                    title: "tollesToDo",
                    content: "toller Inhalt",
                },
                {
                    id: 5,
                    title: "gute titel",
                    content: "toller noch besserer Inhalt",
                }
            ],
        }
    },
    watch: {
        
    },
    methods: {
        setTitle() {

        },
        setContent() {

        }
    },
}
</script>

<style>

</style>