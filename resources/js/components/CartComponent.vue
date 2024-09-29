<template>
  <div class="cart-area">
    <!-- First Row: Logo on the left, Link icons on the right -->
    <div class="header-row">
      <div class="logo">
        <img src="/path-to-logo/logo.png" alt="Shop Logo" />
      </div>
      <div class="link-icons">
        <a href="/dashboard" class="icon-link">
          <i class="fas fa-home"></i>
        </a>
        <a href="/sales-report" class="icon-link">
          <i class="fas fa-receipt"></i>
        </a>
        <a href="/current-user" class="icon-link">
          <i class="fas fa-user"></i>
        </a>
      </div>
    </div>

    <!-- Add the modal component and pass the necessary props -->
    <CustomerForm :showModal="showCustomerForm" :closeModal="closeCustomerModal" :onCustomerAdded="fetchCustomers" />

    <!-- Second Row: Select Customer and Add User -->
    <div class="customer-row">
      <!-- Search Input (moved above the select) -->
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search Customers"
        class="customer-search"
      />
      
      <select class="customer-select">
        <option v-for="customer in filteredCustomers" :key="customer.id">{{ customer.name }}</option>
      </select>
      <button class="add-user-btn" @click="showCustomerForm = true">
        <i class="fas fa-user-plus"></i>
      </button>
    </div>

    <!-- Scrollable Cart Area -->
    <div class="cart-table-container">
      <table v-if="cart.length" class="table">
        <thead>
          <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in cart" :key="item.id">
            <td>{{ item.product_name }}</td>
            <td>Ksh {{ item.selling_price }}</td>
            <td>
              <div class="qty-controls">
                <button class="qty-btn" @click="decreaseQty(item)">-</button>
                <span>{{ item.quantity }}</span>
                <button class="qty-btn" @click="increaseQty(item)">+</button>
              </div>
            </td>
            <td>Ksh {{ item.selling_price * item.quantity }}</td>
            <td>
              <button class="remove-btn" @click="removeFromCart(item.id)">X</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-else>
        <h2>Your Cart Is Empty</h2>
      </div>
    </div>

    <!-- Cart Total and Actions -->
    <div class="cart-total">
      <strong>Total Payable: Ksh {{ cartTotal }}</strong>
    </div>

    <div class="cart-actions">
      <button class="btn action-btn reset-btn" @click="resetCart">Reset</button>
      <button class="btn action-btn pay-btn">Pay Now</button>
      <button class="btn action-btn draft-btn">Save as Draft</button>
    </div>
  </div>
</template>


<script setup>
import CustomerForm from './CustomerForm.vue'; // Import the modal component
import { computed, ref, onMounted } from 'vue'; // Import necessary Vue functions
import axios from 'axios'; // Import Axios for API calls
import { useCartStore } from "./stores/cart"; // Import cart store

// Track modal visibility
const showCustomerForm = ref(false); 
const searchInputVisible = ref(false); // Track visibility of the search input
const searchQuery = ref(''); // Holds the search input
const customers = ref([]); // Initialize customers as an empty array

// Access the cart store
const cartStore = useCartStore(); 
const cart = computed(() => cartStore.cart); // Computed property for the cart

const cartTotal = computed(() =>
  cartStore.cart.reduce(
    (total, item) => total + item.selling_price * item.quantity,
    0
  )
);

// Fetch customers from the API using Axios
const fetchCustomers = async () => {
  try {
    const response = await axios.get('/api/pos/customers'); // Replace with the actual API endpoint
    customers.value = response.data;
  } catch (error) {
    console.error('Error fetching customers:', error);
  }
};

// Fetch customers when the component is mounted
onMounted(() => {
  fetchCustomers();
});

// Close modal function
const closeCustomerModal = () => {
  showCustomerForm.value = false;
};

// Cart item logic
const removeFromCart = (id) => {
  cartStore.removeFromCart(id);
};




