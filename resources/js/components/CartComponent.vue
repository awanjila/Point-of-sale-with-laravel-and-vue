<template>
  <div class="cart-container">
    <div class="cart-content">
      <!-- Customer Dropdown with Search -->
      <div class="customer-search">
        <input
          type="text"
          v-model="customerSearch"
          placeholder="Search customers..."
          class="form-control"
        />

        <!-- Customer Dropdown -->
        <select v-model="activeCustomer" class="form-select">
          <option 
            v-for="customer in filteredCustomers" 
            :key="customer.id" 
            :value="customer"
          >
            {{ customer.name }}
          </option>
        </select>

        <!-- Display Selected Customer -->
        <!-- <div v-if="activeCustomer">
          <h4>Selected Customer: {{ activeCustomer.name }}</h4>
        </div> -->
      </div>

      <!-- Cart Items Table -->
      <div class="cart-items-container">
        <table class="table cart-items">
          <thead>
            <tr>
              <th class="text-center">Product Name</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Price</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in cart"
              :key="item.id"
            >
              <td class="product-name-cell text-truncate">
                {{ item.product_name.charAt(0).toUpperCase() + item.product_name.slice(1).toLowerCase() }}
              </td>
              <td>
                <div class="quantity-control">
                  <button 
                    class="qty-btn" 
                    @click="decreaseQuantity(item)"
                    :disabled="item.quantity <= 1"
                  >
                    <i class="fas fa-minus"></i>
                  </button>
                  <input 
                    type="number" 
                    v-model.number="item.quantity" 
                    class="qty-input"
                    min="1"
                    @change="updateQuantity(item)"
                  />
                  <button 
                    class="qty-btn"
                    @click="increaseQuantity(item)"
                  >
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </td>
              <td class="text-center">Ksh {{ (item.selling_price * item.quantity).toLocaleString() }}.00</td>
              <td class="text-center">
                <button @click="removeItem(item.id)" class="btn no-bg-btn">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Fixed bottom section -->
    <div class="fixed-bottom-section">
      <!-- Cart Summary -->
      <div class="cart-summary-container">
        <div class="cart-summary">
          <div class="summary-item">
            <span class="summary-label">Total Items</span>
            <span class="summary-value">{{ totalItems }}</span>
          </div>
          <div class="summary-divider"></div>
          <div class="summary-item total">
            <span class="summary-label">Total Amount</span>
            <span class="summary-value">Ksh {{ totalPrice.toLocaleString() }}.00</span>
          </div>
        </div>
      </div>

      <!-- Button Container -->
      <div class="button-container">
        <button @click="resetCart" class="btn btn-warning">Reset</button>
        <button @click="openPaymentModal" class="btn btn-success">Pay</button>
        <button @click="holdDraft" class="btn btn-info">Hold</button>
      </div>
    </div>

    
    <!-- Payment Modal -->
<!-- Pass the customer, total items, and total price to PaymentForm -->
<PaymentForm 
  :showModal="isPaymentModalOpen" 
  @closeModal="isPaymentModalOpen = false"
  :activeCustomer="activeCustomer"
  :totalItems="totalItems"
  :totalPrice="totalPrice"
  :userData="userData"
/>
    
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useCartStore } from './stores/cart'; // Cart store import
import PaymentForm from './PaymentForm.vue'; // Import the PaymentForm component

defineProps({
  userData: {
    type: Object,
    required: true,
  },
});

// ----- Cart State and Logic -----
const cartStore = useCartStore();
const isPaymentModalOpen = ref(false); // Modal visibility

// Cart data
const cart = computed(() => cartStore.cart);
const totalItems = computed(() =>
  cart.value.reduce((total, item) => total + item.quantity, 0)
);
const totalPrice = computed(() =>
  cart.value.reduce((total, item) => total + item.selling_price * item.quantity, 0)
);

// Remove item from cart
const removeItem = (itemId) => {
  cartStore.removeFromCart(itemId);
};

// Reset cart
const resetCart = () => {
  cartStore.clearCart();
};


// Pay Now Button Functionality
const openPaymentModal = () => {
  isPaymentModalOpen.value = true; // Show the payment modal
};

// Hold Draft Functionality
const holdDraft = () => {
  alert("Draft has been held.");
};

// ----- Customer Search and Selection -----
const customerSearch = ref(''); // Search query for customers
const customers = ref([]); // List of customers
const activeCustomer = ref(null); // Currently active customer

// Fetch customers from API
const fetchCustomers = async () => {
  try {
    const response = await axios.get('/api/pos/customers');
    customers.value = response.data;

    // Set the first customer as active by default
    if (customers.value.length > 0) {
      activeCustomer.value = customers.value[0];
    }
  } catch (error) {
    console.error('Failed to load customers:', error);
  }
};

// Filter customers based on search input
const filteredCustomers = computed(() => {
  if (!customerSearch.value) return customers.value;
  return customers.value.filter((customer) =>
    customer.name.toLowerCase().includes(customerSearch.value.toLowerCase())
  );
});

