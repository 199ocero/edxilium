<template>
  <!--  BEGIN SIDEBAR  -->
  <div class="sidebar-wrapper sidebar-theme">
    <nav ref="menu" id="sidebar">
      <div class="shadow-bottom"></div>

      <perfect-scrollbar
        class="list-unstyled menu-categories"
        tag="ul"
        :options="{
          wheelSpeed: 0.5,
          swipeEasing: !0,
          minScrollbarLength: 40,
          maxScrollbarLength: 300,
          suppressScrollX: true,
        }"
      >
        <!-- Dashboard -->
        <router-link tag="li" to="/" class="menu" @click.native="toggleMobileMenu">
          <a class="dropdown-toggle">
            <div class="">
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
                class="feather feather-grid"
                data-v-8d2239c6=""
              >
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
              </svg>
              <span>{{ $t('dashboard') }}</span>
            </div>
          </a>
        </router-link>
        <!-- Admin Instructor -->
        <router-link v-if="is_admin" tag="li" to="/admin/instructor" class="menu" @click.native="toggleMobileMenu">
          <a class="dropdown-toggle">
            <div class="">
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
                class="feather feather-users"
                data-v-8d2239c6=""
              >
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
              <span>{{ $t('Instructor') }}</span>
            </div>
          </a>
        </router-link>
        <!-- Admin Section -->
        <li class="menu" v-if="is_admin">
          <a href="#section" v-b-toggle class="dropdown-toggle" @click.prevent>
            <div class="">
              <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="9" y1="3" x2="9" y2="21"></line>
              </svg>
              <span>Section</span>
            </div>
            <div>
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
                class="feather feather-chevron-right"
              >
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            </div>
          </a>
          <b-collapse id="section" accordion="menu">
            <ul class="collapse submenu list-unstyled show">
              <router-link tag="li" to="/admin/section" @click.native="toggleMobileMenu"><a>Section</a></router-link>
              <router-link tag="li" :to="'/admin/section/' + sectionID" @click.native="toggleMobileMenu"><a>Student</a></router-link>
            </ul>
          </b-collapse>
        </li>
        <!-- Admin Subject -->
        <router-link v-if="is_admin" tag="li" to="/admin/subject" class="menu" @click.native="toggleMobileMenu">
          <a class="dropdown-toggle">
            <div class="">
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
                class="feather feather-book"
                data-v-8d2239c6=""
              >
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
              </svg>
              <span>{{ $t('Subject') }}</span>
            </div>
          </a>
        </router-link>
        <!-- Admin School Year -->
        <router-link v-if="is_admin" tag="li" to="/admin/school-year" class="menu" @click.native="toggleMobileMenu">
          <a class="dropdown-toggle">
            <div class="">
              <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              <span>{{ $t('School Year') }}</span>
            </div>
          </a>
        </router-link>
        <!-- Admin Assign Subject and Section -->
        <router-link v-if="is_admin" tag="li" to="/admin/assign" class="menu" @click.native="toggleMobileMenu">
          <a class="dropdown-toggle">
            <div class="">
              <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="12" y1="18" x2="12" y2="12"></line>
                <line x1="9" y1="15" x2="15" y2="15"></line>
              </svg>
              <span>{{ $t('Assign') }}</span>
            </div>
          </a>
        </router-link>
        <!-- Instructor Assign Subject and Section -->
        <router-link v-if="is_instructor" tag="li" to="/instructor/assign" class="menu" @click.native="toggleMobileMenu">
          <a class="dropdown-toggle">
            <div class="">
              <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="12" y1="18" x2="12" y2="12"></line>
                <line x1="9" y1="15" x2="15" y2="15"></line>
              </svg>
              <span>{{ $t('Assign') }}</span>
            </div>
          </a>
        </router-link>
        <!-- Instructor Profile -->
        <router-link v-if="is_instructor" tag="li" to="/instructor/profile" class="menu" @click.native="toggleMobileMenu">
          <a class="dropdown-toggle">
            <div class="">
              <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              <span>{{ $t('Profile') }}</span>
            </div>
          </a>
        </router-link>
      </perfect-scrollbar>
    </nav>
  </div>
  <!--  END SIDEBAR  -->
</template>
<script>
export default {
  data() {
    return {
      menu_collapse: 'dashboard',
      is_admin: '',
      is_instructor: '',
    };
  },
  computed: {
    sectionID() {
      return this.$route.params.id;
    },
  },
  watch: {
    $route(to) {
      const selector = document.querySelector('#sidebar a[href="' + to.path + '"]');
      if (selector != null) {
        const ul = selector.closest('ul.collapse');
        if (!ul) {
          const ele = document.querySelector('.dropdown-toggle.not-collapsed');
          if (ele) {
            ele.click();
          }
        }
      }
    },
  },

  mounted() {
    // Force set role after refresh
    this.$http
      .get('/api/user/role', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
      })
      .then((response) => {
        this.is_admin = response.data.role == 'admin' ? true : false;
        this.is_instructor = response.data.role == 'instructor' ? true : false;
        localStorage.setItem('role', response.data.role);
      })
      .catch((errors) => {
        console.log(errors);
      });

    // default menu selection on refresh
    const selector = document.querySelector('#sidebar a[href="' + window.location.pathname + '"]');
    if (selector) {
      const ul = selector.closest('ul.collapse');
      if (ul) {
        let ele = ul.closest('li.menu').querySelectorAll('.dropdown-toggle');
        if (ele) {
          ele = ele[0];
          setTimeout(() => {
            ele.click();
          });
        }
      } else {
        selector.click();
      }
    }
  },

  methods: {
    toggleMobileMenu() {
      if (window.innerWidth < 991) {
        this.$store.commit('toggleSideBar', true);
      }
    },
  },
};
</script>
