<template>
  <div class="layout-px-spacing">
    <portal to="breadcrumb">
      <ul class="navbar-nav flex-row">
        <li>
          <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span>Admin - Section List</span>
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
          <h4>View Section List</h4>
        </div>
        <div class="panel br-6 p-0">
          <div class="custom-table">
            <div class="d-flex flex-wrap justify-content-center justify-content-sm-start px-3 pt-3 pb-0">
              <b-button variant="primary" class="m-1" v-b-modal.sectionModal> Add Section </b-button>
              <b-button variant="secondary" class="m-1" @click="sampleCSV"> Sample CSV</b-button>
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
              <template #cell(section)="data">
                <b-button size="sm mr-3" pill variant="primary" :to="{ name: 'adminSectionStudent', params: { id: data.item.id } }">{{ data.item.section }}</b-button>
              </template>
              <template #cell(action)="data">
                <b-button size="sm mr-3" pill variant="dark" v-b-modal.sectionEditModal @click="editSection(data.item.id)">Edit</b-button>
                <b-button size="sm" pill variant="danger" @click="deleteSection(data.item.id)">Delete</b-button>
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
    <!--Add Modal for Section -->
    <b-modal id="sectionModal" title="Add Section" centered hide-footer @hidden="sectionResetModal">
      <b-form action="#" @submit.prevent="addSection" @keydown="errors.clear($event.target.name)">
        <b-form-group label="Section Name">
          <b-input v-model="form.section" name="section" type="text" placeholder="Section Name"></b-input>
          <span class="text-danger" v-text="errors.get('section')"></span>
        </b-form-group>
        <b-form-group label="CSV File">
          <b-form-file v-model="form.file" plain></b-form-file>
          <p class="mt-3 form-text text-muted">
            <strong><span style="color: #009688">Note:</span></strong> If there are errors, it means that your file is either missing a data in csv file or you have uploaded an incorrect file format.
          </p>
          <p class="text-danger" v-text="errors.get('file')"></p>
          <p class="text-danger" v-text="errors.get('student_id')"></p>
          <p class="text-danger" v-text="errors.get('first_name')"></p>

          <p class="text-danger" v-text="errors.get('middle_name')"></p>
          <p class="text-danger" v-text="errors.get('last_name')"></p>
          <p class="text-danger" v-text="errors.get('age')"></p>
          <p class="text-danger" v-text="errors.get('gender')"></p>
          <p class="text-danger" v-text="errors.get('contact_number')"></p>
          <p class="text-danger" v-text="errors.get('email')"></p>
        </b-form-group>
        <div class="d-flex flex-wrap justify-content-center justify-content-sm-end">
          <b-button type="submit" variant="primary" class="mt-3 m-1">Create</b-button>
          <b-button variant="danger" class="mt-3 m-1" @click="$bvModal.hide('sectionModal')">Cancel</b-button>
        </div>
      </b-form>
    </b-modal>
    <!--Add Modal for Section -->
    <b-modal id="sectionEditModal" title="Add Section" centered hide-footer @hidden="sectionEditResetModal">
      <b-form action="#" @submit.prevent="updateSection" @keydown="errors.clear($event.target.name)">
        <b-input hidden v-model="form.id"></b-input>
        <b-form-group label="Section Name">
          <b-input v-model="form.section" name="section" type="text" placeholder="Section Name"></b-input>
          <span class="text-danger" v-text="errors.get('section')"></span>
        </b-form-group>
        <hr />
        <div class="d-flex flex-wrap justify-content-center justify-content-sm-end">
          <b-button type="submit" variant="primary" class="mt-3 m-1">Update</b-button>
          <b-button variant="danger" class="mt-3 m-1" @click="$bvModal.hide('sectionEditModal')">Cancel</b-button>
        </div>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
import Errors from '@/main.js';
export default {
  metaInfo: { title: 'Section' },
  data() {
    return {
      form: {
        id: '',
        section: '',
        file: null,
        student_id: '',
        first_name: '',
        middle_name: '',
        last_name: '',
        age: '',
        gender: '',
        contact_number: '',
        email: '',
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
      this.columns = [
        { key: 'section', label: 'Section Name' },
        { key: 'action', label: 'Actions', class: 'actions text-center' },
      ];
      let fetchTodo = async () => {
        this.items = [];

        this.$http
          .get('/api/section', {
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
    addSection() {
      let self = this;
      self.$Progress.start();
      const config = {
        headers: {
          'content-type': 'multipart/form-data',
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
      };
      let data = new FormData();
      data.append('file', self.form.file);
      data.append('section', self.form.section);
      self.$http
        .post('/api/import/student-section', data, config)
        .then(function () {
          self.$toaster.success('Section Created Successfuly!');
          self.$nextTick(() => {
            self.$bvModal.hide('sectionModal');
          });
          self.bind_data();
          self.$Progress.finish();
        })
        .catch((errors) => {
          self.errors.record(errors.response.data.errors);
          self.$Progress.fail();
        });
    },
    deleteSection(id) {
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
              .delete('/api/section/' + id, {
                headers: {
                  Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
              })
              .then(() => {
                this.$swal.fire('Deleted!', 'Section has been deleted.', 'success');
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
    editSection(id) {
      // console.log(id);
      this.$http
        .get('/api/section/' + id, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then((response) => {
          this.form.id = response.data.data.id;
          this.form.section = response.data.data.section;
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
        });
    },
    updateSection() {
      var id = this.form.id;
      let self = this;
      var axios = require('axios');
      var data = this.form;
      var config = {
        method: 'put',
        url: '/api/section/' + id,
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token'),
        },
        data: data,
      };
      self.$Progress.start();
      axios(config)
        .then(function () {
          self.$toaster.success('Section Update Successfuly!');
          self.$nextTick(() => {
            self.$bvModal.hide('sectionEditModal');
          });
          self.bind_data();
          self.$Progress.finish();
        })
        .catch(function (errors) {
          self.errors.record(errors.response.data.errors);
          self.$Progress.fail();
        });
    },
    sectionResetModal() {
      this.form.section = 'section';
      this.form.first_name = 'first_name';
      this.form.student_id = 'student_id';
      this.form.middle_name = 'middle_name';
      this.form.last_name = 'last_name';
      this.form.age = 'age';
      this.form.gender = 'gender';
      this.form.contact_number = 'contact_number';
      this.form.email = 'email';

      this.form.section = '';
      this.form.first_name = '';
      this.form.student_id = '';
      this.form.middle_name = '';
      this.form.last_name = '';
      this.form.age = '';
      this.form.gender = '';
      this.form.contact_number = '';
      this.form.email = '';

      this.errors.clear('section');
      this.errors.clear('file');
      this.errors.clear('first_name');
      this.errors.clear('student_id');
      this.errors.clear('middle_name');
      this.errors.clear('last_name');
      this.errors.clear('age');
      this.errors.clear('gender');
      this.errors.clear('contact_number');
      this.errors.clear('email');
    },
    sectionEditResetModal() {
      this.form.section = 'section';

      this.form.section = '';

      this.errors.clear('section');
    },
    sampleCSV() {
      this.$swal.fire({
        icon: 'info',
        title: 'Section CSV File',
        text: 'Please download this CSV template and change the data according to this format.',
        footer: '<a target="_blank" href="https://docs.google.com/spreadsheets/d/1sLZi_r9pRzjHrs0JmPgtLyMwEGEmPzCqHcL__t922dM/edit?usp=sharing">Download CSV Template</a>',
        padding: '2em',
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
