<template>
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

      <!-- Basic Info Form Section -->
      <div class="row mt-3">
        <div class="col-md-12">
          <form @submit.prevent="saveProfile">
            <h6 class="text-uppercase text-body font-weight-bolder">Basic Info</h6>

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" v-model="name" id="name" class="form-control" required/>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" v-model="email" id="email" class="form-control" required/>
            </div>

            <div class="form-group">
              <label for="company">Company Name</label>
              <input type="text" v-model="company" id="company" class="form-control" required/>
            </div>

            <div class="form-group">
              <label for="gender">Gender</label>
              <select v-model="gender" id="gender" class="form-control">
                <option value="" disabled>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <div class="form-group">
              <label for="dob">Date of Birth</label>
              <input type="date" v-model="dob" id="dob" class="form-control" required/>
            </div>

            <button type="submit" class="btn btn-success mt-3">Save</button>
          </form>
        </div>
      </div>

      <!-- Phone Bot Table Section -->
      <div v-if="savedIssues.length > 0" class="card mt-4 p-4">
        <h4>Phone Bot</h4>
        <table class="table table-bordered mt-3">
          <thead>
            <tr>
              <th>Phone Bot</th>
              <th>Subject</th>
              <th>Issue Details</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="issue in savedIssues" :key="issue.id">
              <td>{{ issue.botName }}</td>
              <td v-if="!issue.isEditing">{{ issue.subject }}</td>
              <td v-else><input v-model="issue.subject" /></td>
              <td v-if="!issue.isEditing">{{ issue.details }}</td>
              <td v-else><textarea v-model="issue.details"></textarea></td>
              <td>
                <button @click="editIssue(issue)" v-if="!issue.isEditing">
                  <i class="fas fa-edit"></i>
                </button>
                <button @click="saveIssue(issue)" v-else>
                  <i class="fas fa-save"></i>
                </button>
                <button @click="deleteIssue(issue.id)">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: "Richard Davis",
      email: "richard@example.com",
      company: "CEO / Co-Founder",
      gender: "",
      dob: "",
      profileImage: require("@/assets/img/bruce-mars.jpg"),
      headerImage: "https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80",
      savedIssues: [] // Holds the list of saved issues from Phone Bot Dashboard
    };
  },
  methods: {
    uploadProfileImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.profileImage = URL.createObjectURL(file);
      }
    },
    saveProfile() {
      const profileData = {
        name: this.name,
        email: this.email,
        company: this.company,
        gender: this.gender,
        dob: this.dob,
        profileImage: this.profileImage,
      };

      // Save to local storage
      localStorage.setItem('userProfile', JSON.stringify(profileData));

      alert("Profile updated successfully!");

      // Future integration with MySQL could be done here
    },
    loadProfile() {
      const savedProfile = localStorage.getItem('userProfile');
      if (savedProfile) {
        const parsedProfile = JSON.parse(savedProfile);
        this.name = parsedProfile.name;
        this.email = parsedProfile.email;
        this.company = parsedProfile.company;
        this.gender = parsedProfile.gender;
        this.dob = parsedProfile.dob;
        this.profileImage = parsedProfile.profileImage;
      }
    },
    loadPhoneBotIssues() {
      const issues = localStorage.getItem("issues");
      if (issues) {
        this.savedIssues = JSON.parse(issues);
      }
    },
    editIssue(issue) {
      issue.isEditing = true;
    },
    saveIssue(issue) {
      issue.isEditing = false;
      localStorage.setItem("issues", JSON.stringify(this.savedIssues));
    },
    deleteIssue(issueId) {
      this.savedIssues = this.savedIssues.filter(issue => issue.id !== issueId);
      localStorage.setItem("issues", JSON.stringify(this.savedIssues));
    }
  },
  mounted() {
    this.loadProfile();
    this.loadPhoneBotIssues(); // Load Phone Bot when the component is mounted
  }
};
</script>

<style scoped>
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
.table {
  margin-top: 20px;
}
.fas {
  cursor: pointer;
  margin: 0 5px;
  font-size: 1.2em;
  transition: color 0.3s ease;
}
.fas.fa-edit {
  color: #007bff;
}
.fas.fa-edit:hover {
  color: #0056b3;
}
.fas.fa-save {
  color: #28a745;
}
.fas.fa-save:hover {
  color: #218838;
}
.fas.fa-trash-alt {
  color: #dc3545;
}
.fas.fa-trash-alt:hover {
  color: #c82333;
}
</style>
