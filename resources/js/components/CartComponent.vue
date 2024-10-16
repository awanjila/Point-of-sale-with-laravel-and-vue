<template>
  <div class="cart-container">
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
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in cart"
            :key="item.id"
          >
            <td>{{ item.product_name }}</td>
            <td>{{ item.quantity }}</td>
            <td>Ksh {{ item.selling_price }}</td>
            <td>
              <button @click="removeItem(item.id)" class="btn no-bg-btn">
                <i class="fas fa-trash"></i> <!-- Red bin icon -->
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Cart Summary -->
    <div class="cart-summary-container">
      <div class="cart-summary">
        <p>Total Items: {{ totalItems }}</p>
        <p class="total-price">Total Price: Ksh {{ totalPrice }}</p>
      </div>
    </div>

    <!-- Button Container -->
    <div class="button-container">
      <button @click="resetCart" class="btn btn-warning">Reset</button>
      <button @click="openPaymentModal" class="btn btn-success">Pay Now</button>
      <button @click="holdDraft" class="btn btn-info">Hold Draft</button>
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
</script>

<style scoped>
/* General Cart Layout */
.cart-container {
  display: flex;
  flex-direction: column;
  height: 100vh;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

/* Customer search area */
.customer-search {
  margin-bottom: 10px;
}

/* Cart Items Container */
.cart-items-container {
  flex-grow: 1;
  overflow-y: auto;
  background-color: #fff;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  margin-bottom: 10px;
  max-height: calc(90vh - 250px); /* Ensure the container doesn't push down the cart summary and buttons */
}

.cart-items {
  width: 100%;
  table-layout: fixed;
}

/* Cart item size adjustment */
.cart-items th,
.cart-items td {
  padding: 5px 10px;
  font-size: 14px;
}

/* Cart Summary */
.cart-summary-container {
  padding: 15px;
  background-color: #f0f8ff;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  margin-bottom: 10px;
}

.cart-summary p {
  margin: 0;
  line-height: 1.5;
}

.total-price {
  font-size: 22px;
  color: #28a745;
  font-weight: bold;
}

/* Button container with fixed positioning */
.button-container {
  display: flex;
  justify-content: space-between;
  padding: 10px 0;
  background-color: #f8f9fa;
  border-top: 1px solid #ddd;
  position: sticky;
  bottom: 0;
  left: 0;
  right: 0;
}

/* Button styles */
.btn {
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 16px;
  color: white;
  flex: 1;
  margin: 0 5px;
}

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
</style>
