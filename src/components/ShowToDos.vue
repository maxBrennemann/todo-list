<template>
    <div>
        <div v-for="toDo in toDos" class="m-2 bg-emerald-400" v-on:drop="handleFiles($event, toDo.id)" v-on:dragover="handleDragover($event, toDo.id)" v-on:mouseenter="hoverItem = toDo.id" v-on:mouseleave="hoverItem = 0">
            <input type="checkbox" class="inline-block" @click="checkToDo($event, toDo)">
            <input type="text" v-bind:value="toDo.title" class="inline-block text-xl p-2 bg-emerald-400 font-serif" v-on:change="changeTitle($event, toDo.id)">
            <textarea class="text-sm mt-2 w-5/6 p-2 bg-emerald-400 font-sans" v-on:change="changeDescription($event, toDo.id)">{{ toDo.content }}</textarea>
            <button v-if="hoverItem == toDo.id" v-on:change="deleteToDo($event, toDo.id)">Löschen</button>
        </div>
        <div>
            <img v-for="image in images" :src="image.src" :alt="image.alt">
        </div>
        <input type="text" v-model="newTitle">
        <textarea v-model="newContent"></textarea>
        <button v-on:click="addToDo">Hinzufügen</button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Lists",
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
            uploadableFiles: [],
            images: [],
            hoverItem: 0,
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
        handleFiles(e, id) {
            e.preventDefault();
            if (e.dataTransfer.items) {
                [...e.dataTransfer.items].forEach(async (item) => {
                    if (item.kind === 'file' && item.type.match('image.*')) {
                        const file = item.getAsFile();
                        const result = await this.readFile(file);

                        const fileData = {
                            src: result,
                            alt: "Hochgeladene Datei",
                        };
                        this.images.push(fileData);  
                        this.uploadableFiles.push(file);
                    }
                });
            }
        },
        readFile(file) {
            return new Promise((resolve, reject) => {
                var fr = new FileReader();
                fr.onload = () => {
                    resolve(fr.result);
                };
                fr.onerror = reject;
                fr.readAsDataURL(file);
            });
        },
        handleDragover(event, id) {
            event.preventDefault();
        },
        deleteToDo(event, id) {

        }
    },
}
</script>

<style>

</style>