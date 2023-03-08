<template>
    <div>
        <form>
            <label class="block">
                <input type="text" v-model="username">
                <span>Benutzername oder E-Mail Adresse</span>
            </label>
            <label class="block">
                <input type="password" v-model="password">
                <span>Passwort</span>
            </label>
            <input type="submit" v-on:click="loginUser">
            <span>Einloggen</span>
        </form>
        <p>Noch nicht registiert? Dann bitte  <router-link to="/register">hier</router-link> drücken!</p>
    </div>
</template>

<script>
import { mapMutations } from 'vuex';

export default {
    name: "Login",
    components: {

    },
    computed: {

    },
    data() {
        return {
            username: "",
            password: "",
        }
    },
    watch: {
        
    },
    methods: {
        loginUser(e) {
            e.preventDefault();

            if (this.username == "" || this.password == "")
                return;

            axios.post(`/php-backend/main.php`, {
                r: "login",
                username: this.username,
                password: this.password,
            }).then(response => {
                if (response.data.status != "false") {
                    localStorage.setItem("token", response.data.token);
                    this.$store.commit('setLogin', {token: response.data.token});
                    this.$router.push("overview");
                }
            });
        },
        ...mapMutations([
            'setLogin'
        ]),
    },
}
</script>

<style>

</style>