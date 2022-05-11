<template>
  <div class="layout-px-spacing">
    <portal to="breadcrumb">
      <ul class="navbar-nav flex-row">
        <li>
          <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span>Admin - Student List</span>
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
          <h4>View Student List in Section {{ form.sectionName }}</h4>
        </div>
        <div class="panel br-6 p-0">
          <div class="custom-table">
            <div class="d-flex flex-wrap justify-content-center justify-content-sm-start px-3 pt-3 pb-0">
              <b-button variant="primary" class="m-1" v-b-modal.studentAddModal v-if="form.sectionName != ''"> Add Student </b-button>
              <b-button variant="primary" class="m-1" v-else disabled> Add Student </b-button>
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
              <template #cell(action)="data">
                <b-button size="sm mr-3" pill variant="dark" v-b-modal.studentEditModal @click="editStudent(data.item.id)">Edit</b-button>
                <b-button size="sm" pill variant="danger" @click="deleteStudent(data.item.id)">Delete</b-button>
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
    <!--Add Modal for Student -->
    <b-modal id="studentAddModal" title="Add Student" centered size="lg" hide-footer @hidden="addResetModal">
      <b-form action="#" @submit.prevent="addStudent(form.sectionID)" @keydown="errors.clear($event.target.name)">
        <b-input hidden v-model="form.id"></b-input>
        <b-form-row class="mb-4">
          <b-form-group label="Student ID" class="col-md-3">
            <b-input v-model="form.student_id" name="student_id" type="text" placeholder="Student ID"></b-input>
            <span class="text-danger" v-text="errors.get('student_id')"></span>
          </b-form-group>
          <b-form-group label="First Name" class="col-md-3">
            <b-input v-model="form.first_name" name="first_name" type="text" placeholder="First Name"></b-input>
            <span class="text-danger" v-text="errors.get('first_name')"></span>
          </b-form-group>
          <b-form-group label="Middle Name" class="col-md-3">
            <b-input v-model="form.middle_name" name="middle_name" type="text" placeholder="Middle Name"></b-input>
            <span class="text-danger" v-text="errors.get('middle_name')"></span>
          </b-form-group>
          <b-form-group label="Last Name" class="col-md-3">
            <b-input v-model="form.last_name" name="last_name" type="text" placeholder="Last Name"></b-input>
            <span class="text-danger" v-text="errors.get('last_name')"></span>
          </b-form-group>
        </b-form-row>
        <b-form-row class="mb-4">
          <b-form-group label="Age" class="col-md-3">
            <b-input v-model="form.age" name="age" v-mask="'##'" placeholder="__"></b-input>
            <span class="text-danger" v-text="errors.get('age')"></span>
          </b-form-group>
          <b-form-group label="Gender" class="col-md-3">
            <!-- Default Select -->
            <b-select v-model="form.gender">
              <b-select-option value disabled>Select Gender</b-select-option>
              <b-select-option value="Male">Male</b-select-option>
              <b-select-option value="Female">Female</b-select-option>
            </b-select>
            <span class="text-danger" v-text="errors.get('gender')"></span>
          </b-form-group>
          <b-form-group label="Contact Number" class="col-md-3">
            <b-input v-model="form.contact_number" name="contact_number" v-mask="'(###) ###-####'" placeholder="(___) ___-____"></b-input>

            <small class="form-text text-muted"><span style="color: #009688">Note:</span> Contact number should start with number 9.</small>

            <span class="text-danger" v-text="errors.get('contact_number')"></span>
          </b-form-group>
          <b-form-group label="Email Address" class="col-md-3">
            <b-input v-model="form.email" name="email" type="email" placeholder="Email Address"></b-input>
            <span class="text-danger" v-text="errors.get('email')"></span>
          </b-form-group>
        </b-form-row>
        <hr />
        <div class="d-flex flex-wrap justify-content-center justify-content-sm-end">
          <b-button type="submit" variant="primary" class="mt-3 m-1">Create</b-button>
          <b-button variant="danger" class="mt-3 m-1" @click="$bvModal.hide('studentAddModal')">Cancel</b-button>
        </div>
      </b-form>
    </b-modal>
    <!--Edit Modal for Student -->
    <b-modal id="studentEditModal" title="Edit Student Details" centered size="lg" hide-footer @hidden="editResetModal">
      <b-form action="#" @submit.prevent="updateStudent" @keydown="errors.clear($event.target.name)">
        <b-input hidden v-model="form.id"></b-input>
        <b-form-row class="mb-4">
          <b-form-group label="Student ID" class="col-md-3">
            <b-input v-model="form.student_id" name="student_id" type="text" placeholder="Student ID"></b-input>
            <span class="text-danger" v-text="errors.get('student_id')"></span>
          </b-form-group>
          <b-form-group label="First Name" class="col-md-3">
            <b-input v-model="form.first_name" name="first_name" type="text" placeholder="First Name"></b-input>
            <span class="text-danger" v-text="errors.get('first_name')"></span>
          </b-form-group>
          <b-form-group label="Middle Name" class="col-md-3">
            <b-input v-model="form.middle_name" name="middle_name" type="text" placeholder="Middle Name"></b-input>
            <span class="text-danger" v-text="errors.get('middle_name')"></span>
          </b-form-group>
          <b-form-group label="Last Name" class="col-md-3">
            <b-input v-model="form.last_name" name="last_name" type="text" placeholder="Last Name"></b-input>
            <span class="text-danger" v-text="errors.get('last_name')"></span>
          </b-form-group>
        </b-form-row>
        <b-form-row class="mb-4">
          <b-form-group label="Age" class="col-md-3">
            <b-input v-model="form.age" name="age" v-mask="'##'" placeholder="__"></b-input>
            <span class="text-danger" v-text="errors.get('age')"></span>
          </b-form-group>
          <b-form-group label="Gender" class="col-md-3">
            <!-- Default Select -->
            <b-select v-model="form.gender">
              <b-select-option value disabled>Select Gender</b-select-option>
              <b-select-option value="Male">Male</b-select-option>
              <b-select-option value="Female">Female</b-select-option>
            </b-select>
            <span class="text-danger" v-text="errors.get('gender')"></span>
          </b-form-group>
          <b-form-group label="Contact Number" class="col-md-3">
            <b-input v-model="form.contact_number" name="contact_number" v-mask="'(###) ###-####'" placeholder="(___) ___-____"></b-input>
            <small class="form-text text-muted"><span style="color: #009688">Note:</span> Contact number should start with number 9.</small>

            <span class="text-danger" v-text="errors.get('contact_number')"></span>
          </b-form-group>
          <b-form-group label="Email Address" class="col-md-3">
            <b-input v-model="form.email" name="email" type="email" placeholder="Email Address"></b-input>
            <span class="text-danger" v-text="errors.get('email')"></span>
          </b-form-group>
        </b-form-row>
        <hr />
        <div class="d-flex flex-wrap justify-content-center justify-content-sm-end">
          <b-button type="submit" variant="primary" class="mt-3 m-1">Update</b-button>
          <b-button variant="danger" class="mt-3 m-1" @click="$bvModal.hide('studentEditModal')">Cancel</b-button>
        </div>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
