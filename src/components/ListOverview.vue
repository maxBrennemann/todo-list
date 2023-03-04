<template>
    <div id="sidebar">
        <h2 class="font-semibold">Menü</h2>
        <div class="relative mt-2 text-gray-600 focus-within:text-gray-400">
            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                <button class="focus:outline-none focus:shadow-outline">
                    <svg-icon type="mdi" style="width: 20px; height;: 20px" :path="iconSearch"></svg-icon>
                </button>
            </span>
            <input type="text" class="py-2 pl-10 rounded-md" placeholder="Suche...">
        </div>
        <h3 class="font-medium mt-2">AUFGABEN</h3>
        <a href="#" class="block p-1 cursor-pointer">
            <svg-icon type="mdi" style="width: 15px; height;: 15px" :path="iconToday" class="inline"></svg-icon>
            <span class="inline align-middle ml-1">Heute</span>
        </a>
        <a href="#" class="block p-1 cursor-pointer">
            <svg-icon type="mdi" style="width: 15px; height;: 15px" :path="iconTomorrow" class="inline"></svg-icon>
            <span class="inline align-middle ml-1">Morgen</span>
        </a>
        <a href="#" class="block p-1 cursor-pointer">
            <svg-icon type="mdi" style="width: 15px; height;: 15px" :path="iconMonth" class="inline"></svg-icon>
            <span class="inline align-middle ml-1">Kalender</span>
        </a>
        <a href="#" class="block p-1 cursor-pointer">
            <svg-icon type="mdi" style="width: 15px; height;: 15px" :path="iconPin" class="inline"></svg-icon>
            <span class="inline align-middle ml-1">Angepinnt</span>
        </a>
        <h3 class="font-medium mt-2">LISTEN</h3>
        <a href="#" v-if="lists.length == 0">Keine Listen vorhanden!</a>
        <router-link :to="'/lists/' + listElement.id" v-else v-for="listElement in lists" class="block p-1 cursor-pointer" v-bind:id="listElement.id">
            <svg-icon type="mdi" style="width: 15px; height;: 15px" :path="iconList" class="inline"></svg-icon>
            <span class="inline align-middle ml-1">{{ listElement.title }}</span>
        </router-link>
        <input type="text" class="hidden" v-model="listTitle">
        <button v-on:click="addList" class="p-1 cursor-pointer">
            <svg-icon type="mdi" style="width: 15px; height: 15px" :path="iconAdd" class="inline"></svg-icon>
            <span class="inline align-middle ml-1">Neue Liste hinzufügen</span>
        </button>
    </div>
</template>

<script>
import axios from 'axios';
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiMagnify, mdiPlusThick, mdiCalendarTodayOutline, mdiCalendarOutline, mdiCalendarMonthOutline, mdiPin, mdiFormatListBulleted } from '@mdi/js';

export default {
    name: "ListOverview",
    components: {
        SvgIcon,
    },
    data() {
        return {
            lists: [],
            listTitle: "",

            iconSearch: mdiMagnify,
            iconAdd: mdiPlusThick,
            iconToday: mdiCalendarTodayOutline,
            iconTomorrow: mdiCalendarOutline,
            iconMonth: mdiCalendarMonthOutline,
            iconPin: mdiPin,
            iconList: mdiFormatListBulleted,
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