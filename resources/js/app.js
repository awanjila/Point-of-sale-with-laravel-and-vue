/**
 * First, we will load all of this project's JavaScript dependencies, which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

// Import Pinia and the persistence plugin
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';

// Initialize Pinia and use persisted state
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

// Import Vue components
import Products from './components/ProductsComponent.vue';
import Cart from './components/CartComponent.vue';
import PosDashboard from './components/PosDashboard.vue'

// Create Vue app and register components
const app = createApp({
    components: {
        Products,
        Cart,  // Corrected component name (Carts -> Cart)
        PosDashboard,
    }
});

// Use Pinia as the store in your Vue app
app.use(pinia);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Uncomment if you want auto-registration for components
// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

// Mount the Vue application
app.mount('#app');
