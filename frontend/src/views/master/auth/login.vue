<template>
  <div class="form auth-boxed">
    <div class="form-container outer">
      <div class="form-form">
        <div class="form-form-wrap">
          <div class="form-container">
            <div class="form-content">
              <h1 class="">Sign In</h1>
              <p class="">Log in to your account to continue.</p>

              <b-form class="text-left" action="#" @submit.prevent="loginAdmin" @keydown="errors.clear($event.target.name)">
                <div class="form">
                  <span class="text-danger" v-text="errors.get('verified')"></span>
                  <span class="text-danger" v-text="errors.get('account')"></span>
                  <div id="email-field" class="field-wrapper input">
                    <label for="email">EMAIL</label>
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
                      class="feather feather-at-sign register"
                    >
                      <circle cx="12" cy="12" r="4"></circle>
                      <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                    </svg>
                    <b-input v-model="form.email" name="email" type="email" placeholder="Email"></b-input>
                    <span class="text-danger" v-text="errors.get('email')"></span>
                  </div>

                  <div id="password-field" class="field-wrapper input mb-2">
                    <div class="d-flex justify-content-between">
                      <label for="password">PASSWORD</label>
                      <router-link to="/password/reset" class="forgot-pass-link">Forgot Password?</router-link>
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
                      class="feather feather-lock"
                    >
                      <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                      <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <b-input v-model="form.password" name="password" :type="pwd_type" placeholder="Password"></b-input>
                    <span class="text-danger" v-text="errors.get('password')"></span>
                  </div>
                  <div class="d-sm-flex justify-content-between mt-4">
                    <div class="field-wrapper">
                      <b-button type="submit" variant="primary" value="">Log In</b-button>
                    </div>
                  </div>

                  <p class="signup-link">Not registered ? <router-link to="/register">Create an account</router-link></p>
                </div>
              </b-form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import '@/assets/sass/authentication/auth-boxed.scss';
import Errors from '@/main.js';
export default {
  metaInfo: { title: 'Login' },
  data() {
    return {
      pwd_type: 'password',
      form: {
        email: '',
        password: '',
      },
      errors: new Errors(),
    };
  },
  mounted() {},
  methods: {
    loginAdmin() {
      this.$http
        .post('/api/user/login', this.form)
        .then((response) => {
          //  console.log(response)
          // console.log(response.data)
          localStorage.setItem('token', response.data.token);
          localStorage.setItem('role', response.data.role);
          this.$router.push({ name: 'Home' }).catch(() => {});
        })
        .catch((errors) => {
          // console.log(errors.response.data.errors);
          this.errors.record(errors.response.data.errors);
          console.log(errors);
        });
    },
  },
};
</script>
