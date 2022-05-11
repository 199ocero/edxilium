<template>
  <div class="layout-px-spacing">
    <portal to="breadcrumb">
      <ul class="navbar-nav flex-row">
        <li>
          <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span>Admin - Instructor Accounts</span>
                </li>
              </ol>
            </nav>
          </div>
        </li>
      </ul>
    </portal>

    <div class="row layout-top-spacing">
      <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="seperator-header">
          <h4>View Instructor Accounts</h4>
        </div>
        <div class="panel br-6 p-0">
          <div class="custom-table">
            <div class="d-flex flex-wrap justify-content-center justify-content-sm-start px-3 pt-3 pb-0">
              <b-button variant="primary" class="m-1" v-b-modal.instructorModal> Add Instructor </b-button>
            </div>
            <div class="table-header">
              <div class="d-flex align-items-center">
                <span>Results :</span>
                <span class="ml-2">
                  <b-select v-model="table_option.page_size" size="sm">
                    <b-select-option value="5">5</b-select-option>
                    <b-select-option value="10">10</b-select-option>
                    <b-select-option value="20">20</b-select-option>
                    <b-select-option value="50">50</b-select-option>
                  </b-select>
                </span>
              </div>
              <div class="header-search">
                <b-input v-model="table_option.search_text" size="sm" placeholder="Search..." />
                <div class="search-image">
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
                    class="feather feather-search"
                  >
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                  </svg>
                </div>
              </div>
            </div>

            <b-table
              ref="basic_table"
              responsive
              hover
              :items="items"
              :fields="columns"
              :per-page="table_option.page_size"
              :current-page="table_option.current_page"
              :filter="table_option.search_text"
              sort-by="name"
              :show-empty="true"
              @filtered="on_filtered"
            >
              <template #cell(email_status)="data">
                <b-badge variant="success" v-if="data.item.email_verified_at != null"> Verified </b-badge>
                <b-badge variant="secondary" v-else> Pending </b-badge>
              </template>
              <template #cell(account)="data">
                <b-badge variant="success" v-if="data.item.status == 'activated'"> Activated </b-badge>
                <b-badge variant="danger" v-else> Deactivated </b-badge>
              </template>
              <template #cell(action)="data">
                <b-button size="sm mr-3" pill variant="dark" v-b-modal.instructorEditModal @click="editInstructor(data.item.id)">Edit</b-button>
                <b-button size="sm mr-3" pill variant="info" v-if="data.item.email_verified_at == null" @click="resendEmail(data.item.id)">Resend Verification</b-button>
                <b-button size="sm mr-3" pill variant="primary" v-if="data.item.status == 'activated'" @click="deactivateInstructor(data.item.id)">Deactivate</b-button>
                <b-button size="sm mr-3" pill variant="primary" v-if="data.item.status == 'deactivated'" @click="activateInstructor(data.item.id)">Activate</b-button>
                <b-button size="sm" pill variant="danger" @click="deleteInstructor(data.item.id)">Delete</b-button>
              </template>
            </b-table>

            <div class="table-footer">
              <div class="dataTables_info">Showing {{ meta.total_items ? meta.start_index + 1 : 0 }} to {{ meta.end_index + 1 }} of {{ meta.total_items }}</div>
              <div class="paginating-container pagination-solid flex-column align-items-right">
                <b-pagination
                  v-model="table_option.current_page"
                  :total-rows="table_option.total_rows"
                  :per-page="table_option.page_size"
                  prev-text="Prev"
                  next-text="Next"
                  first-text="First"
                  last-text="Last"
                  first-class="first"
                  prev-class="prev"
                  next-class="next"
                  last-class="last"
                  class="rounded"
                >
                  <template #first-text>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                  </template>
                  <template #prev-text>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                  </template>
                  <template #next-text>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </template>
                  <template #last-text>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                  </template>
                </b-pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
      <vue-progress-bar></vue-progress-bar>
    </div>
    <!--Add Modal for Instructor -->
    <b-modal id="instructorModal" title="Add Instructor Account" centered hide-footer @show="registerResetModal" @hidden="registerResetModal">
      <b-form action="#" @submit.prevent="registerInstructor" @keydown="errors.clear($event.target.name)">
        <b-form-group label="First Name">
          <b-input v-model="form.first_name" name="first_name" type="text" placeholder="First Name"></b-input>
          <span class="text-danger" v-text="errors.get('first_name')"></span>
        </b-form-group>
        <b-form-group label="Last Name">
          <b-input v-model="form.last_name" name="last_name" type="text" placeholder="Last Name"></b-input>
          <span class="text-danger" v-text="errors.get('last_name')"></span>
        </b-form-group>
        <b-form-group label="Email Address">
          <b-input v-model="form.email" name="email" type="email" placeholder="Email Address"></b-input>
          <span class="text-danger" v-text="errors.get('email')"></span>
        </b-form-group>
        <hr />
        <div class="d-flex flex-wrap justify-content-center justify-content-sm-end">
          <b-button type="submit" variant="primary" class="mt-3 m-1">Create</b-button>
          <b-button variant="danger" class="mt-3 m-1" @click="$bvModal.hide('instructorModal')">Cancel</b-button>
        </div>
      </b-form>
    </b-modal>
    <!--Edit Modal for Instructor -->
    <b-modal id="instructorEditModal" title="Edit Instructor Account" centered size="lg" hide-footer @hidden="editResetModal">
      <b-form action="#" @submit.prevent="updateInstructor" @keydown="errors.clear($event.target.name)">
        <b-input hidden v-model="form.id"></b-input>
        <b-input hidden v-model="form.email"></b-input>
        <b-form-row class="mb-4">
          <b-form-group label="First Name" class="col-md-4">
            <b-input v-model="form.first_name" name="first_name" type="text" placeholder="First Name"></b-input>
            <span class="text-danger" v-text="errors.get('first_name')"></span>
          </b-form-group>
          <b-form-group label="Middle Name" class="col-md-4">
            <b-input v-model="form.middle_name" name="middle_name" type="text" placeholder="Middle Name"></b-input>
            <span class="text-danger" v-text="errors.get('middle_name')"></span>
          </b-form-group>
          <b-form-group label="Last Name" class="col-md-4">
            <b-input v-model="form.last_name" name="last_name" type="text" placeholder="Last Name"></b-input>
            <span class="text-danger" v-text="errors.get('last_name')"></span>
          </b-form-group>
        </b-form-row>
        <b-form-row class="mb-4">
          <b-form-group label="Age" class="col-md-4">
            <b-input v-model="form.age" name="age" v-mask="'##'" placeholder="__"></b-input>
            <span class="text-danger" v-text="errors.get('age')"></span>
          </b-form-group>
          <b-form-group label="Gender" class="col-md-4">
            <!-- Default Select -->
            <b-select v-model="form.gender">
              <b-select-option :value="null" disabled>Select Gender</b-select-option>
              <b-select-option value="Male">Male</b-select-option>
              <b-select-option value="Female">Female</b-select-option>
            </b-select>
            <span class="text-danger" v-text="errors.get('gender')"></span>
          </b-form-group>
          <b-form-group label="Contact Number" class="col-md-4">
            <b-input v-model="form.contact_number" name="contact_number" v-mask="'(###) ###-####'" placeholder="(___) ___-____"></b-input>
            <small class="form-text text-muted"><span style="color: #009688">Note:</span> Contact number should start with number 9.</small>

            <span class="text-danger" v-text="errors.get('contact_number')"></span>
          </b-form-group>
        </b-form-row>
        <hr />
        <div class="d-flex flex-wrap justify-content-center justify-content-sm-end">
          <b-button type="submit" variant="primary" class="mt-3 m-1">Update</b-button>
          <b-button variant="danger" class="mt-3 m-1" @click="$bvModal.hide('instructorEditModal')">Cancel</b-button>
        </div>
      </b-form>
    </b-modal>
  </div>
