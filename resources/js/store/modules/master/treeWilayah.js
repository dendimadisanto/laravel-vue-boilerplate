import { apiTreeWilayah } from '../../../Services';

const state = () => ({
  isLoading:false,
   inital:
     {
       id:'0',
       text:'INDONESIA',
       children:[],
       level:0
     },
   data:[],
   children:[],
   modal:false,
   selected:[],
   form:{
     id:0,
     parent_id:'',
     nama:'',
     level:0,
   },
   Initform:{
    id:0,
    parent_id:'',
    nama:'',
    level:0
  },
   errors:[],
  nodeParent:{
    id:'0',
    text:'INDONESIA',
    children:[],
    level:0
  },
})

// getters
const getters = {}

// actions
const actions = {
    get({ commit, state }, payload) {
      commit('setLoading', true);
      return new Promise((resolve, reject) => {
          let params= {};
          params.id = payload.id;
          params.level = payload.level;
          apiTreeWilayah.get(params).then(response=>{
              if(response.success){
                commit('setLoading', false);
                  if(payload != ''){
                    commit('setChildren', response.result);
                  }
                  else{
                    commit('setData', response.result);
                  }
                resolve(response);
              }
          }).catch(error =>{
            commit('setLoading', false);
            reject(error);
          });
        })
    },
    save( { commit, state} ){
        commit('setError', []);
        return new Promise ((resolve, reject) => {
         apiTreeWilayah.save(state.form).then(res =>{
                if(res.success){
                  commit('setModal', false);
                  resolve(state.selected[0]);
                }
          }).catch(error=>{
            if (error.response.status == 422){
              commit('setError',error.response.data.errors );
              reject(error.response.data.errors);
             }
             else{
               reject(error);
             }
          });
        })
       
    },
    del({ commit, state }, payload){
      return new Promise((resolve, reject)=>{
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
              let params = {};
              params.id = payload.id;
              params.level = payload.level;
              apiTreeWilayah.del(params).then(res=>{
                    if(res.success){
                      resolve(res);
                    }
                }).catch(err=>{
                  reject(err);
                })
          }
          })
      })
    },
    getById({ commit }, payload){
        let params = {};
        params.id = payload.id;
        apiTreeWilayah.getById(params).then(res=>{
              if(res.success){
                  commit('setForm', res.result);
                  commit('setModal', true);
              }
        })
    }
}

// mutations
const mutations = {
    setData(state, data){
      state.inital.children = data;
      state.data = [state.inital];
    },
    setChildren(state, data){
      state.children = data;
    },
    setError(state, value){
      state.errors = value;
    },
    setModal(state, value){
      state.modal = value;
      if(!value){
        Object.assign(state.form, state.Initform);
      }
    },
    setSelected(state, value){
      state.selected = [value];
      state.form.parent_id = value.id;
      state.form.level = value.level;
    },
    saveNodeParent(state, value){
      state.nodeParent = value;
      console.log(value)
      if(value == undefined){
        state.nodeParent = state.inital
      }
    },
    setForm(state, value){
        Object.assign(state.form, value);
    },
    setLoading( state, value){
      state.isLoading = value;
    }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}