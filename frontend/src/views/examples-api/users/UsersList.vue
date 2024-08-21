<template>
  <div class="container py-4">
    <div class="container-fluid">
    <!-- Profile Header Section -->
    <div
      class="page-header min-height-300 border-radius-xl mt-4"
      :style="{ backgroundImage: `url(${headerImage})` }"
    >
      <span class="mask bg-gradient-success opacity-6"></span>
    </div>

    <!-- Profile Card Section -->
    <div class="card card-body mx-3 mx-md-4 mt-n6">
      <div class="row gx-4">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
            <img
              :src="profileImage"
              alt="profile_image"
              class="shadow-sm w-100 border-radius-lg"
            />
            <input type="file" @change="uploadProfileImage" class="upload-input"/>
          </div>
        </div>
        <div class="col-auto my-auto">
          <div class="h-100">
            <h5 class="mb-1">{{ name }}</h5>
            <p class="mb-0 font-weight-normal text-sm">{{ company }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
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
                  <th>#</th>
                  <th>Company</th>
                  <th>PhoneBot</th>
                  <th>License/User Key</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" :key="user.id">
                  <td>{{ index + 1 }}</td>
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
                  <td class="actions">
                    <button class="btn btn-info" @click="viewUser(user)">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-danger" @click="deleteUser(user.id)">
                      <i class="fas fa-trash-alt"></i>
                    </button>
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
  <button type="button" @click="closeEditUserModal" class="btn-cancel">Cancel</button>
  <button type="submit" @click="closeEditUserModal" class="btn-save">Save Changes</button>
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
  name: "UserManagement",
  data() {
    return {
      // Profile Data
      name: "",
      company: "",
      profileImage: "",
      headerImage: "https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80",
      // User List Data
      users: JSON.parse(localStorage.getItem('users')) || [],
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
    // Profile Methods
    uploadProfileImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.profileImage = URL.createObjectURL(file);
        this.saveToLocalStorage(); // Save profile data to local storage
      }
    },
    saveProfile() {
      const profileData = {
        name: this.name,
        company: this.company,
        profileImage: this.profileImage,
      };
      localStorage.setItem('userProfile', JSON.stringify(profileData));
      alert("Profile updated successfully!");
    },
    loadProfile() {
      const savedProfile = localStorage.getItem('userProfile');
      if (savedProfile) {
        const parsedProfile = JSON.parse(savedProfile);
        this.name = parsedProfile.name || "";
        this.company = parsedProfile.company || "";
        this.profileImage = parsedProfile.profileImage || "";
      }
    },

    // User List Methods
    openAddUserModal() {
      this.showAddUserModal = true;
    },
    closeAddUserModal() {
      this.showAddUserModal = false;
    },
    addUser() {
      if (this.newUser.company && this.newUser.name && this.newUser.licenseKey) {
        const newUser = {
          id: this.users.length + 1,
          ...this.newUser
        };
        this.users.push(newUser);
        this.saveToLocalStorage();
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
        this.saveToLocalStorage();
      }
      this.closeEditUserModal();
    },
    deleteUser(userId) {
      this.users = this.users.filter(user => user.id !== userId);
      this.saveToLocalStorage();
    },
    viewUser(user) {
      this.viewUserDetails = { ...user };
      this.showViewUserModal = true;
    },
    closeViewUserModal() {
      this.showViewUserModal = false;
    },
    saveToLocalStorage() {
      localStorage.setItem('users', JSON.stringify(this.users));
    }
  },
  mounted() {
    this.loadProfile(); // Load profile data from local storage when the component is mounted
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
  border-radius: 8px;
  overflow: hidden;
}

.card-header {
  background-color: #f8f9fa;
  padding: 12px 16px;
}

.card-body {
  padding: 16px;
}

.user-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 16px;
}

.user-table th,
.user-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.user-table th {
  background-color: #f1f1f1;
}

.status-select {
  padding: 4px;
  border-radius: 4px;
  border: 1px solid #ccc;
}

.actions {
  display: flex;
  gap: 10px; /* Equal spacing among action icons */
}

.actions .btn {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8px;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  max-width: 500px;
  width: 100%;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
}

.form-group {
  margin-bottom: 16px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
}

.form-group input,
.form-group select,
.form-group p {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.modal-footer {
  margin-top: 1rem;
  display: flex;
  justify-content: flex-end;
}

.modal-footer button {
  margin-left: 0.5rem;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.25rem;
  cursor: pointer;
  font-size: 1rem;
  font-weight: bold;
}

.btn-save {
  background-color: #007bff;
  color: #fff;
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-save:hover {
  background-color: #0056b3;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.btn-cancel {
  background-color: #6c757d;
  color: #fff;
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-cancel:hover {
  background-color: #5a6268;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.container-fluid {
  padding: 20px;
}
.avatar-xl {
  position: relative;
}
.upload-input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  width: 100%;
  height: 100%;
  cursor: pointer;
}
.card {
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  padding: 20px;
}
</style>
