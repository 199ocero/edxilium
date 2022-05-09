<template>
  <div class="form no-image-content auth-boxed">
    <div class="form-container outer">
      <div class="form-form">
        <div class="form-form-wrap">
          <div class="form-container">
            <div class="form-content">
              <h1 class="">Password Reset</h1>
              <p class="signup-link recovery">Enter your email and instructions will sent to you!</p>
              <b-form class="text-left" action="#" @submit.prevent="resetPassword" @keydown="errors.clear($event.target.name)">
                <div class="form">
                  <div id="email-field" class="field-wrapper input">
                    <div class="d-flex justify-content-between">
                      <label for="email">EMAIL</label>
                    </div>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="feather feather-at-sign"
                    >
                      <circle cx="12" cy="12" r="4"></circle>
                      <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                    </svg>
                    <b-input v-model="form.email" name="email" type="email" placeholder="Email"></b-input>
                    <span class="text-danger" v-text="errors.get('email')"></span>
                    <span class="text-success" v-text="form.success"></span>
                  </div>

                  <div class="d-sm-flex justify-content-between">
                    <div class="field-wrapper">
                      <b-button type="submit" variant="primary" @click="resetPassword">Reset</b-button>
                    </div>
                  </div>
                  <p class="signup-link register mt-4">Already have an account? <router-link to="/login">Log in</router-link></p>
                </div>
              </b-form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <vue-progress-bar></vue-progress-bar>
  </div>
</template>

<script>
import Errors from '@/main.js';
import '@/assets/sass/authentication/auth-boxed.scss';
export default {
  metaInfo: { title: 'Password Reset' },
  data() {
    return {
      form: {
        email: '',
        success: '',
      },
      errors: new Errors(),
    };
  },
  mounted() {},
  methods: {
    resetPassword() {
      this.$Progress.start();
      this.$http
        .post('/api/password/email', this.form)
        .then(() => {
          this.form.success = 'Password reset link is sent to your email.';
          this.form.email = '';
          this.$Progress.finish();
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
          this.$Progress.fail();
        });
    },
  },
};
</script>
