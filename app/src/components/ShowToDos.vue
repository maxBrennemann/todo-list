<template>
    <div>
        <h1 class="text-3xl font-medium mb-5">Meine Aufgaben in: <input type="text" v-model="pageTitle" class="bg-inherit focus:outline-none w-2/3 underline underline-offset-2" ref="editTitle" v-on:change="editListTitle"></h1>
        <div class="border-2 rounded-md p-2 pl-4 border-gray-300">
            <input type="text" v-model="newTitle" class="hidden">
            <textarea v-model="newContent" class="hidden"></textarea>
            <button v-on:click="addToDo">
                <svg-icon type="mdi" style="width: 15px; height: 15px" :path="iconAdd" class="inline"></svg-icon>
                <span class="inline align-middle ml-1">Neue Aufgabe hinzufügen</span>
            </button>
        </div>
        <div class="p-2 pl-4 pt-4">
            <span class="inline">Sortieren nach:</span>
            <select class="inline ml-2">
                <option v-bind:on-click="sortBy('default')" selected>Standard</option>
                <option v-bind:on-click="sortBy('date')">Datum</option>
                <option v-bind:on-click="sortBy('priority')">Priorität</option>
            </select>
        </div>
        <div v-for="toDo in toDos" class="border-b-2 m-2 p-2 pl-4 border-gray-300 hoverParentItem" v-on:drop="handleFiles($event, toDo.id)" v-on:dragover="handleDragover($event, toDo.id)">
            <input type="checkbox" class="inline-block" @click="checkToDo($event, toDo.id)" :checked="toDo.state == 'done'">
            <input type="text" v-bind:value="toDo.title" class="inline-block text-xl p-2 pl-4 pb-0 font-serif bg-inherit focus:outline-none w-5/6" v-bind:class="{ 'line-through': toDo.state == 'done' }" v-on:change="changeTitle($event, toDo.id)">
            <textarea v-if="toDo.content" class="text-sm w-5/6 p-2 pt-0 font-sans bg-inherit ml-4 resize-none focus:outline-none"  rows="1" style="font-size: 0.75em;" v-on:change="changeDescription($event, toDo.id)">{{ toDo.content }}</textarea>
            <button class="hoverHidden hoverShow" v-on:click="deleteToDo(toDo.id)">
                <svg-icon type="mdi" style="width: 18px; height: 18px" :path="iconDelete" class="inline mDeleteCol"></svg-icon>
            </button>
        </div>
        <div>
            <img v-for="image in images" :src="image.src" :alt="image.alt">
        </div>
    </div>
</template>

<script>
import axios from "axios";
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiPlusThick, mdiDelete } from '@mdi/js';

export default {
    name: "Lists",
    components: {
        SvgIcon
    },
    data() {
        return {
            toDos: [],

            newTitle: "",
            newContent: "",

            listId: this.$route.params.listId,

            uploadableFiles: [],
            images: [],
            
            hoverItem: 0,
            pageTitle: "Meine Aufgaben",

            iconAdd: mdiPlusThick,
            iconDelete: mdiDelete,
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
            axios.get(`/php-backend/main.php?r=getList&listId=${this.listId}`).then(response => {
                this.toDos = response.data.todos;
                this.pageTitle = response.data.name;
            });
        },
        changeTitle(event, id) {
            if (event.target.value !== "") {
                const title = event.target.value;
                axios.post(`/php-backend/main.php`, {
                    r: "editTitle",
                    listItemId: id,
                    listId: this.listId,
                    title: title,
                });
            }
        },
        changeDescription(event, id) {
            const description = event.target.value;
            axios.post(`/php-backend/main.php`, {
                r: "editDescription",
                listItemId: id,
                listId: this.listId,
                description: description,
            });
        },
        addToDo() {
            if (this.newText !== "") {
                axios.post(`/php-backend/main.php`, {
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
        deleteToDo(id) {
            axios.post(`/php-backend/main.php`, {
                r: "deleteToDo",
                listItemId: id,
                listId: this.listId,
            }).then(response => {
                if (response.data.status == "success") {
                    this.toDos.filter(item => item.id !== id);
                }
            });
        },
        checkToDo(e, id) {
            console.log(this.toDos);
            this.toDos.forEach(element => {
                if (element.id == id) {
                    if (element.state == "active") {
                        element.state = "done";
                    } else {
                        element.state = "active";
                    }

                    axios.post(`/php-backend/main.php`, {
                        r: "changeStatus",
                        listItemId: id,
                        checked: element.state,
                    });
                }
            });
        },
        editListTitle() {
            const newTitle = this.$refs.editTitle.value;
            axios.post(`/php-backend/main.php`, {
                r: "editListTitle",
                listId: this.listId,
                title: newTitle,
            });
        },
        sortBy(sortDirection) {

        },
    },
}
</script>

<style>
    .mDeleteCol {
        color: #ED6F89;
    }

    .hoverHidden {
        visibility: hidden;
    }

    .hoverParentItem:hover .hoverShow {
        visibility: visible;
    }
</style>