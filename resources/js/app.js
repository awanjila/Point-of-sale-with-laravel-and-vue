// Load the project's JavaScript dependencies (Vue and other libraries)
import './bootstrap';  // Assuming this file loads Axios and other global dependencies
import { createApp } from 'vue';
import '@fortawesome/fontawesome-free/css/all.css';  // FontAwesome icons
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css'; // Import Toast CSS

// Import FontAwesome library and icons
import { library } from '@fortawesome/fontawesome-svg-core';
import { faPrint, faTimes } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// Add FontAwesome icons to the library
library.add(faPrint, faTimes);

// Import Pinia and the persistence plugin for state management
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import 'toastr/build/toastr.min.css';

// Initialize Pinia store and apply the persisted state plugin
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

// Import Vue components
import Products from './components/ProductsComponent.vue';
import ProductsImages from './components/ProductsImagesComponent.vue';
import Cart from './components/CartComponent.vue';
import PosDashboard from './components/PosDashboard.vue';
import PinLoginComponent from './components/PinLoginComponent.vue';
import SettingsComponent from './components/SettingsComponent.vue';

// Export Vue and related libraries globally
// window.Vue = {
//   createApp,
//   ref,
//   reactive,
//   computed,
//   watch,
//   onMounted,
//   // Add other Vue 3 composition API methods as needed
// };

// Create the Vue application instance
const app = createApp({
  components: {
    Products,  // Registers the Products component
    ProductsImages,  // Registers the ProductsImages component
    Cart,      // Registers the Cart component
    PosDashboard,  // Registers the PosDashboard component
    PinLoginComponent,
    SettingsComponent,
  }
});

// Register FontAwesomeIcon component globally
app.component('font-awesome-icon', FontAwesomeIcon);

// Use Pinia store with Vue app
app.use(pinia);

// Use Toast plugin with Vue app
app.use(Toast);

// Mount the Vue app to the element with ID "app"
app.mount('#app');
