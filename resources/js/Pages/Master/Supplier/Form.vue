<template>
    <form style="color:black">
        <div class="form-group">
            <label>Supplier *</label>
            <input type="text" v-model="form.id" class="form-control" style="display:none"> 
            <input v-model="form.supplier" type="text" class="form-control" :class="{'is-invalid' : errors.supplier}">
             <div class="invalid-feedback">
                  {{errors.supplier ? errors.supplier[0] : '' }}
             </div>
        </div>
        <div class="form-group">
            <label>Phone *</label>
             <input type="text"  v-model="form.phone" class="form-control"  :class="{'is-invalid' : errors.phone}">
              <div class="invalid-feedback">
                  {{errors.phone ? errors.phone[0] : '' }}
             </div>
        </div>
         <div class="form-group">
            <label>Address *</label>
             <input type="text"  v-model="form.address" class="form-control"  :class="{'is-invalid' : errors.address}">
              <div class="invalid-feedback">
                  {{errors.address ? errors.address[0] : '' }}
             </div>
        </div>
</form>
</template>
<script>
import { mapState } from 'vuex';
export default {
    computed:{
        ...mapState({
            form : state => state.masterSupplier.form,
            errors : state => state.masterSupplier.errors
        })
    }
}
</script>