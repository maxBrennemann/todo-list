<script >
import { RouterLink, RouterView } from 'vue-router'
import ListOverview from './components/ListOverview.vue'
import { ref } from "vue";

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
  <div class="flex mOuterBg min-h-screen w-full h-full gap-2">
    <div class="grid grid-cols-10 m-10 p-6 rounded-lg shadow-xl maxBoxShadow mInnerBg w-full">
      <list-overview class="col-span-3 p-4 mr-4 rounded-md mMenuBg"></list-overview>
      <main class="col-span-7">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<style scoped>
  /* https://coolors.co/fbf5f3-343633-7d70ba-729b79-b279a7 */
  .maxBoxShadow {
    box-shadow: 5px 5px 57px rgba(0, 0, 0, 0.7) ; 
  	-webkit-box-shadow: 5px 5px 57px rgba(0, 0, 0, 0.7); 
	  -moz-box-shadow: 5px 5px 57px rgba(0, 0, 0, 0.7); 
  }

  .mBoxRight {
    box-shadow: 10px 0 5px -2px #888;
  }

  .mInnerBg {
    background-color: #FBF5F3;
  }

  .mMenuBg {
    background-color: #cfc9c7;
  }

  .mOuterBg {
    background-color: #729B79;
  }
</style>
