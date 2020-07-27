<template>
  <div>
      <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :is-full-page="true"></loading>
    <div class="panel" style="max-height:450px;overflow:auto"> 
       <Tree id="tree_wil" :data="data" @nodeExpand="onNodeExpand($event)" @selectionChange="onSelected($event)"></Tree>
    </div>
  </div>
</template>
 
<script>
import { mapState } from 'vuex';
import Loading from 'vue-loading-overlay';
export default {
  created() {
      this.getNodes('');
  },
  components:{
    Loading
  },
  methods: {
    onSelected(event){
      this.$store.commit('TreeWilayah/setSelected', event);
      this.$store.commit('TreeWilayah/saveNodeParent', event.parent);
    },
    onNodeExpand(event) {
      let node = event;
      if (!node.children) {
        let getData = this.getNodes(node);
        getData.then(res =>{
           this.$set(node, "children", this.children);
        })
      }
    },
    reloadNodes(event) {
      let node = event;
      if(node == 'parent'){
        node = this.parent;
      }
      let getData = this.getNodes(node);
        getData.then(res =>{
           this.$set(node, "children", this.children);
        })
        
    },
    async getNodes(node) {
        let promise = await new Promise((resolve, reject) => {
            this.$store.dispatch('TreeWilayah/get', node).then(res =>{
                resolve(res)
            }).catch(error =>{
              reject(error);
            });
        });

        return promise;
        
    }
  },
  computed:{
      ...mapState({
          data: state => state.TreeWilayah.data,
          children: state => state.TreeWilayah.children,
          parent: state => state.TreeWilayah.nodeParent,
          isLoading: state => state.TreeWilayah.isLoading
      })
  }
};
</script>