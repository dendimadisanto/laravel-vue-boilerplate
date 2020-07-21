<template>
  <div class="content">
    <div class="counter"> {{counter}} </div>
    <button @click="increment" class="increment"> Tambah </button>
    <button @click="decrement" class="decrement"> Kurangi </button>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
export default {
  methods: {
    increment() {
      this.$store.commit('masterSupplier/increment')
    },
    decrement() {
      this.$store.commit('masterSupplier/decrement')
    }
  }, 
  computed: {
    ...mapState({
      counter: state => state.masterSupplier.count
    })
  }
}
</script>