import Vue from 'vue';
import VueMask from 'v-mask';
Vue.use(VueMask);
import Errors from '@/main.js';
export default {
  metaInfo: { title: 'Student' },
  data() {
    return {
      form: {
        id: '',
        student_id: '',
        first_name: '',
        middle_name: '',
        last_name: '',
        age: '',
        gender: '',
        contact_number: '',
        email: '',
        sectionID: this.$route.params.id,
        sectionName: '',
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
  created() {
    // console.log(id);
    this.$http
      .get('/api/section/' + this.form.sectionID, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
      })
      .then((response) => {
        this.form.sectionName = response.data.data.section;
      })
      .catch((errors) => {
        console.log(errors);
      });
  },
  methods: {
    bind_data() {
      this.columns = [
        { key: 'student_id', label: 'Student ID' },
        { key: 'first_name', label: 'First Name' },
        { key: 'middle_name', label: 'Middle Name' },
        { key: 'last_name', label: 'Last Name' },
        { key: 'age', label: 'Age' },
        { key: 'gender', label: 'Gender' },
        { key: 'contact_number', label: 'Contact Number' },
        { key: 'email', label: 'Email' },
        { key: 'action', label: 'Actions', class: 'actions text-center' },
      ];
      let fetchTodo = async () => {
        this.items = [];
        if (this.$route.params.id == 'undefined') {
          this.$swal.fire('Not Found!', 'Please choose a section.', 'warning');
          this.$router.push({ name: 'adminSection' });
        } else {
          this.$http
            .get('/api/student-section/' + this.$route.params.id, {
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
        }
      };

      fetchTodo();
    },
    addStudent(id) {
      this.$Progress.start();
      this.$http
        .post('/api/student/' + id, this.form, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then(() => {
          this.$toaster.success('Student Created Successfuly!');
          this.$nextTick(() => {
            this.$bvModal.hide('studentAddModal');
          });
          this.bind_data();
          this.$Progress.finish();
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
          this.$Progress.fail();
        });
    },
    editStudent(id) {
      // console.log(id);
      this.$http
        .get('/api/student/' + id, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then((response) => {
          this.form.id = response.data.data.id;
          this.form.student_id = response.data.data.student_id;
          this.form.first_name = response.data.data.first_name;
          this.form.middle_name = response.data.data.middle_name;
          this.form.last_name = response.data.data.last_name;
          this.form.age = response.data.data.age;
          this.form.gender = response.data.data.gender;
          this.form.contact_number = response.data.data.contact_number;
          this.form.email = response.data.data.email;
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
        });
    },
    updateStudent() {
      var id = this.form.id;
      let self = this;
      var axios = require('axios');
      var data = this.form;
      var config = {
        method: 'put',
        url: '/api/student/' + id,
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token'),
        },
        data: data,
      };
      self.$Progress.start();
      axios(config)
        .then(function () {
          self.$toaster.success('Student Update Successfuly!');
          self.$nextTick(() => {
            self.$bvModal.hide('studentEditModal');
          });
          self.bind_data();
          self.$Progress.finish();
        })
        .catch(function (errors) {
          self.errors.record(errors.response.data.errors);
          self.$Progress.fail();
        });
    },
    deleteStudent(id) {
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
              .delete('/api/student/' + id, {
                headers: {
                  Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
              })
              .then(() => {
                this.$swal.fire('Deleted!', 'Student has been deleted.', 'success');
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
    editResetModal() {
      this.form.student_id = 'student_id';
      this.form.first_name = 'first_name';
      this.form.middle_name = 'middle_name';
      this.form.last_name = 'last_name';
      this.form.age = 'age';
      this.form.gender = 'gender';
      this.form.contact_number = 'contact_number';
      this.form.email = 'email';

      this.form.student_id = '';
      this.form.first_name = '';
      this.form.middle_name = '';
      this.form.last_name = '';
      this.form.age = '';
      this.form.gender = '';
      this.form.contact_number = '';
      this.form.email = '';

      this.errors.clear('student_id');
      this.errors.clear('first_name');
      this.errors.clear('middle_name');
      this.errors.clear('last_name');
      this.errors.clear('age');
      this.errors.clear('gender');
      this.errors.clear('contact_number');
      this.errors.clear('email');
    },
    addResetModal() {
      this.form.student_id = 'student_id';
      this.form.first_name = 'first_name';
      this.form.middle_name = 'middle_name';
      this.form.last_name = 'last_name';
      this.form.age = 'age';
      this.form.gender = 'gender';
      this.form.contact_number = 'contact_number';
      this.form.email = 'email';

      this.form.student_id = '';
      this.form.first_name = '';
      this.form.middle_name = '';
      this.form.last_name = '';
      this.form.age = '';
      this.form.gender = '';
      this.form.contact_number = '';
      this.form.email = '';

      this.errors.clear('student_id');
      this.errors.clear('first_name');
      this.errors.clear('middle_name');
      this.errors.clear('last_name');
      this.errors.clear('age');
      this.errors.clear('gender');
      this.errors.clear('contact_number');
      this.errors.clear('email');
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
