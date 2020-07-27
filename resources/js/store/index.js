import Vue from 'vue'
import Vuex from 'vuex'
import masterSupplier from './modules/master/masterSupplier';
import Pagination from './modules/Pagination';
import TreeWilayah from './modules/master/treeWilayah';


Vue.use(Vuex)


export default new Vuex.Store({
  modules: {
    masterSupplier,
    Pagination,
    TreeWilayah
  }
})