// Fetch customers on component mount
onMounted(() => {
  fetchCustomers();
});

// Add these new methods for quantity control
const updateQuantity = (item) => {
  if (item.quantity < 1) item.quantity = 1;
  cartStore.updateItemQuantity(item.id, item.quantity);
};

const increaseQuantity = (item) => {
  item.quantity++;
  cartStore.updateItemQuantity(item.id, item.quantity);
};

const decreaseQuantity = (item) => {
  if (item.quantity > 1) {
    item.quantity--;
    cartStore.updateItemQuantity(item.id, item.quantity);
  }
};
</script>

<style scoped>
/* General Cart Layout */
.cart-container {
  display: flex;
  flex-direction: column;
  height: 100vh;
  background-color: #f8f9fa;
  position: relative;
  width: 100%;
  overflow: hidden; /* Prevent content from spilling out */
}

.cart-content {
  flex: 1;
  overflow-y: auto;
  padding: 10px 20px;
  padding-bottom: 200px; /* Space for fixed bottom section */
  height: calc(100vh - 200px); /* Adjust height to account for fixed section */
}

/* Customer search area */
.customer-search {
  margin-bottom: 5px;
}

/* Cart Items Container */
.cart-items-container {
  background-color: #fff;
  padding: 5px 10px;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  margin-bottom: 5px;
  overflow-y: auto;
  max-height: calc(100vh - 420px); /* Adjusted to show scroll after ~11 items */
}

.cart-items {
  width: 100%;
  table-layout: fixed;
}

/* Cart item size adjustment */
.cart-items th,
.cart-items td {
  padding: 8px 6px;
  font-size: 0.8rem;
}

/* Fixed bottom section containing summary and buttons */
.fixed-bottom-section {
  position: absolute; /* Change from fixed to absolute */
  bottom: 0;
  left: 0;
  right: 0;
  background-color: #f8f9fa;
  border-top: 1px solid #ddd;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
  z-index: 1000;
  width: 100%; /* Use 100% instead of inherit */
}

/* Cart Summary */
.cart-summary-container {
  padding: 10px 20px;
  background-color: #fff;
  margin: 0;
  border-bottom: 1px solid #eee;
}

.cart-summary {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.summary-item {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.summary-label {
  font-size: 1rem;
  color: #666;
}

.summary-value {
  font-weight: 600;
  color: #333;
}

.summary-divider {
  width: 100%;
  height: 1px;
  background-color: #eee;
}

.summary-item.total {
  margin-top: 5px;
}

.summary-item.total .summary-label {
  font-size: 1.2rem;
  font-weight: 600;
  color: #333;
}

.summary-item.total .summary-value {
  font-size: 1.8rem;
  font-weight: 700;
  color: #c02323;
}

/* Button container */
.button-container {
  display: flex;
  justify-content: space-between;
  padding: 10px 20px;
  background-color: #fff;
}

/* Update button styles */
.btn {
  padding: 12px 20px;
  border-radius: 5px;
  font-size: 16px;
  color: white;
  flex: 1;
  margin: 0 5px;
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Button styles */
.btn-warning {
  background-color: #ffc107;
}

.btn-success {
  background-color: #28a745;
}

.btn-info {
  background-color: #17a2b8;
}

.no-bg-btn {
  background: none;
  border: none;
  color: #dc3545; /* Red color for bin icon */
  cursor: pointer;
  padding: 0;
  font-size: 16px;
}

/* Styling for Font Awesome icons */
.no-bg-btn i {
  margin-right: 0;
  font-size: 18px;
}

/* Add these new styles for quantity controls */
.quantity-control {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
}

.qty-btn {
  width: 24px;
  height: 24px;
  border: 1px solid #ddd;
  background-color: #f8f9fa;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.qty-btn:hover:not(:disabled) {
  background-color: #e9ecef;
}

.qty-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.qty-btn i {
  font-size: 12px;
  color: #666;
}

.qty-input {
  width: 50px;
  height: 24px;
  text-align: center;
  border: 1px solid #ddd;
  border-radius: 4px;
  -moz-appearance: textfield;
}

.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Adjust the table cell padding for better alignment */
.cart-items td {
  vertical-align: middle;
  padding: 8px 6px;
}

/* Add these styles for the table headers */
.cart-items th {
  font-weight: 600;
  color: #333;
  background-color: #f8f9fa;
  border-bottom: 2px solid #dee2e6;
  text-transform: uppercase;
  font-size: 0.8rem;
  padding: 8px 6px;
}

/* Update the table cell styles */
.cart-items td {
  vertical-align: middle;
  padding: 8px 6px;
}

/* Center align text utility class */
.text-center {
  text-align: center !important;
}

/* Product name cell styling */
.product-name-cell {
  max-width: 200px; /* Adjust based on your needs */
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: 0.85rem; /* Smaller font size */
  padding-right: 10px !important;
}

/* Add text-truncate utility class if not already present */
.text-truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>
