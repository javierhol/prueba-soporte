import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios'; // Asegúrate de tener axios instalado

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        tasks: [],
        filter: null // Estado inicial para las tareas
    },
    mutations: {
        SET_TASK(state, tasks) {
            state.tasks = tasks;
        },

        ADD_TASK(state, task) {
            state.tasks.push(task);
        },

        UPDATE_TASK(state, updatedTask) {
            const index = state.tasks.findIndex(t => t.id === updatedTask.id);
            if (index !== -1) {
                Vue.set(state.tasks, index, updatedTask);
            }
        },

        DELETE_TASK(state, taskId) {
            state.tasks = state.tasks.filter(task => task.id !== taskId);
        },
    },
    actions: {
        fetchTasks({ commit }) {
            axios.get('/tasks/all')
                .then(response => {
                    commit('SET_TASK', response.data);
                })
                .catch(error => {
                    console.error("Error getting All task", error);
                })
        },
        filterTask({ commit }, filter) {
            axios.get('/tasks/filter', { params: { completed: filter } })
                .then(response => {
                    commit('SET_TASK', response.data);
                })
                .catch(error => {
                    console.error("Error filtering task", error);
                })
        },
        addTask({ commit }, task) {
            axios.post('/tasks', task)
                .then(response => {
                    commit('ADD_TASK', response.data.task);
                })
                .catch(error => {
                    console.error("Error adding task:", error);
                });
        },
        updateTask({ commit }, task) {
            axios.put(`/tasks/${task.id}`, task)
                .then(response => {
                    commit('UPDATE_TASK', response.data);
                })
                .catch(error => {
                    console.error("Error updating task:", error);
                });
        },
        deleteTask({ commit }, taskId) {
            return axios.delete(`/tasks/${taskId}`)
                .then(response => {
                    commit('DELETE_TASK', taskId);
                }).catch(error => {
                    console.error('Error deleting task:', error)
                })
        },


    },
    getters: {
        tasks: state => state.task
    }
});
