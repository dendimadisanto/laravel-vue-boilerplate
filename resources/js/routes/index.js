import Map from '../components/Map.vue';
import Supplier from '../Pages/Master/Supplier/Main';
// membuat router
const routes = [
    {
        name: 'map',
        path: '/',
        component: Map
    },
    {
        name: 'Suppliers',
        path: '/supplier',
        component: Supplier
    },
]

  

export default routes;