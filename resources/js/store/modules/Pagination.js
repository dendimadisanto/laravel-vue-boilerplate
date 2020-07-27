import { result } from "lodash";

const state = () => ({
    jumlahPage:0,
    currentPage:1,
    endNumber:0,
    startNumber:0,
    per_page:0,
    path:'',
    page:1
  })
  
  // getters
  const getters = {
    getPage: state => {
        return state.page
    }
  }
  
  // actions
  const actions = {}
  
  // mutations
  const mutations = {
    setPagging (state, data) {
    let params = {};
      params.jumlahPage = Math.ceil(data.total/data.per_page);
      params.currentPage = data.current_page;
      params.startNumber = (params.currentPage > 3) ? params.currentPage - 3 : 1 ;
      params.endNumber = (params.currentPage < (params.jumlahPage-3)) ? params.currentPage + 3 : params.jumlahPage;
      params.per_page = data.per_page;
      params.path = data.path;
      Object.assign(state, params);
    },
    setLoadPage(state, page){
       state.page = page;
    }
  }
  
  export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
  }