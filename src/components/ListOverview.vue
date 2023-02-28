<template>
    <div id="sidebar" class="fixed top-0 bottom-0 w-64">
        <a href="#" v-if="lists.length == 0">Keine Listen vorhanden!</a>
        <a href="#" v-else v-for="listElement in lists" class="block" v-bind:id="listElement.id">{{ listElement.title }}</a>
        <input type="text" v-model="listTitle">
        <button v-on:click="addList">Neue Liste hinzufügen</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "ListOverview",
    data() {
        return {
            lists: [],
            listTitle: "",
        }
    },
    mounted() {
      this.getLists();
    },
    methods: {
        getLists() {
            axios.get(`http://localhost/todo-list/php/main.php?r=listOverview&user=${this.getUserId()}`).then(response => {
                this.lists = response.data;
                console.log(this.lists);
            });
        },
        getUserId() {
            return 1; // TODO: remove hardcoded id
        },
        addList() {
            if (this.listTitle != "") {
                axios.post(`http://localhost/todo-list/php/main.php`, {
                    r: "addList",
                    title: this.listTitle,
                    idUser: this.idUser,
                }).then(response => {
                    if (response.data.status) {
                        this.lists.push({
                            id: response.data.id,
                            title: this.listTitle
                        });
                        this.listTitle = "";
                    }
                });
            }
        }
    },
}
</script>

<style>

</style>