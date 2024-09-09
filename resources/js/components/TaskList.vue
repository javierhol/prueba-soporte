<template>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Task List</h1>
        <div class="mb-3">
            <p class="mb-1" style="font-size: 21px">Filters:</p>
            <button
                class="btn-success btn-sm"
                @click="filterTask(1)"
                type="button"
            >
                Complete
            </button>
            <!--  click.prevnt para prevenir el comportamiento default y que el formulario lo tome como un submit -->
            <button
                class="btn-danger btn-sm"
                @click.prevent="filterTask(0)"
                type="button"
            >
                Incomplete
            </button>
            <button
                class="btn-primary btn-sm"
                @click.prevent="fetchTask()"
                type="button"
            >
                All
            </button>
        </div>
        <ul class="list-group mb-4">
            <li
                v-for="task in tasks"
                :key="task.id"
                class="list-group-item d-flex justify-content-between align-items-center"
            >
                <div>
                    <h5 class="mb-1">{{ task.title }}</h5>
                    <p class="mb-1">{{ task.description }}</p>
                    <small class="text-muted"
                        >Assigned to: {{ task.user.email }}</small
                    >
                </div>
                <div>
                    <button
                        v-if="!task.completed"
                        class="btn btn-success btn-sm"
                        @click.prevent="completeTask(task)"
                    >
                        Complete
                    </button>
                    <!--  click.prevnt para prevenir el comportamiento default y que el formulario lo tome como un submit -->
                    <button
                        class="btn btn-danger btn-sm"
                        @click.prevent="deleteTask(task.id)"
                        type="button"
                    >
                        Delete
                    </button>
                </div>
            </li>
        </ul>
        <form @submit.prevent="addTask" class="card card-body">
            <div class="form-group">
                <input
                    v-model="newTask.title"
                    class="form-control"
                    maxlength="255"
                    type="text"
                    placeholder="Task Title"
                    required
                />
            </div>
            <div class="form-group">
                <input
                    v-model="newTask.description"
                    class="form-control"
                    maxlength="500"
                    type="text"
                    placeholder="Task Description"
                    required
                />
            </div>
            <div class="form-group">
                <input
                    v-model="newTask.user"
                    class="form-control"
                    maxlength="500"
                    type="email"
                    placeholder="Assigned User"
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                Add Task
            </button>
        </form>
    </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
    data() {
        return {
            newTask: {
                title: "",
                description: "",
                user: "",
            },
        };
    },
    computed: {
        ...mapState(["tasks"]), // Simplificado para mapState
    },
    methods: {
        ...mapActions(["addTask", "updateTask", "deleteTask", "filterTask"]),
        addTask() {
            if (
                !this.newTask.title ||
                !this.newTask.description ||
                !this.newTask.user
            ) {
                alert("Both title and description are required");
                return;
            }
            // Se utiliza la acción 'addTask' y luego se limpia el formulario
            this.$store
                .dispatch("addTask", this.newTask)
                .then(() => {
                    this.newTask.title = "";
                    this.newTask.description = "";
                    this.newTask.user = "";
                    this.$store.dispatch("fetchTasks");
                })
                .catch((error) => {
                    console.error("Error adding task:", error);
                });
        },

        completeTask(task) {
            // Se utiliza la acción 'completeTask'
            this.$store
                .dispatch("updateTask", task)
                .then(() => this.$store.dispatch("fetchTasks"))
                .catch((error) => {
                    console.error("Error completing task:", error);
                });
        },

        deleteTask(taskId) {
            // Se utiliza la acción 'deleteTask'
            this.$store
                .dispatch("deleteTask", taskId)
                .then(() => this.$store.dispatch("fetchTasks"))
                .catch((error) => {
                    console.error("Error deleting task:", error);
                });
        },
        filterTask(filter) {
            this.$store.dispatch("filterTask", filter);
        },
        fetchTask() {
            this.$store.dispatch("fetchTasks");
        },
    },
    mounted() {
        // se utiliza la accion fecthTask para obtener las tareas al montar la aplicacion
        this.$store.dispatch("fetchTasks");
    },
};
</script>
