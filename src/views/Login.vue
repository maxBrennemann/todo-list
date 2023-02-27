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
export default {
    name: "Login",
    components: {

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
            // TODO: an server senden
        }
    },
}
</script>

<style>

</style>