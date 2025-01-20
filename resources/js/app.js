// Load JavaScript dependencies
import './bootstrap';
import { createApp } from 'vue';
import '@fortawesome/fontawesome-free/css/all.css';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

// FontAwesome
import { library } from '@fortawesome/fontawesome-svg-core';
import { faPrint, faTimes } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faPrint, faTimes);

// Pinia for state management
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

// Vue Components
import Products from './components/ProductsComponent.vue';
import ProductsImages from './components/ProductsImagesComponent.vue';
import Cart from './components/CartComponent.vue';
import PosDashboard from './components/PosDashboard.vue';
import PinLoginComponent from './components/PinLoginComponent.vue';
import SettingsComponent from './components/SettingsComponent.vue';
import PaymentSummaryTable from './components/PaymentSummaryTable.vue';
import AddPurchaseComponent from './components/purchase/AddPurchaseComponent.vue';
import PurchaseListComponent from './components/purchase/PurchaseListComponent.vue';
import ViewPurchaseComponent from './components/purchase/ViewPurchaseComponent.vue';
import OrderListComponent from './components/order/OrderListComponent.vue';
import ViewOrderComponent from './components/order/ViewOrderComponent.vue';
import NotFoundComponent from './components/errors/NotFoundComponent.vue';
import AccessDeniedComponent from './components/errors/AccessDeniedComponent.vue';
import SalesReportComponent from './components/sales/SalesReportComponent.vue';
import PurchaseReportComponent from './components/purchase/PurchaseReportComponent.vue';
import AddSalesComponent from './components/sales/AddSalesComponent.vue';

// Create Vue app
const app = createApp({
    components: {
        Products,
        ProductsImages,
        Cart,
        PosDashboard,
        PinLoginComponent,
        SettingsComponent,
        PaymentSummaryTable,
        AddPurchaseComponent,
        PurchaseListComponent,
        ViewPurchaseComponent,
        OrderListComponent,
        ViewOrderComponent,
        NotFoundComponent,
        AccessDeniedComponent,
        SalesReportComponent,
        PurchaseReportComponent,
        AddSalesComponent
    }
});

// Register Global Components
app.component('font-awesome-icon', FontAwesomeIcon);
app.use(pinia);
app.use(Toast, {
    position: "top-right",
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
});

// Mount the Vue app
app.mount('#app');

// Axios Configuration
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.warn('CSRF token not found. Requests might fail.');
}