</template>
<style scoped>
.layout-px-spacing {
  min-height: calc(100vh - 170px) !important;
}
</style>
<script>
import Errors from '@/main.js';
export default {
  metaInfo: { title: 'Instructor' },
  data() {
    return {
      form: {
        id: '',
        status: '',
        first_name: '',
        middle_name: '',
        last_name: '',
        age: '',
        gender: '',
        contact_number: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      errors: new Errors(),
      items: [],
      columns: [],
      table_option: { total_rows: 0, current_page: 1, page_size: 10, search_text: '' },
      meta: {},
    };
  },
  watch: {
    table_option: {
      handler: function () {
        this.get_meta();
      },
      deep: true,
    },
  },
  mounted() {
    this.bind_data();
  },
  methods: {
    bind_data() {
      this.columns = ['role', 'email', 'email_status', 'account', 'action'];
      this.columns = [
        { key: 'role', label: 'Role' },
        { key: 'email', label: 'Email Address' },
        { key: 'email_status', label: 'Email Status' },
        { key: 'account', label: 'Account Status' },
        { key: 'action', label: 'Actions', class: 'actions text-center' },
      ];
      let fetchTodo = async () => {
        this.items = [];

        this.$http
          .get('/api/instructor', {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          })
          .then((res) => {
            this.items = res.data.data;
            this.table_option.total_rows = this.items.length;
            this.get_meta();
          })
          .catch((errors) => {
            console.log(errors);
          });
      };

      fetchTodo();
    },
    registerInstructor() {
      this.$Progress.start();
      this.$http
        .post('/api/instructor', this.form, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then(() => {
          this.$toaster.success('Instructor Created Successfuly!');
          this.$nextTick(() => {
            this.$bvModal.hide('instructorModal');
          });
          this.bind_data();
          this.$Progress.finish();
          this.$swal.fire('Email Sent', 'Email verification and credentials are sent!', 'success');
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
          this.$Progress.fail();
        });
    },
    registerResetModal() {
      // do not remove this (this will fill up the the field)
      this.form.email = 'email';

      // this will remove text inside the email field
      this.form.email = '';

      // this will remove the error
      this.errors.clear('email');
    },
    deleteInstructor(id) {
      // console.log(id);
      // this.$swal('Hello Vue world!!!');
      this.$swal
        .fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
        })
        .then((result) => {
          if (result.isConfirmed) {
            //Send delete request
            this.$Progress.start();
            this.$http
              .delete('/api/instructor/' + id, {
                headers: {
                  Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
              })
              .then(() => {
                this.$swal.fire('Deleted!', 'Instructor account has been deleted.', 'success');
                this.bind_data();
                this.$Progress.finish();
              })
              .catch(() => {
                this.$swal.fire('Failed!', 'There was something wrong.', 'warning');
                this.$Progress.fail();
              });
          }
        });
    },
    editInstructor(id) {
      // console.log(id);
      this.$http
        .get('/api/instructor/' + id, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then((response) => {
          this.form.id = response.data.data.id;
          this.form.first_name = response.data.data.first_name;
          this.form.middle_name = response.data.data.middle_name;
          this.form.last_name = response.data.data.last_name;
          this.form.age = response.data.data.age;
          this.form.gender = response.data.data.gender;
          this.form.contact_number = response.data.data.contact_number;
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
        });
    },
    editResetModal() {
      this.form.first_name = 'first_name';
      this.form.middle_name = 'middle_name';
      this.form.last_name = 'last_name';
      this.form.age = 'age';
      this.form.gender = 'gender';
      this.form.contact_number = 'contact_number';

      this.form.first_name = '';
      this.form.middle_name = '';
      this.form.last_name = '';
      this.form.age = '';
      this.form.gender = '';
      this.form.contact_number = '';

      this.errors.clear('first_name');
      this.errors.clear('middle_name');
      this.errors.clear('last_name');
      this.errors.clear('age');
      this.errors.clear('gender');
      this.errors.clear('contact_number');
    },
    updateInstructor() {
      var id = this.form.id;
      let self = this;
      var axios = require('axios');
      var data = this.form;
      var config = {
        method: 'put',
        url: '/api/instructor/' + id,
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token'),
        },
        data: data,
      };
      self.$Progress.start();
      axios(config)
        .then(function () {
          self.$toaster.success('Instructor Update Successfuly!');
          self.$nextTick(() => {
            self.$bvModal.hide('instructorEditModal');
          });
          self.bind_data();
          self.$Progress.finish();
        })
        .catch(function (errors) {
          self.errors.record(errors.response.data.errors);
          self.$Progress.fail();
        });
    },
    resendEmail(id) {
      this.$swal
        .fire({
          title: 'Are you sure?',
          text: 'This will resend an email verification to this user.',
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, send it!',
        })
        .then((result) => {
          if (result.isConfirmed) {
            // Resend email
            this.$Progress.start();
            this.$http
              .get('/api/email/resend/' + id, {
                headers: {
                  Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
              })
              .then(() => {
                this.$swal.fire('Sent!', 'Email verification sent!', 'success');
                this.bind_data();
                this.$Progress.finish();
              })
              .catch(() => {
                this.$swal.fire('Failed!', 'There was something wrong.', 'warning');
                this.$Progress.fail();
              });
          }
        });
    },
    deactivateInstructor(id) {
      this.$swal
        .fire({
          title: 'Are you sure?',
          text: 'This user will be deactivated.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, deactivate it!',
        })
        .then((result) => {
          if (result.isConfirmed) {
            let self = this;
            var axios = require('axios');
            var data = this.form;
            var config = {
              method: 'put',
              url: '/api/instructor/deactivate/' + id,
              headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token'),
              },
              data: data,
            };
            self.$Progress.start();
            axios(config)
              .then(function () {
                self.$swal.fire('Success!', 'Account deactivated successfully!', 'success');
                self.bind_data();
                self.$Progress.finish();
              })
              .catch(function () {
                self.$swal.fire('Failed!', 'There was something wrong.', 'warning');
                self.$Progress.fail();
              });
          }
        });
    },
    activateInstructor(id) {
      this.$swal
        .fire({
          title: 'Are you sure?',
          text: 'This user will be activated.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, activate it!',
        })
        .then((result) => {
          if (result.isConfirmed) {
            let self = this;
            var axios = require('axios');
            var data = this.form;
            var config = {
              method: 'put',
              url: '/api/instructor/activate/' + id,
              headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token'),
              },
              data: data,
            };
            self.$Progress.start();
            axios(config)
              .then(function () {
                self.$swal.fire('Success!', 'Account activated successfully!', 'success');
                self.bind_data();
                self.$Progress.finish();
              })
              .catch(function () {
                self.$swal.fire('Failed!', 'There was something wrong.', 'warning');
                self.$Progress.fail();
              });
          }
        });
    },
    on_filtered(filtered_items) {
      this.refresh_table(filtered_items.length);
    },
    refresh_table(total) {
      this.table_option.total_rows = total;
      this.table_option.currentPage = 1;
    },
    get_meta() {
      var startPage;
      var endPage;
      var totalPages = this.table_option.page_size < 1 ? 1 : Math.ceil(this.table_option.total_rows / this.table_option.page_size);
      totalPages = Math.max(totalPages || 0, 1);

      var maxSize = 5;
      var isMaxSized = typeof maxSize !== 'undefined' && maxSize < totalPages;
      if (isMaxSized) {
        startPage = Math.max(this.table_option.current_page - Math.floor(maxSize / 2), 1);
        endPage = startPage + maxSize - 1;

        if (endPage > totalPages) {
          endPage = totalPages;
          startPage = endPage - maxSize + 1;
        }
      } else {
        startPage = 1;
        endPage = totalPages;
      }
      let startIndex = (this.table_option.current_page - 1) * this.table_option.page_size;
      let endIndex = Math.min(startIndex + this.table_option.page_size - 1, this.table_option.total_rows - 1);

      var pages = Array.from(Array(endPage + 1 - startPage).keys()).map((i) => startPage + i);
      this.meta = {
        total_items: this.table_option.total_rows,
        current_page: this.table_option.current_page,
        page_size: this.table_option.page_size,
        total_pages: totalPages,
        start_page: startPage,
        end_page: endPage,
        start_index: startIndex,
        end_index: endIndex,
        pages: pages,
      };
    },
  },
};
</script>