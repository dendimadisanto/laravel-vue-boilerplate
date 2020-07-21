<template>
    <div>
         <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="true"></loading>
        <Head @showModal="showModal"></Head>
          <div class="table grid">
            <ag-grid-vue style="width: 100%;height: 400px;"
            class="ag-theme-alpine"
            :columnDefs="columnDefs"
            :rowData="rowData"
            @grid-ready="onGridReady"
            rowSelection="single"
             @cellClicked="onCellClicked"
            >
         </ag-grid-vue>
        </div>
        <Pagination/></Pagination>

      <div class="modal" :class="modal ? 'show' : 'hide'" tabindex="-1" role="dialog" aria-modal="true" id="modal-dana">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="hideModal">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <Form></Form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="hideModal">Batal</button>
                <button type="button" class="btn btn-primary" @click="save">Simpan</button>
            </div>
            </div>
        </div>
        </div>

         
    </div>
</template>
<script>
import Head from '../../../components/headContent';
import Pagination from '../../../components/Pagination';
import Modal from '../../../components/Modal';
import Form from './Form';
import { AgGridVue } from 'ag-grid-vue';
import Loading from 'vue-loading-overlay';
import { mapState} from 'vuex'

export default {
    data(){
        return {
            columnDefs : [],
            title : ''
        }
    },
    components:{
        Head,
         Loading,
        AgGridVue,
        Pagination,
        Form,
        Modal
    },
    beforeMount() {
        this.columnDefs = [
            {headerName: 'Supplier', field: 'supplier', sortable: true,resizable:true, },
            {headerName: 'Phone', field: 'phone', sortable: true,resizable:true },
            {headerName: 'Address', field: 'address', sortable: true,resizable:true, flex:1},
            {headerName: '', field: 'id', sortable: true,resizable:true, tipe:'edit', width:60,
                cellRenderer: function(params) {
                return '<span> <i class="fas fa-pen fa-fw pointer">';
                },
            },
            {headerName: '', field: 'id', sortable: true,resizable:true, tipe:'delete', width:60,
                cellRenderer: function(params) {
                return '<span> <i class="fas fa-trash fa-fw pointer">';
                },
            },
        ];
        this.loadData(this.Page);
    },
    computed: 
    {
        ...mapState({
            rowData: state => state.masterSupplier.data.data,
            Page: state => state.Pagination.page,
            isLoading : state => state.masterSupplier.isLoading,
            modal : state => state.masterSupplier.modal
        }),
    },
   methods:{
       loadData(page){
           this.$store.dispatch('masterSupplier/getSupplier', page);
       },
       onGridReady(params) {
                this.gridApi = params.api;
                this.columnApi = params.columnApi;
        },
        onCellClicked(params){
            if(params.colDef.tipe){
               
               switch(params.colDef.tipe){
                   case 'edit' :
                    this.title = 'Edit Supplier';
                    this.$store.dispatch('masterSupplier/getById', params.value);
                    break;
                   case 'delete' :
                       alert('a');
                    break;
               }
            }
         },
        showModal(){
           this.title = 'Add Supplier';
           this.$store.commit('masterSupplier/setModal', true);
           this.$store.commit('masterSupplier/resetForm');
        },
        hideModal(){
           this.$store.commit('masterSupplier/setModal', false);
        },
        save(){
            this.$store.dispatch('masterSupplier/save');
        }
   },
   watch: {
    Page: function (val) {
       this.loadData(val);
    },
  }
}
</script>