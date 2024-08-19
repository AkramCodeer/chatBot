<template>
    <div class="py-4 container-fluid">
        <div class="mt-4 user">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-bottom">
                        <div class="user d-flex align-items-center">
                            <div class="col-6">
                                <h5 class="mb-0 ms-0">Users</h5>
                            </div>
                            <div class="col-6 text-end">
                                <material-button class="float-right btn btm-sm" @click="openAddUserModal">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Add User
                                </material-button>
                            </div>
                        </div>
                    </div>

                    <!-- Card body -->
                    <div class="px-0 pb-0 card-body">
                        <!-- Table -->
                        <table class="table table-flush mt-3">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.created_at }}</td>
                                    <td class="text-end">
                                        <material-button @click="openEditUserModal(user)">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </material-button>
                                        <material-button @click="deleteUser(user.id)">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </material-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MaterialButton from "@/components/MaterialButton.vue";

export default {
    name: "UsersList",
    components: {
        MaterialButton,
    },
    data() {
        return {
            users: [], // List of users
            selectedUser: null // Selected user for editing
        };
    },
    async mounted() {
        await this.loadUsers(); // Load users when component is mounted
    },
    methods: {
        async loadUsers() {
            // Fetch the users from an API or store
            this.users = await this.$store.dispatch('user/getUsers');
        },
        openAddUserModal() {
            // Logic to open a modal for adding a new user
            // Example: this.$emit('openModal', 'addUser');
            console.log("Add User modal opened");
        },
        openEditUserModal(user) {
            // Store the selected user data for editing
            this.selectedUser = user;
            // Logic to open the modal
            // Example: this.$emit('openModal', 'editUser', user);
            console.log("Edit User modal opened for:", user);
        },
        deleteUser(userId) {
            // Logic to delete the user by userId
            this.users = this.users.filter(user => user.id !== userId);
            console.log("User deleted:", userId);
        }
    }
};
</script>

<style scoped>
table thead tr th {
    padding-left: 1.5 rem !important;
}
</style>
