<template>
    <div class="container py-4">
        <div class="mt-4 user">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>PhoneBot Users</h5>
                            <button class="btn btn-primary" @click="openAddUserModal">Add User</button>
                        </div>
                    </div>

                    <!-- Card body -->
                    <div class="card-body">
                        <!-- Table -->
                        <table class="user-table">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>PhoneBot</th>
                                    <th>License/User Key</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.company }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.licenseKey }}</td>
                                    <td>
                                        <select v-model="user.status" class="status-select">
                                            <option value="running">Running</option>
                                            <option value="connected">Connected</option>
                                            <option value="paused">Paused</option>
                                            <option value="stopped">Stopped</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-info" @click="viewUser(user)">View</button>
                                        <button class="btn btn-secondary" @click="openEditUserModal(user)">Edit</button>
                                        <button class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add User Modal -->
        <div v-if="showAddUserModal" class="modal-overlay" @click="closeAddUserModal">
            <div class="modal-content" @click.stop>
                <h3>Add User</h3>
                <form @submit.prevent="addUser">
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" v-model="newUser.company" id="company" required />
                    </div>
                    <div class="form-group">
                        <label for="name">PhoneBot Name</label>
                        <input type="text" v-model="newUser.name" id="name" required />
                    </div>
                    <div class="form-group">
                        <label for="licenseKey">License/User Key</label>
                        <input type="text" v-model="newUser.licenseKey" id="licenseKey" required />
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select v-model="newUser.status" id="status" required>
                            <option value="running">Running</option>
                            <option value="connected">Connected</option>
                            <option value="paused">Paused</option>
                            <option value="stopped">Stopped</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="closeAddUserModal">Cancel</button>
                        <button type="submit">Add User</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div v-if="showEditUserModal" class="modal-overlay" @click="closeEditUserModal">
            <div class="modal-content" @click.stop>
                <h3>Edit User</h3>
                <form @submit.prevent="updateUser">
                    <div class="form-group">
                        <label for="editCompany">Company</label>
                        <input type="text" v-model="editUser.company" id="editCompany" required />
                    </div>
                    <div class="form-group">
                        <label for="editName">PhoneBot Name</label>
                        <input type="text" v-model="editUser.name" id="editName" required />
                    </div>
                    <div class="form-group">
                        <label for="editLicenseKey">License/User Key</label>
                        <input type="text" v-model="editUser.licenseKey" id="editLicenseKey" required />
                    </div>
                    <div class="form-group">
                        <label for="editStatus">Status</label>
                        <select v-model="editUser.status" id="editStatus" required>
                            <option value="running">Running</option>
                            <option value="connected">Connected</option>
                            <option value="paused">Paused</option>
                            <option value="stopped">Stopped</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="closeEditUserModal">Cancel</button>
                        <button type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- View User Modal -->
        <div v-if="showViewUserModal" class="modal-overlay" @click="closeViewUserModal">
            <div class="modal-content" @click.stop>
                <h3>View User Details</h3>
                <div class="form-group">
                    <label>Company</label>
                    <p>{{ viewUserDetails.company }}</p>
                </div>
                <div class="form-group">
                    <label>PhoneBot Name</label>
                    <p>{{ viewUserDetails.name }}</p>
                </div>
                <div class="form-group">
                    <label>License/User Key</label>
                    <p>{{ viewUserDetails.licenseKey }}</p>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <p>{{ viewUserDetails.status }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="closeViewUserModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PhoneBotUsersList",
    data() {
        return {
            users: [
                { id: 1, company: 'Acme Corp', name: 'Bot A', licenseKey: 'ABC123', status: 'running' },
                { id: 2, company: 'Beta LLC', name: 'Bot B', licenseKey: 'DEF456', status: 'connected' },
                { id: 3, company: 'Gamma Inc', name: 'Bot C', licenseKey: 'GHI789', status: 'paused' }
            ],
            showAddUserModal: false,
            showEditUserModal: false,
            showViewUserModal: false,
            newUser: {
                company: '',
                name: '',
                licenseKey: '',
                status: 'running'
            },
            editUser: {
                id: null,
                company: '',
                name: '',
                licenseKey: '',
                status: ''
            },
            viewUserDetails: {}
        };
    },
    methods: {
        openAddUserModal() {
            this.showAddUserModal = true;
        },
        closeAddUserModal() {
            this.showAddUserModal = false;
        },
        addUser() {
            if (this.newUser.company && this.newUser.name && this.newUser.licenseKey) {
                this.users.push({
                    id: this.users.length + 1, // Simple id increment for demo
                    ...this.newUser
                });
                this.newUser = { company: '', name: '', licenseKey: '', status: 'running' };
                this.closeAddUserModal();
            }
        },
        openEditUserModal(user) {
            this.editUser = { ...user };
            this.showEditUserModal = true;
        },
        closeEditUserModal() {
            this.showEditUserModal = false;
        },
        updateUser() {
            const index = this.users.findIndex(user => user.id === this.editUser.id);
            if (index !== -1) {
                this.$set(this.users, index, { ...this.editUser });
            }
            this.closeEditUserModal();
        },
        deleteUser(userId) {
            this.users = this.users.filter(user => user.id !== userId);
            console.log("User deleted:", userId);
        },
        viewUser(user) {
            this.viewUserDetails = { ...user };
            this.showViewUserModal = true;
        },
        closeViewUserModal() {
            this.showViewUserModal = false;
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 1200px;
    margin: auto;
}

.card {
    border: 1px solid #ddd;
    border-radius: 0.25rem;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #f8f9fa;
    padding: 1rem;
    border-bottom: 1px solid #ddd;
}

.user-table {
    width: 100%;
    border-collapse: collapse;
}

.user-table th, .user-table td {
    padding: 0.75rem;
    border: 1px solid #ddd;
    text-align: left;
}

.user-table th {
    background-color: #f8f9fa;
}

.user-table tbody tr:hover {
    background-color: #f1f1f1;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: #fff;
    padding: 2rem;
    border-radius: 0.25rem;
    width: 400px;
}

.modal-footer {
    margin-top: 1rem;
    display: flex;
    justify-content: flex-end;
}

.modal-footer button {
    margin-left: 0.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
}

.form-group input, .form-group select {
    width: 100%;
    padding: 0.375rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.status-select {
    width: 100%;
}
</style>
