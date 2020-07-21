import Vue from 'vue'
import Vuex from 'vuex'
import masterSupplier from './modules/master/masterSupplier';
import Pagination from './modules/Pagination';


Vue.use(Vuex)


export default new Vuex.Store({
  modules: {
    masterSupplier,
    Pagination
  }
})