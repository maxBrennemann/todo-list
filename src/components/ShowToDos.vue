<template>
    <div>
        <div v-for="toDo in toDos" class="m-2 bg-emerald-400" v-on:drop="handleFiles($event, toDo.id)">
            <input type="text" v-bind:value="toDo.title" class="w-full text-xl p-2 bg-emerald-400" v-on:change="changeTitle($event, toDo.id)">
            <textarea class="text-sm mt-2 w-5/6 p-2 bg-emerald-400" v-on:change="changeDescription($event, toDo.id)">{{ toDo.content }}</textarea>
            <edit-to-do></edit-to-do>
            <delete-to-do></delete-to-do>
        </div>
        <input type="text" v-model="newTitle">
        <textarea v-model="newContent"></textarea>
        <button v-on:click="addToDo">Hinzufügen</button>
    </div>
</template>

<script>
import EditToDo from "../components/EditToDo.vue";
import DeleteToDo from "../components/DeleteToDo.vue";
import axios from "axios";

export default {
    name: "Lists",
    components: {
        EditToDo,
        DeleteToDo,
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
            newTitle: "",
            newContent: "",
            listId: 0,
        }
    },
    watch: {
        $route(to, from) {
            this.listId = this.$route.params.listId;
            this.load();
            console.log(this.listId);
        }
    },
    mounted() {
        this.load();
    },
    methods: {
        load() {
            axios.get(`http://localhost/todo-list/php/main.php?r=getList&listId=${this.listId}`).then(response => {
                this.toDos = response.data;
            });
        },
        changeTitle(event, id) {
            if (event.target.value !== "") {
                const title = event.target.value;
                axios.post(`http://localhost/todo-list/php/main.php`, {
                    r: "editTitle",
                    listItemId: id,
                    listId: this.listId,
                    title: title,
                });
            }
        },
        changeDescription(event, id) {
            const description = event.target.value;
            axios.post(`http://localhost/todo-list/php/main.php`, {
                r: "editDescription",
                listItemId: id,
                listId: this.listId,
                description: description, 
            });
        },
        addToDo() {
            if (this.newText !== "") {
                axios.post(`http://localhost/todo-list/php/main.php`, {
                    r: "addToDo",
                    listId: this.listId,
                    title: this.newTitle,
                    content: this.newContent,
                }).then(response => {
                    let id = response.data.id;
                    this.toDos.push({
                        id: id,
                        title: this.newTitle,
                        content: this.newContent,
                    });
                });
            }
        },
        handleFiles(event, id) {

        }
    },
}
</script>

<style>

</style>