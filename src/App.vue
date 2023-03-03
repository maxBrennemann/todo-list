<script >
import { RouterLink, RouterView } from 'vue-router'
import ListOverview from './components/ListOverview.vue'

export default {
    name: "App",
    components: {
      ListOverview,
    },
    data() {
        return {
            lists: ["test", "test2"],
        }
    },
    watch: {
        
    },
    methods: {
      
    },
}
</script>

<template>
  <div>
    <main class="sm:ml-64 bg-gradient-to-r from-cyan-500 to-cyan-100 h-screen">
      <header>
        <h2>Lege deine ToDo-Listen an!</h2>
      </header>
      <router-view class=""></router-view>
    </main>
    <list-overview></list-overview>
  </div>
</template>

<style scoped>

</style>
