<template>
    <div id="sidebar" class="fixed top-0 bottom-0 w-64">
        <a href="#" v-if="lists.length == 0">Keine Listen vorhanden!</a>
        <a href="#" v-else v-for="listElement in lists" class="block">{{ listElement }}</a>
    </div>
</template>

<script>
export default {
    name: "ListOverview",
    data() {
        return {
            lists: [],
        }
    },
    mounted() {
      this.getLists();
    },
    methods: {
        getLists() {
            axios.get(`http://localhost/todo-list/php/main.php?r=listOverview&user=${this.getUserId()}`).then(response => {
                this.lists = response.data;
            });
        },
        getUserId() {
            return 1;
        }
    },
}
</script>

<style>

</style>