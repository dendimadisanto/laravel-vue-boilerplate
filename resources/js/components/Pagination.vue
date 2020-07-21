<template>
    <div class="pagination">
            {{ counter }}
            <nav aria-label="Page navigation example">
            <ul class="pagination" >
                 <li class="page-item" :class="currentPage == 1 ? 'disabled' : ''">
                    <span class="page-link">Previous</span>
                </li>
                <li @click="loadData(index + startNumber)" class="page-item" :class="currentPage == index + startNumber ? 'active' : '' "  v-for="(value, index) in (endNumber-startNumber) + 1"><a class="page-link" href="#">{{index + startNumber}}</a>
                </li>
                <li class="page-item" :class="currentPage == jumlahPage ? 'disabled' : ''">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
            </nav>
        </div>
</template>
<script>
import { mapState} from 'vuex'
export default {
       computed: 
       {
        ...mapState({
            jumlahPage:state => state.Pagination.jumlahPage,
            currentPage:state => state.Pagination.currentPage,
            endNumber:state => state.Pagination.endNumber,
            startNumber:state => state.Pagination.startNumber,
            per_page:state => state.Pagination.per_page,
            Page: state => state.Pagination.page
        }),
        counter() {
        return this.$store.getters['Pagination/getCounter']
        }
    },
    methods:{
        loadData(page){
            this.$store.commit('Pagination/setLoadPage', page);
        }
    }
}
</script>