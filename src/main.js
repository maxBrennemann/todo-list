import { createApp } from 'vue'

import App from './App.vue'
import router from './router/router.js'
import './assets/main.css'

import toDoStore from './store/toDoStore'

import axios from 'axios';

axios.interceptors.request.use((config) => {
    config.headers['Content-Type'] = 'application/json';
    config.data = {...config.data, token: localStorage.getItem("token")}
    return config;
});

window.axios = axios;

const app = createApp(App)
app.use(router).use(toDoStore)
app.mount('#app')
