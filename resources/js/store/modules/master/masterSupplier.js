const state = () => ({
      data : [],
      error: [],
      page:1,
      isLoading : false,
      form:{
        supplier:'',
        id:0,
        alamat:'',
        phone:''
    },
    InitialForm:{
      supplier:'',
      id:0,
      alamat:'',
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
      axios.get(App.baseURL + '/get-supplier?page=' + payload,App.request).then(response=>{
        commit('setData', response.data.result);
        commit('Pagination/setPagging', response.data.result, { root: true });
        commit('setLoading', false)
      }).catch(error=>{
        commit('setLoading', true);
        Swal.fire('Information', 'Something Wrong', 'info');
      });
    },
    save({ commit, state, dispatch, rootState }){
       commit('setError', []);
       axios.post(App.baseURL + '/saveSupplier', state.form ,App.request ).then(response=>{
            if(response.data.success){
              Swal.fire('Information', response.data.msg, 'info');
              dispatch('getSupplier', rootState.Pagination.page);
              commit('setModal', false);
              commit('setForm', state.InitialForm);
            }
       }).catch(error => {
        if (error.response.status == 422){
              commit('setError',error.response.data.errors );
          }
       })
    },
    getById({ commit }, payload){
      axios.post(App.baseURL + '/getSupplierById', {id:payload}, App.request).then(response =>{
        if(response.data.success){
          commit('setForm', response.data.result);
          commit('setModal', true);
        }
      }).catch(error=>{
        Swal.fire('Information', 'Something Wrong', 'info');
      });
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
      state.form = state.InitialForm;
    }
  }
  
  export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
  }