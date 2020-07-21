<template>
    <div class="content">
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="fullPage"></loading>
        
        <div class="toolbar" style="margin:2rem">
            <div class="action" style="text-align: right;">
                <button v-on:click="add" type="button" class="btn btn-secondary">Tambah</button>
                <button @click="ubah" type="button" class="btn btn-secondary">Ubah</button>
                <button @click="hapus" type="button" class="btn btn-secondary">Hapus</button>
            </div>
        </div>
        <div class="table">
            <ag-grid-vue style="width: 100%;height: 400px;"
            class="ag-theme-alpine"
            :columnDefs="columnDefs"
            :rowData="rowData"
            @grid-ready="onGridReady"
            rowSelection="single"
            >
         </ag-grid-vue>
        </div>
        <div class="pagination">
            <nav aria-label="Page navigation example">
            <ul class="pagination" >
                 <li class="page-item" :class="currentPage == 1 ? 'disabled' : ''">
                    <span class="page-link">Previous</span>
                </li>
                <li @click="loadData(index + startNumber)" class="page-item" :class="currentPage == index + startNumber ? 'active' : '' "  v-for="(value, index) in (endNumber-startNumber) + 1"><a class="page-link" href="#">{{index + startNumber}}</a>
                </li>
                <li class="page-item" :class="currentPage == jumlahPage ? 'disabled' : ''">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
            </nav>
        </div>
    </div>
   
     
</template>
<script>
import { AgGridVue } from 'ag-grid-vue';
import Form from './Form';
import Loading from 'vue-loading-overlay';
export default {
    data() {
        return {
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            idEdit:0,
            isLoading:false,
            fullPage: true,
            jumlahPage:0,
            currentPage:1,
            endNumber:0,
            startNumber:0,
            per_page:0,
        }
    },
    components: {
        Loading,
        AgGridVue,
        'form-dana':Form,
    },
    mounted() {
       
    },
    beforeMount() {
        this.columnDefs = [
            {headerName: 'id', field: 'id', hide:true},
            {
                headerName: 'No',
                maxWidth: 100,
                valueGetter: params => {
                   return params.data.no + ((this.currentPage - 1) * this.per_page );
                },
            },
            {headerName: 'Nama Kegiatan', field: 'kegiatan',resizable: true, flex:500},
             {headerName: 'Sumber Dana id', field: 'sumber_dana.id', hide:true},
            {headerName: 'Sumber Dana', field: 'sumber_dana.nama', width:200,resizable: true},
            {headerName: 'Anggaran', field: 'anggaran', width:200,resizable: true},
            {headerName: 'volume', field: 'volume', width:200,resizable: true},
            {headerName: 'Pelaksana', field: 'pelaksana', width:200,resizable: true},
            {headerName: 'Tahun', field: 'tahun', width:200,resizable: true},
        ];
            this.loadData(this.currentPage);
    },
    methods:{
        hapus() {
             const selected = this.gridApi.getSelectedRows();
             if(selected.length == 0){
                 Swal.fire('Informasi', 'Pilih data dahulu', 'info');
                 return;
             }
             let id =  selected[0].id;
  
              Swal.fire({
                    title: 'Are you sure?',
                    text: "Data yang di hapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                    }).then((result) => {
                    if (result.value) {
                        axios.get(`/hapus-kegiatan/${id}`, App.request).then(response=>{
                            if(response.data.success){
                                 Swal.fire(
                                'Deleted!',
                                response.data.msg,
                                'success'
                                )
                                this.loadData(this.currentPage);
                            }
                        }).catch(error =>{
                             Swal.fire('Informasi', 'Ada Kesalahan Server' ,'error');
                        })
                       
                    }
                    })
            },
        onGridReady(params) {
                this.gridApi = params.api;
                this.columnApi = params.columnApi;
            },
        add(){
            this.idEdit = 0;
            let params = {};
            params.id = 0;
            params.title = 'Tambah Data Kegiatan';
            let data = btoa(JSON.stringify(params));
            this.$router.push({name: 'form_kegiatan', params: {id: data}} );
        },
         store(){
           this.$refs.form.simpan();
        },
        loadData(page){
            this.isLoading = true;
             axios.get('/get-kegiatan-fisik?page='+page,App.request).then(response=>{
                 if(response.data.success){
                    let data = response.data.result
                    this.rowData = data.data;
                    this.jumlahPage = Math.ceil(data.total/data.per_page);
                    this.currentPage = data.current_page;
                    this.startNumber = (this.currentPage > 3) ? this.currentPage - 3 : 1 ;
                    this.endNumber = (this.currentPage < (this.jumlahPage-3)) ? this.currentPage + 3 : this.jumlahPage;
                    this.per_page = data.per_page;
                    this.isLoading = false;
                 }
             }).catch(error=>{
                Swal.fire('Informasi', 'Ada Kesalahan Server' ,'error');
                this.isLoading = false;
                console.log(error);
             })
        },
        ubah(){
            const selected = this.gridApi.getSelectedRows();
            if(selected.length == 0){
                Swal.fire('Informasi', 'Pilih data dahulu', 'info');
                return;
            }
            let params = {};
            params.id = selected[0].id;
            params.title = 'Edit Data Kegiatan';
            let data = btoa(JSON.stringify(params));
            this.$router.push({name: 'form_kegiatan', params: {id: data}} );
            
        }
    }
}
</script>