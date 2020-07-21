<template>
    <div class="head">
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <h5>{{  currentRouteName }}</h5>
                </div>
                <div class="col-md-6 col-xs-6">
                     <div class="float-right" style="display:flex">
                        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group ">
                            <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                            </div>
                        </form>
                        <div class="no-arrow d-sm-none" style="margin-left:10px">
                                <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        <div class="add-btn" style="margin-left:10px">
                                <button class="btn btn-primary" type="button" @click="showModal">
                                <i class="fas fa-plus fa-sm"></i>
                                </button>
                            </div>
                    </div>
                </div>
            </div>
           
        </div>
</template>
<script>
export default {
    computed: {
    currentRouteName() {
        return this.$route.name;
    }
},
methods:{
    showModal(){
        this.$emit('showModal');
    }
}
}
</script>