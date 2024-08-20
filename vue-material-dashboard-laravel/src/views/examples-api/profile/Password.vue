<template>
  <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
    <h5 class="font-weight-bolder mb-0">Change Password</h5>
    <div class="multisteps-form__content mt-4">
      <div class="row">
        <div class="col-12">
          <!-- Password Input -->
          <div class="mt-2">
            <material-input
              id="password"
              v-model:value="user.password"
              type="password"
              label="Password"
              name="password"
              :class="{'is-invalid': apiValidationErrors.password}"
            />
            <validation-error :errors="apiValidationErrors.password" />
          </div>

          <!-- Confirm Password Input -->
          <div class="mt-5">
            <material-input
              id="confirmPassword"
              v-model:value="user.password_confirmation"
              type="password"
              label="Confirm Password"
              name="confirmPassword"
              :class="{'is-invalid': passwordMismatch || apiValidationErrors.password_confirmation}"
            />
            <validation-error :errors="passwordMismatch ? ['Passwords do not match.'] : apiValidationErrors.password_confirmation" />
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="button-row d-flex mt-4">
        <material-button
          type="button"
          color="dark"
          variant="gradient"
          class="ms-auto mb-0 js-btn-next"
          @click="handleChange"
          :disabled="loading"
        >
          Change Password
        </material-button>
      </div>
    </div>
  </div>
</template>

<script>
import MaterialButton from "@/components/MaterialButton.vue";
import MaterialInput from "@/components/MaterialInput.vue";
import ValidationError from "@/components/ValidationError.vue";
import formMixin from "@/mixins/formMixin.js";
import showSwal from "@/mixins/showSwal.js";

export default {
  name: "Password",
  components: {
    MaterialButton,
    MaterialInput,
    ValidationError,
  },
  data() {
    return {
      user: {
        password: "",
        password_confirmation: "",
      },
      loading: false,
      passwordMismatch: false,
    };
  },
  mixins: [formMixin],
  methods: {
    validatePasswords() {
      this.passwordMismatch = this.user.password !== this.user.password_confirmation;
    },
    async handleChange() {
      this.validatePasswords();

      if (this.passwordMismatch) {
        return;
      }

      this.resetApiValidation();
      this.loading = true;

      try {
        await this.$store.dispatch("profile/editProfile", this.user);
        showSwal.methods.showSwal({
          type: "success",
          message: "Password updated successfully!",
          width: 500,
        });
        this.user.password = this.user.password_confirmation = "";
      } catch (error) {
        this.setApiValidation(error.response.data.errors);
        showSwal.methods.showSwal({
          type: "error",
          message: "Oops, something went wrong!",
          width: 500,
        });
      } finally {
        this.loading = false;
      }
    },
  },
  watch: {
    "user.password": "validatePasswords",
    "user.password_confirmation": "validatePasswords",
  },
};
</script>

<style scoped>
.is-invalid {
  border-color: #dc3545;
}
.invalid-feedback {
  color: #dc3545;
}
</style>
