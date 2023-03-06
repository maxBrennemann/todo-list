import { createStore } from 'vuex'

const toDoStore = createStore({
    state() {
        return {
            lists: {},
            isLoggedIn: false,
            token: "",
        }
    },
    getters: {
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        getToken(state) {
            return state.token;
        },
    },
    mutations: {
        addToDo(state, list, title, content) {
            if (state.lists[list]) {
                state.lists[list].push({'title': title, 'content': content});
            }
        },
        removeToDo() {
            
        },
        setLogin(state, token) {
            state.isLoggedIn = true;
            state.token = token;
        }
    }
});

export default toDoStore;