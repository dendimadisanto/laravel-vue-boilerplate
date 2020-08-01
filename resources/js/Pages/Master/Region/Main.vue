<template>
    <div>
       
    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-6">
            <h5> Region </h5>
        </div>
        <div class="col-md-6">
             <div class="bar float-right" >
                <button class="btn btn-primary" type="button" @click="showModal" style="margin-right:5px" data-toggle="tooltip" title="Add Region">
                    <i class="fas fa-plus fa-sm"></i>
                </button>
                <button class="btn btn-primary" type="button" @click="edit" style="margin-right:5px" title="Edit Region">
                    <i class="fas fa-pen fa-sm"></i>
                </button>
                <button class="btn btn-primary" type="button" @click="deleted" title="Delete Region">
                    <i class="fas fa-trash fa-sm"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="panel" style="max-height:450px;overflow:auto;background-color:white"> 
        <Tree ref="tree_wil"></Tree>
    </div>

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
                 <form style="color:black">
                        <div class="form-group">
                            <label>Nama *</label>
                            <input type="text" v-model="form.id" class="form-control" style="display:none"> 
                            <input type="text" v-model="form.parent_id" class="form-control" style="display:none"> 
                            <input v-model="form.nama" type="text" class="form-control" :class="{'is-invalid' : errors.nama}">
                            <div class="invalid-feedback">
                                {{errors.nama ? errors.nama[0] : '' }}
                            </div>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="hideModal">Batal</button>
                <button type="button" class="btn btn-primary" @click="simpan">Simpan</button>
            </div>
            </div>
        </div>
        </div>

  </div>
</template>
<script>
import Tree from './Tree';
import { mapState } from 'vuex';

export default {
    data(){
        return{
            title:'',
            isLoading: false
        }
    },
    components:{
        Tree
    },
    computed:{
        ...mapState({
            modal : state=> state.TreeWilayah.modal,
            selected: state => state.TreeWilayah.selected,
            form : state => state.TreeWilayah.form,
            errors : state => state.TreeWilayah.errors
        })
    },
    methods:{
        showModal(){
           let data = this.selected;
           let title = "Tambah" ;
           if(data.length == 0){
               Swal.fire('Information', 'Pilih Data dahulu !', 'info');
               return;
           }
           switch(data[0].level){
               case 0 :
                   title += " Provinsi";
                   break;
                case 1 :
                   title += " Kabupaten / Kota";
                   break;
                case 2 :
                   title += " Kecamatan";
                   break;
                case 3 :
                   title += " Desa";
                   break;
           }
           this.title = title;
           this.$store.commit('TreeWilayah/setModal', true);
        },
        hideModal(){
           this.title = 'Add Supplier';
           this.$store.commit('TreeWilayah/setModal', false);
        },
        simpan(){
            this.$store.dispatch('TreeWilayah/save').then(data => {
                this.$refs.tree_wil.reloadNodes('parent').then(res=>{
                    if(res){
                         Swal.fire('Information', "Berhasil Disimpan", 'success');
                    }
                });
                
            }).catch(error=>{
                  if (error.response.status == 422){
                      Swal.fire('Information', "Something wrong", 'error');
                  }
                 console.log(error);
                 
            })
        },
        edit(){
           let data = this.selected;
           this.title = "Edit" ;
           if(data.length == 0){
               Swal.fire('Information', 'Pilih Data dahulu !', 'info');
               return;
           }
            this.$store.dispatch('TreeWilayah/getById', data[0]);
        },
        deleted(){
           setTimeout(function(){
               let data = this.selected;
                let title = "Tambah" ;
                if(data.length == 0){
                    Swal.fire('Information', 'Pilih Data dahulu !', 'info');
                    return;
                }
                this.$store.dispatch('TreeWilayah/del', data[0]).then(res =>{
                    this.$refs.tree_wil.reloadNodes('parent').then(response=>{
                        if(response){
                            Swal.fire('Information', res.msg, 'success');
                        }
                    });
                        
                }).catch(error=>{
                        Swal.fire('Information', "Something wrong", 'error');
                });
           }.bind(this),500)
           
        }
    }
}
</script>