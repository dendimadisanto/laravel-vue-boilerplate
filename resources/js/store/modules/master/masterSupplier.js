import { apiSupplier } from '../../../Services';

const state = () => ({
      data : [],
      error: [],
      page:1,
      isLoading : false,
      form:{
        supplier:'',
        id:0,
        address:'',
        phone:''
    },
    InitialForm:{
      supplier:'',
      id:0,
      address:'',
      phone:''
  },
    errors :[],
    modal :false
  })
  
  // getters
  const getters = {}
  
  // actions
  const actions = {
    getSupplier ({ commit }, payload) {
      commit('setLoading', true);

      return new Promise((resolve, reject)=>{
          apiSupplier.get(payload).then(response=>{
            commit('setData', response.result);
            commit('Pagination/setPagging', response.result, { root: true });
            commit('setLoading', false);
            resolve(true);
          }).catch(error=>{
            commit('setLoading', true);
            reject(false);
          });
        })
   
    },
    save({ commit, state, dispatch, rootState }){
       commit('setError', []);
         apiSupplier.save(state.form).then(response=>{
            if(response.success){
              commit('setModal', false);
                commit('resetForm');
              dispatch('getSupplier', rootState.Pagination.page).then(res=>{
                if(res){
                  Swal.fire('Information', response.msg, 'success');
                }
              });
             
            }
       }).catch(error => {
        if (error.response.status == 422){
              commit('setError',error.response.data.errors );
          }
       })
    },
    getById({ commit }, payload){
      apiSupplier.getById(payload).then(response =>{
        if(response.success){
          commit('setForm', response.result);
          commit('setModal', true);
        }
      }).catch(error=>{
        Swal.fire('Information', 'Something Wrong', 'info');
      });
    },
    del({ dispatch, rootState }, payload){
      Swal.fire({
        title: 'Confirmation',
        text: "Are you certain want to delete ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
        }).then((result) => {
        if (result.value) {
          axios.post(App.baseURL + '/delSupplier', {id:payload}, App.request).then(response =>{
            if(response.data.success){
              Swal.fire('Information', response.data.msg, 'success');
              dispatch('getSupplier', rootState.Pagination.page);
            }
          }).catch(error=>{
            Swal.fire('Information', 'Something Wrong', 'info');
          });
           
        }
        })
     
    }
  }
  
  // mutations
  const mutations = {
    setData (state, data) {
      state.data = data;
    },
    setLoading (state, value) {
      state.isLoading = value;
    },
    setError(state, value){
      state.errors = value;
    },
    setModal(state, value){
      state.modal = value;
    },
    setForm(state, value){
        Object.assign(state.form, value);
    },
    resetForm(state){
      Object.assign(state.form, state.InitialForm);
    }
  }
  
  export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
  }