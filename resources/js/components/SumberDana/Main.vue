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
            rowHeight=200
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
         <div class="modal" tabindex="-1" role="dialog" aria-modal="true" id="modal-dana">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sumber Dana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form-dana ref='form' :danaID="idEdit"></form-dana>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" @click="store">Simpan</button>
            </div>
            </div>
        </div>
        </div>
    </div>
   
     
</template>
<script>
import { AgGridVue } from 'ag-grid-vue';
import Form from './FormAdd';
import Loading from 'vue-loading-overlay';
import Paginate from 'vuejs-paginate'
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
            per_page:0
        }
    },
    components: {
        Loading,
        AgGridVue,
        'form-dana':Form,
        'paginate':Paginate
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
            {headerName: 'Sumber Dana', field: 'nama',resizable: true, flex:1},
            {headerName: 'Icon', field: 'icon', width:400,resizable: true,
            cellRenderer: function(params) {
                return '<span class="rag-element"><img src="/upload/marker/'+params.value+'" style="height: 100%;width: 200px;"></span>';
                },
            },
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
                        axios.get(App.baseURL + `/hapus-dana/${id}`,App.request).then(response=>{
                            if(response.data.success){
                                 Swal.fire(
                                'Deleted!',
                                response.data.msg,
                                'success'
                                )
                                this.loadData();
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
            this.$refs.form.resetFile();
            $('#modal-dana').modal('show');
        },
         store(){
           this.$refs.form.simpan();
        },
        loadData(page){
            this.isLoading = true;
             axios.get(App.baseURL + '/get-sumber-dana?page='+page,App.request).then(response=>{
                 if(response.data.success){
                    let data = response.data.data
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
            this.idEdit = selected[0].id;
            $('#modal-dana').modal('show');
        }
    }
}
</script>