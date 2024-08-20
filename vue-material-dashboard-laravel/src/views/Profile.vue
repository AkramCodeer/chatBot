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
    }
  },
  mounted() {
    this.loadProfile();
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
</style>
