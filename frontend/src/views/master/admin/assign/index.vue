<template>
  <div class="layout-px-spacing">
    <portal to="breadcrumb">
      <ul class="navbar-nav flex-row">
        <li>
          <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span>Instructor - Assign</span>
                </li>
              </ol>
            </nav>
          </div>
        </li>
      </ul>
    </portal>

    <div class="row layout-top-spacing">
      <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="seperator-header">
          <h4>Assigning Instructor - Section - Subject - Year Level - School Year</h4>
        </div>
        <div class="panel br-6 p-0">
          <div class="custom-table">
            <div class="d-flex flex-wrap justify-content-center justify-content-sm-start px-3 pt-3 pb-0">
              <b-button variant="primary" class="m-1" v-b-modal.assignModal @click="getData">Assign</b-button>
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
              <template #cell(instructor)="data">
                <span v-if="data.item.instructor == null">Deleted</span>
                <span v-else-if="data.item.instructor['middle_name'] == null"> {{ data.item.instructor['first_name'] }} {{ data.item.instructor['last_name'] }} </span>
                <span v-else>{{ data.item.instructor['first_name'] }} {{ data.item.instructor['middle_name'][0] }}. {{ data.item.instructor['last_name'] }}</span>
              </template>

              <template #cell(section)="data">
                <span v-if="data.item.section == null">Deleted</span>
                <span v-else>{{ data.item.section['section'] }}</span>
              </template>
              <template #cell(subject)="data">
                <span v-if="data.item.subject == null">Deleted</span>
                <span v-else>{{ data.item.subject['subject'] }}</span>
              </template>
              <template #cell(year_level)="data">
                <span v-if="data.item.subject == null">Deleted</span>
                <span v-else>{{ data.item.subject['year_level'] }}</span>
              </template>
              <template #cell(school_year)="data">
                <span v-if="data.item.school_year == null">Deleted</span>
                <span v-else>{{ data.item.school_year['start_year'] }} - {{ data.item.school_year['end_year'] }}</span>
              </template>
              <template #cell(action)="data">
                <b-button size="sm mr-3" pill variant="dark" v-b-modal.assignEditModal @click="editAssign(data.item.id)">Edit</b-button>
                <b-button size="sm" pill variant="danger" @click="deleteAssign(data.item.id)">Delete</b-button>
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
    <!--Assign Modal-->
    <b-modal id="assignModal" title="Assign" centered hide-footer @hidden="assignResetModal">
      <b-form action="#" @submit.prevent="addAssign" @keydown="errors.clear($event.target.name)">
        <b-form-group label="Instructor" class="select2">
          <multiselect
            v-model="form.instructor_id"
            :options="instructor"
            track-by="id"
            :custom-label="fullName"
            :searchable="true"
            placeholder="Select Instructor"
            selected-label=""
            select-label=""
            deselect-label=""
            @select="onSelect1"
          >
          </multiselect>
          <span class="text-danger" v-text="errors.get('instructor_id')"></span>
        </b-form-group>
        <b-form-group label="Section" class="select2">
          <multiselect
            v-model="form.section_id"
            :options="section"
            track-by="id"
            :custom-label="sectionName"
            :searchable="true"
            placeholder="Select Section"
            selected-label=""
            select-label=""
            deselect-label=""
            @select="onSelect2"
          >
          </multiselect>
          <span class="text-danger" v-text="errors.get('section_id')"></span>
        </b-form-group>
        <b-form-group label="Subject and Year Level" class="select2">
          <multiselect
            v-model="form.subject_id"
            :options="subject"
            track-by="id"
            :custom-label="subjectYear"
            :searchable="true"
            placeholder="Select Subject and Year Level"
            selected-label=""
            select-label=""
            deselect-label=""
            @select="onSelect3"
          >
          </multiselect>
          <span class="text-danger" v-text="errors.get('subject_id')"></span>
        </b-form-group>
        <b-form-group label="School Year" class="select2">
          <multiselect
            v-model="form.school_year_id"
            :options="school_year"
            track-by="id"
            :custom-label="schoolYear"
            :searchable="true"
            placeholder="Select School Year"
            selected-label=""
            select-label=""
            deselect-label=""
            @select="onSelect4"
          >
          </multiselect>
          <span class="text-danger" v-text="errors.get('school_year_id')"></span>
        </b-form-group>
        <hr />
        <div class="d-flex flex-wrap justify-content-center justify-content-sm-end">
          <b-button type="submit" variant="primary" class="mt-3 m-1">Create</b-button>
          <b-button variant="danger" class="mt-3 m-1" @click="$bvModal.hide('assignModal')">Cancel</b-button>
        </div>
      </b-form>
    </b-modal>
    <!--Assign Edit Modal-->
    <b-modal id="assignEditModal" title="Edit Assign" centered hide-footer @hidden="assignResetModal">
      <b-form action="#" @submit.prevent="updateAssign(form.id)" @keydown="errors.clear($event.target.name)">
        <b-form-group label="Instructor" class="select2">
          <multiselect
            v-model="form.instructor_id"
            :options="instructor"
            track-by="id"
            :custom-label="fullName"
            :searchable="true"
            placeholder="Select Instructor"
            selected-label=""
            select-label=""
            deselect-label=""
            @select="onSelect1"
          >
          </multiselect>
          <span class="text-danger" v-text="errors.get('instructor_id')"></span>
        </b-form-group>
        <b-form-group label="Section" class="select2">
          <multiselect
            v-model="form.section_id"
            :options="section"
            track-by="id"
            :custom-label="sectionName"
            :searchable="true"
            placeholder="Select Section"
            selected-label=""
            select-label=""
            deselect-label=""
            @select="onSelect2"
          >
          </multiselect>
          <span class="text-danger" v-text="errors.get('section_id')"></span>
        </b-form-group>
        <b-form-group label="Subject and Year Level" class="select2">
          <multiselect
            v-model="form.subject_id"
            :options="subject"
            track-by="id"
            :custom-label="subjectYear"
            :searchable="true"
            placeholder="Select Subject and Year Level"
            selected-label=""
            select-label=""
            deselect-label=""
            @select="onSelect3"
          >
          </multiselect>
          <span class="text-danger" v-text="errors.get('subject_id')"></span>
        </b-form-group>
        <b-form-group label="School Year" class="select2">
          <multiselect
            v-model="form.school_year_id"
            :options="school_year"
            track-by="id"
            :custom-label="schoolYear"
            :searchable="true"
            placeholder="Select School Year"
            selected-label=""
            select-label=""
            deselect-label=""
            @select="onSelect4"
          >
          </multiselect>
          <span class="text-danger" v-text="errors.get('school_year_id')"></span>
        </b-form-group>
        <hr />
        <div class="d-flex flex-wrap justify-content-center justify-content-sm-end">
          <b-button type="submit" variant="primary" class="mt-3 m-1">Update</b-button>
          <b-button variant="danger" class="mt-3 m-1" @click="$bvModal.hide('assignEditModal')">Cancel</b-button>
        </div>
      </b-form>
    </b-modal>
  </div>
