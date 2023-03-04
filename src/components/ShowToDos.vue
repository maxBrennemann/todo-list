<template>
    <div>
        <h1 class="text-3xl font-medium mb-5">{{ pageTitle }}</h1>
        <div class="border-2 rounded-md p-2 pl-4 border-gray-300">
            <input type="text" v-model="newTitle" class="hidden">
            <textarea v-model="newContent" class="hidden"></textarea>
            <button v-on:click="addToDo">
                <svg-icon type="mdi" style="width: 15px; height: 15px" :path="iconAdd" class="inline"></svg-icon>
                <span class="inline align-middle ml-1">Neue Aufgabe hinzufügen</span>
            </button>
        </div>
        <div v-for="toDo in toDos" class="border-b-2 m-2 p-2 pl-4 border-gray-300" v-on:drop="handleFiles($event, toDo.id)" v-on:dragover="handleDragover($event, toDo.id)" v-on:mouseenter="hoverItem = toDo.id" v-on:mouseleave="hoverItem = 0">
            <input type="checkbox" class="inline-block" @click="checkToDo($event, toDo)">
            <input type="text" v-bind:value="toDo.title" class="inline-block text-xl p-2 pl-4 pb-0 font-serif bg-inherit focus:outline-none" v-on:change="changeTitle($event, toDo.id)">
            <textarea v-if="toDo.content" class="text-sm w-5/6 p-2 pt-0 font-sans bg-inherit ml-4 resize-none focus:outline-none"  rows="1" style="font-size: 0.75em;" v-on:change="changeDescription($event, toDo.id)">{{ toDo.content }}</textarea>
            <button v-if="hoverItem == toDo.id" v-on:change="deleteToDo($event, toDo.id)">Löschen</button>
        </div>
        <div>
            <img v-for="image in images" :src="image.src" :alt="image.alt">
        </div>
    </div>
</template>

<script>
import axios from "axios";
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiPlusThick } from '@mdi/js';

export default {
    name: "Lists",
    components: {
        SvgIcon
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
            uploadableFiles: [],
            images: [],
            hoverItem: 0,
            pageTitle: "Meine Aufgaben",

            iconAdd: mdiPlusThick,
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