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
            <label>
                <input type="password" v-model="passwordRepeated">
                Passwort wiederholen
            </label>
        </form>
        <button v-on:click="registerUser">Registrieren</button>
        <button>Mit Google registrieren</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Login",
    data() {
        return {
            username: "",
            password: "",
            passwordRepeated: "",
        }
    },
    methods: {
        registerUser(e) {
            e.preventDefault();

            if (this.password != this.passwordRepeated)
                return;

            axios.post(`/php-backend/main.php`, {
                r: "register",
                username: this.username,
                password: this.password,
            }).then(response => {
                if (response.data.status != "false") {
                    console.log(response.data);
                } else {
                    console.log("Die E-Mail Adresse existiert schon!");
                    this.$router.push("Login");
                }
            });
        }
    },
}
</script>

<style>

</style>