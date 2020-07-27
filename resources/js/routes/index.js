import Map from '../components/Map.vue';
import Supplier from '../Pages/Master/Supplier/Main';
import Region from '../Pages/Master/Region/Main';
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
    {
        name: 'Region',
        path: '/region',
        component: Region
    },
]

  

export default routes;