</template>
<style scoped>
.layout-px-spacing {
  min-height: calc(100vh - 170px) !important;
}
.select2 .multiselect__option--highlight {
  background: #fff;
  color: #4361ee;
}
.select2 .multiselect__option--selected {
  background-color: rgba(27, 85, 226, 0.23921568627450981);
  color: #4361ee;
  font-weight: normal;
}
.select2 .multiselect__option--disabled {
  background: inherit !important;
}
.select2 .multiselect__tag {
  color: #000;
  background: #e4e4e4;
}
.select2 .multiselect__tag-icon:after {
  color: #000 !important;
}
.select2 .multiselect__tag-icon:focus,
.select2 .multiselect__tag-icon:hover {
  background: inherit;
}
</style>
<script>
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.min.css';
import Errors from '@/main.js';
export default {
  metaInfo: { title: 'Assign' },
  components: {
    Multiselect,
  },
  data() {
    return {
      form: {
        id: '',
        instructor_id: '',
        section_id: '',
        subject_id: '',
        school_year_id: '',
      },
      instructor: [],
      section: [],
      subject: [],
      school_year: [],
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
    this.getData();
  },
  methods: {
    fullName({ first_name, last_name }) {
      return `${first_name} ${last_name}`;
    },
    subjectYear({ subject, year_level }) {
      return `${subject} - ${year_level}`;
    },
    schoolYear({ start_year, end_year }) {
      return `${start_year} - ${end_year}`;
    },
    sectionName({ section }) {
      return `${section}`;
    },
    bind_data() {
      this.columns = [
        { key: 'instructor', label: 'Instructor Name' },
        { key: 'section', label: 'Section Name' },
        { key: 'subject', label: 'Subject Name' },
        { key: 'year_level', label: 'Year Level' },
        { key: 'school_year', label: 'School Year' },
        { key: 'action', label: 'Actions', class: 'actions text-center' },
      ];
      let fetchTodo = async () => {
        this.items = [];

        this.$http
          .get('/api/assign', {
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
    getData() {
      this.$http
        .get('/api/instructor/all', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then((response) => {
          this.instructor = response.data.data;
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
        });

      this.$http
        .get('/api/section', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then((response) => {
          this.section = response.data.data;
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
        });
      this.$http
        .get('/api/subject', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then((response) => {
          this.subject = response.data.data;
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
        });
      this.$http
        .get('/api/school-year', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then((response) => {
          this.school_year = response.data.data;
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
        });
    },
    addAssign() {
      this.form.instructor_id = this.form.instructor_id.id;
      this.form.section_id = this.form.section_id.id;
      this.form.subject_id = this.form.subject_id.id;
      this.form.school_year_id = this.form.school_year_id.id;
      this.$Progress.start();
      this.$http
        .post('/api/assign', this.form, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then(() => {
          this.$toaster.success('Assign Created Successfuly!');
          this.$nextTick(() => {
            this.$bvModal.hide('assignModal');
          });
          this.bind_data();
          this.$Progress.finish();
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
          this.$Progress.fail();
          this.form.instructor_id = [];
          this.form.section_id = [];
          this.form.subject_id = [];
          this.form.school_year_id = [];
          this.errors.record(errors.response.data.errors);
        });
    },
    deleteAssign(id) {
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
              .delete('/api/assign/' + id, {
                headers: {
                  Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
              })
              .then(() => {
                this.$swal.fire('Deleted!', 'Assign has been deleted.', 'success');
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
    editAssign($id) {
      this.$http
        .get('/api/assign/' + $id, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then((response) => {
          this.form.id = response.data.data.id;
          this.form.instructor_id = this.instructor.find((option) => option.id === response.data.data.instructor.id);
          this.form.section_id = this.section.find((option) => option.id === response.data.data.section.id);
          this.form.subject_id = this.subject.find((option) => option.id === response.data.data.subject.id);
          this.form.school_year_id = this.school_year.find((option) => option.id === response.data.data.school_year.id);
        })
        .catch((errors) => {
          this.errors.record(errors.response.data.errors);
        });
    },
    updateAssign($id) {
      let self = this;

      this.form.instructor_id = this.form.instructor_id.id;
      this.form.section_id = this.form.section_id.id;
      this.form.subject_id = this.form.subject_id.id;
      this.form.school_year_id = this.form.school_year_id.id;

      var axios = require('axios');
      var data = this.form;
      var config = {
        method: 'put',
        url: '/api/assign/' + $id,
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token'),
        },
        data: data,
      };
      self.$Progress.start();
      axios(config)
        .then(function () {
          self.$toaster.success('Assign Updated Successfuly!');
          self.$nextTick(() => {
            self.$bvModal.hide('assignEditModal');
          });
          self.bind_data();
          self.$Progress.finish();
        })
        .catch(function (errors) {
          self.errors.record(errors.response.data.errors);
          self.$Progress.fail();
        });
    },
    assignResetModal() {
      this.form.instructor_id = [];
      this.form.section_id = [];
      this.form.subject_id = [];
      this.form.school_year_id = [];
      // this will remove the error
      this.errors.clear('instructor_id');
      this.errors.clear('section_id');
      this.errors.clear('subject_id');
      this.errors.clear('school_year_id');
    },

    onSelect1() {
      this.errors.clear('instructor_id');
    },
    onSelect2() {
      this.errors.clear('section_id');
    },
    onSelect3() {
      this.errors.clear('subject_id');
    },
    onSelect4() {
      this.errors.clear('school_year_id');
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