const increaseQty = (item) => {
  cartStore.updateQuantity(item.id, item.quantity + 1);
};

const decreaseQty = (item) => {
  if (item.quantity > 1) {
    cartStore.updateQuantity(item.id, item.quantity - 1);
  }
};

const resetCart = () => {
  cartStore.resetCart();
};

// Toggle visibility of the search input
const toggleSearchInput = () => {
  searchInputVisible.value = !searchInputVisible.value;
};

// Computed property for filtered customers
const filteredCustomers = computed(() => {
  return customers.value.filter(customer => 
    customer.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

console.log(cartStore.updateQuantity); // Should log the function

</script>

<style scoped>

.cart-table-container {
  max-height: 350px;
  overflow-y: auto;
  margin-bottom: 20px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
  background-color: #fff;
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table th {
  padding: 15px;
  background-color: #f4f4f4;
  text-align: left;
  font-weight: bold;
  color: #333;
  border-bottom: 2px solid #e0e0e0;
}

.table td {
  padding: 15px;
  border-bottom: 1px solid #e0e0e0;
  color: #555;
}

.table tbody tr:hover {
  background-color: #f9f9f9;
}

/* Quantity controls */
.qty-controls {
  display: flex;
  align-items: center;
}

.qty-btn {
  width: 30px;
  height: 30px;
  background-color: #f0f0f0;
  border: none;
  color: #333;
  font-size: 18px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  border-radius: 50%;
  transition: background-color 0.3s ease;
}

.qty-btn:hover {
  background-color: #d4d4d4;
}

/* Remove button */
.remove-btn {
  background-color: #ff4d4f;
  color: white;
  border: none;
  padding: 8px 10px;
  border-radius: 50%;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.remove-btn:hover {
  background-color: #ff7875;
}

/* Cart Total */
.cart-total {
  text-align: center;
  margin-top: 20px;
  font-size: 1.2em;
  color: white;
  background-color: #4caf50;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Action buttons: Reset, Pay, Draft */
.cart-actions {
  display: flex;
  justify-content: space-between;
  gap: 10px;
  margin-top: 20px;
}

.action-btn {
  width: 100%;
  padding: 12px;
  font-size: 1rem;
  border: none;
  border-radius: 25px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  color: white;
}

.reset-btn {
  background-color: #ff9800;
}

.reset-btn:hover {
  background-color: #ffa726;
}

.pay-btn {
  background-color: #4caf50;
}

.pay-btn:hover {
  background-color: #66bb6a;
}

.draft-btn {
  background-color: #03a9f4;
}

.draft-btn:hover {
  background-color: #29b6f6;
}

/* General button hover effects */
.action-btn:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.header-row,
.customer-row {
  display: flex;
  justify-content: space-between; /* Space out elements */
  align-items: center; /* Align vertically */
  background-color: #f8f9fa; /* Light background for contrast */
  padding: 15px 20px; /* Padding for spacing */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
  border-radius: 8px; /* Rounded corners for modern look */
  margin-bottom: 20px; /* Space between rows */
}

/* Logo Styling */
.logo img {
  height: 50px;
  object-fit: contain;
}

/* Icon links in header-row */
.link-icons a {
  margin-left: 20px;
  font-size: 24px;
  color: #333;
  text-decoration: none;
  transition: color 0.3s ease;
}

.link-icons a:hover {
  color: #007bff; /* Hover effect for links */
}

/* Customer-row Styling */
.customer-search {
  flex-grow: 2; /* Make search take up more space */
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 15px;
}

.customer-select {
  flex-grow: 1; /* Flex to adapt to screen size */
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 10px;
}

/* Add User Button */
.add-user-btn {
  background-color: #28a745; /* Green background */
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  display: flex;
  align-items: center;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.add-user-btn i {
  margin-right: 5px;
}

.add-user-btn:hover {
  background-color: #218838; /* Darker green on hover */
}


</style>
