<template>
  <div class="layout-px-spacing">
    <portal to="breadcrumb">
      <ul class="navbar-nav flex-row">
        <li>
          <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span>Admin - Subject List</span>
                </li>
              </ol>
            </nav>
          </div>
        </li>
      </ul>
    </portal>

    <div class="row layout-top-spacing">
      <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="panel br-4">
          <div class="panel-body">
            <h6>Hey I am the subject page!</h6>
            <p class="mb-0 mt-3">
              With CORK starter kit, you can begin your work without any hassle.
              The starter page is highly optimized which gives you freedom to
              start with minimal code and add only the desired components and
              plugins required for your project.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.layout-px-spacing {
  min-height: calc(100vh - 170px) !important;
}
</style>
<script>
export default {
  metaInfo: { title: "Admin" },
  mounted() {
    // Force set role after refresh
    this.$http.get('/api/user/role',{
    headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
    }).then((response) =>{
        localStorage.setItem('role',response.data.role);
        if(localStorage.getItem('role')!='admin'){
        this.$router.push({ name: 'Home'});
    }
    }).catch((errors) =>{
        console.log(errors);
    })
  },
  methods: {},
};
</script>
