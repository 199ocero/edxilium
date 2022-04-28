<template>
    <div class="form auth-boxed">
        <div class="form-container outer">
            <div class="form-form">
                <div class="form-form-wrap">
                    <div class="form-container">
                        <div class="form-content">

                            <h1 class="">Register</h1>
                            <p class="signup-link register">Already have an account? <router-link to="/login">Log in</router-link></p>
                            
                            <b-form class="text-left" action="#" @submit.prevent="registerAdmin" @keydown="errors.clear($event.target.name)">
                                <div class="form">
                                    
                                    <div id="username-field" class="field-wrapper input">
                                        <label for="username">NAME</label>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <b-input v-model="form.name" name="name" placeholder="Name"></b-input>
                                        <span class="text-danger" v-text="errors.get('name')"></span>
                                    </div>

                                    <div id="email-field" class="field-wrapper input">
                                        <label for="email">EMAIL</label>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                        <b-input v-model="form.email" name="email" type="email" placeholder="Email"></b-input>
                                         <span class="text-danger" v-text="errors.get('email')"></span>
                                    </div>

                                    <div id="password-field" class="field-wrapper input mb-2">
                                        <div class="d-flex justify-content-between">
                                            <label for="password">PASSWORD</label>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                        <b-input v-model="form.password" name="password" :type="pwd_type" placeholder="Password"></b-input>
                                        <svg @click="set_pwd_type" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                         <span class="text-danger" v-text="errors.get('password')"></span>
                                    </div>

                                    <div id="confirm_password-field" class="field-wrapper input mb-2">
                                        <div class="d-flex justify-content-between">
                                            <label for="confirm_password">PASSWORD CONFIRMATION</label>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                        <b-input v-model="form.password_confirmation" name="password_confirmation" :type="confirm_pwd_type" placeholder="Password Confirmation"></b-input>
                                        <svg @click="confirm_pwd_type" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                         <span class="text-danger" v-text="errors.get('password_confirmation')"></span>
                                    </div>

                                    <div class="d-sm-flex justify-content-between mt-4">
                                        <div class="field-wrapper">
                                            <b-button type="submit" variant="primary">Get Started!</b-button>
                                        </div>
                                    </div>

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
        metaInfo: { title: 'Register' },
        data() {
            return {
                pwd_type: 'password',
                confirm_pwd_type: 'password',
                form:{
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                errors:new Errors(),
            }
        },
        mounted() {
        },
        methods: {
            set_pwd_type() {
                if (this.pwd_type == 'password') { this.pwd_type = 'text'; } else { this.pwd_type = 'password'; }
                if (this.confirm_pwd_type == 'password') { this.confirm_pwd_type = 'text'; } else { this.confirm_pwd_type = 'password'; }
            },
            registerAdmin(){
                this.$http.post('/api/admin/register', this.form).then(() =>{
                        this.form.name = this.form.email = this.form.password = this.form.password_confirmation = ''
                        this.errors = []
                        this.$router.push({name:'login'})
                        // console.log('saved');
                    }).catch((errors) =>{
                        this.errors.record(errors.response.data.errors);
                })
            }
        }
    };
</script>
