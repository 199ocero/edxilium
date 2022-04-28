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
        <router-link
          tag="li"
          to="/"
          class="menu"
          @click.native="toggleMobileMenu"
        >
          <a class="dropdown-toggle">
            <div class="">
             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid" data-v-8d2239c6=""><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
              <span>{{ $t("dashboard") }}</span>
            </div>
          </a>
        </router-link>
        <!-- Admin Instructor -->
        <router-link
          tag="li"
          to="/admin/instructor"
          class="menu"
          @click.native="toggleMobileMenu"
        >
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
              <span>{{ $t("Instructor") }}</span>
            </div>
          </a>
        </router-link>
        <!-- Admin Section -->
        <router-link
          tag="li"
          to="/admin/section"
          class="menu"
          @click.native="toggleMobileMenu"
        >
          <a class="dropdown-toggle">
            <div class="">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home" data-v-8d2239c6=""><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
              <span>{{ $t("Section") }}</span>
            </div>
          </a>
        </router-link>
        <!-- Admin Subject -->
        <router-link
          tag="li"
          to="/admin/subject"
          class="menu"
          @click.native="toggleMobileMenu"
        >
          <a class="dropdown-toggle">
            <div class="">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book" data-v-8d2239c6=""><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
              <span>{{ $t("Subject") }}</span>
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
    return { menu_collapse: "dashboard" };
  },

  watch: {
    $route(to) {
      const selector = document.querySelector(
        '#sidebar a[href="' + to.path + '"]'
      );
      const ul = selector.closest("ul.collapse");
      if (!ul) {
        const ele = document.querySelector(".dropdown-toggle.not-collapsed");
        if (ele) {
          ele.click();
        }
      }
    },
  },

  mounted() {
    // default menu selection on refresh
    const selector = document.querySelector(
      '#sidebar a[href="' + window.location.pathname + '"]'
    );
    if (selector) {
      const ul = selector.closest("ul.collapse");
      if (ul) {
        let ele = ul.closest("li.menu").querySelectorAll(".dropdown-toggle");
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
        this.$store.commit("toggleSideBar", true);
      }
    },
  },
};
</script>
