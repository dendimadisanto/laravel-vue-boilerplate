<template>
     <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
        <sideBar></sideBar>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->

        <navigasi></navigasi>
       
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">  
            <router-view></router-view>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

</template>
<script>
import nav from '../components/layout/navbar';
import sideBar from '../components/layout/sidebar';
export default {
    data(){
      return{
        isLogin:'false',
        form : {
            username:'',
            password:''
        }
      } 
    },
    components:{
       'navigasi' : nav,
       sideBar,
    },
    methods:{
      login(){
          $('#modal-login').modal('show');
      },
      doLogin(){
          axios.post('/do-login', this.form, App.request).then(response=>{
            if(response.data.success){
                   Swal.fire(
                  'Success',
                  response.data.msg,
                  'success'
                  );
                  localStorage.setItem('user', response.data.result);
                 $('#modal-login').modal('hide');
              }
          })
      }
    }
}
</script>