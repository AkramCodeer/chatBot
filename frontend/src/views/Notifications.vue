<template>
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="card mt-4">
          <div class="card-header p-3">
            <h5 class="mb-0">Phone Bot Notifications</h5>
          </div>
          <div class="card-body p-3">
            <div class="row">
              <div class="col-lg-3 col-sm-6 col-12">
                <button
                  class="btn bg-gradient-success w-100 mb-0"
                  type="button"
                  @click="showNotification('Issue solved successfully.', 'success')"
                >
                  Success Notification
                </button>
              </div>
              <div class="col-lg-3 col-sm-6 col-12 mt-sm-0 mt-2">
                <button
                  class="btn bg-gradient-info w-100 mb-0"
                  type="button"
                  @click="showNotification('New update available.', 'info')"
                >
                  Info Notification
                </button>
              </div>
              <div class="col-lg-3 col-sm-6 col-12 mt-lg-0 mt-2">
                <button
                  class="btn bg-gradient-warning w-100 mb-0"
                  type="button"
                  @click="showNotification('Action required.', 'warning')"
                >
                  Warning Notification
                </button>
              </div>
              <div class="col-lg-3 col-sm-6 col-12 mt-lg-0 mt-2">
                <button
                  class="btn bg-gradient-danger w-100 mb-0"
                  type="button"
                  @click="showNotification('An error occurred.', 'danger')"
                >
                  Danger Notification
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="position-fixed bottom-1 end-1 z-index-2">
      <material-snackbar
        v-if="snackbar.visible"
        :title="snackbar.title"
        :description="snackbar.description"
        :icon="snackbar.icon"
        :color="snackbar.color"
        :close-handler="closeSnackbar"
      />
    </div>
  </div>
</template>

<script>
import MaterialSnackbar from "@/components/MaterialSnackbar.vue";

export default {
  name: "Notifications",
  components: {
    MaterialSnackbar,
  },
  data() {
    return {
      snackbar: {
        visible: false,
        title: "Phone Bot",
        description: "",
        icon: { component: "notifications", color: "white" },
        color: "info",
      },
    };
  },
  methods: {
    showNotification(description, color) {
      this.snackbar.description = description;
      this.snackbar.color = color;
      this.snackbar.visible = true;
    },
    closeSnackbar() {
      this.snackbar.visible = false;
    },
  },
};
</script>
