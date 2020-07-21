<template>
    <form style="color:black">
        <div class="form-group">
            <label>Sumber Dana</label>
            <input type="text" v-model="form.id" class="form-control" style="display:none"> 
            <input v-model="form.sumber_dana" type="text" class="form-control" :class="{'is-invalid' : errors.sumber_dana}">
            <input v-model="form.icon" type="text" class="form-control" style="display:none">
             <div class="invalid-feedback">
                  {{errors.sumber_dana ? errors.sumber_dana[0] : '' }}
             </div>
        </div>
        <div class="form-group">
            <label>Upload Icon</label>
             <input type="file" ref="fileInput" class="form-control-file form-control" @change='uploadPhoto' :class="{'is-invalid' : errors.file}">
              <div class="invalid-feedback">
                  {{errors.file ? errors.file[0] : '' }}
             </div>
        </div>
</form>
</template>
<script>
export default {
    data(){
        return {
            form:{
                sumber_dana:'',
                icon:'',
                id:0,
                file:''
            },
            initialForm:{
                sumber_dana:'',
                icon:'',
                id:0,
                file:''
            },
            errors:[]
        }
    },
    props:{
        danaID:{
            required:true
        }
    },
    watch:{
        danaID(newid){
           if(newid==0){
               Object.assign(this.form,this.initialForm);
               return;
           }
           this.getById(newid);
        }
    },
    methods:{
          simpan(){
            this.errors = [];
            let formData = new FormData();
            formData.append('file', this.form.file);
            formData.append('sumber_dana', this.form.sumber_dana);
            formData.append('id', this.form.id);
            formData.append('icon', this.form.icon);
           
            App.request.headers = {... App.request.headers,...{'Content-Type': 'multipart/form-data'}};
            axios.post('/add-sumber-dana', formData, App.request)
            .then(response=>{
               if(response.data.success){
                   $('#modal-dana').modal('hide');
                   Swal.fire('Informasi', response.data.msg ,'success');
                   this.$parent.loadData();
               }
            })
            .catch(error =>{
                if (error.response.status == 422){
                this.errors = error.response.data.errors;
                console.log(this.errors);
                }
            });
        },
         uploadPhoto(e){
              let file = e.target.files[0];
              this.form.file = file;
        },
        resetFile(){
             this.$refs.fileInput.value='';
        },
        getById(id){
            this.$refs.fileInput.value='';
            axios.get(App.baseURL + `/get-dana-byid/${id}`, App.request).then(response=>{
                if(response.data.success){
                    let params;
                    params = response.data.data;
                    params.sumber_dana = response.data.data.nama;
                    Object.assign(this.form, params);
                }
            }).catch()
        }

    }
}
</script>