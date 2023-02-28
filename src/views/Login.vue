<template>
    <div>
        <form>
            <label>
                <input type="text" v-model="username">
                Benutzername oder E-Mail Adresse
            </label>
            <label>
                <input type="password" v-model="password">
                Passwort
            </label>
            <input type="submit" v-on:click="loginUser">
            <span>Einloggen</span>
        </form>
        <p>Noch nicht registiert? Dann bitte <a href="#">hier</a> drücken!</p>
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

            axios.post(`http://localhost/todo-list/php/main.php`, {
                r: "login",
                username: this.username,
                password: this.password,
            }).then(response => {
                if (response.data.status != "false") {
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