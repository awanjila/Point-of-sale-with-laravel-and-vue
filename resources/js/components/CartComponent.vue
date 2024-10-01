<template>
  <div class="cart-area">
    <!-- First Row: Logo on the left, Link icons on the right -->
    <div class="header-row">
      <div class="logo">
        <img src="/assets/images/logo-dark.png" alt="Shop Logo" />
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

    <!-- Customer Form Modal -->
    <CustomerForm
      :showModal="showCustomerForm"
      @closeModal="closeCustomerModal"
      @customerAdded="fetchCustomers"
    />

    <!-- Second Row: Select Customer and Add User -->
    <div class="customer-row">
      <!-- Toggleable Search Input -->
      <button class="toggle-search-btn" @click="toggleSearchInput">
        <i class="fas fa-search"></i>
      </button>
      <input
        v-if="searchInputVisible"
        type="text"
        v-model="searchQuery"
        placeholder="Search Customers"
        class="customer-search"
      />
      <select class="customer-select">
        <option value="" disabled selected>Select a Customer</option>
        <option v-for="customer in filteredCustomers" :key="customer.id">
          {{ customer.name }}
        </option>
      </select>
      <button class="add-user-btn" @click="showCustomerForm = true">
        <i class="fas fa-user-plus"></i>
      </button>
    </div>

    <!-- Cart Table Section -->
    <div class="cart-table-section">
  <div class="cart-table-container">
    <div class="table-wrapper">
      <!-- Add v-if on table -->
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

      <!-- Ensure v-else directly follows v-if -->
      <div v-else class="empty-cart">
        <h2>Your Cart Is Empty</h2>
        <button class="shop-btn">Shop Now</button>
      </div>
    </div>
  </div>
</div>


    <!-- Cart Summary -->
    <div class="cart-summary">
      <div class="cart-total-products">
        <strong>Total Products: {{ totalProducts }}</strong>
      </div>
      <div class="cart-total">
        <strong>Total Payable: Ksh {{ cartTotal }}</strong>
      </div>
    </div>

    <!-- Cart Actions -->
    <div class="cart-actions">
      <button class="btn action-btn reset-btn" @click="resetCart">Reset</button>
      <button
        class="btn action-btn pay-btn"
        :disabled="!cart.length"
        @click="showPaymentForm = true"
      >
        Pay Now
      </button>
      <button class="btn action-btn draft-btn">Save as Draft</button>
    </div>

    <!-- Payment Form Modal -->
    <PaymentForm v-if="showPaymentForm" :cartTotal="cartTotal" @close="closePaymentForm" />
  </div>
</template>



<script setup>
import CustomerForm from './CustomerForm.vue';
import { computed, ref, onMounted } from 'vue';
import axios from 'axios';
import { useCartStore } from './stores/cart';

const showCustomerForm = ref(false);
const searchInputVisible = ref(false);
const searchQuery = ref('');
const customers = ref([]);
const cartStore = useCartStore();
const cart = computed(() => cartStore.cart);

const cartTotal = computed(() =>
  cartStore.cart.reduce(
    (total, item) => total + item.selling_price * item.quantity,
    0
  )
);

// Computed property for total products
const totalProducts = computed(() =>
  cartStore.cart.reduce((total, item) => total + item.quantity, 0)
);

const fetchCustomers = async () => {
  try {
    const response = await axios.get('/api/pos/customers');
    customers.value = response.data;
  } catch (error) {
    console.error('Error fetching customers:', error);
  }
};

onMounted(() => {
  fetchCustomers();
});

const closeCustomerModal = () => {
  showCustomerForm.value = false;
};

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

// Toggle Search Input visibility
const toggleSearchInput = () => {
  searchInputVisible.value = !searchInputVisible.value;
};

// Computed property for filtered customers
const filteredCustomers = computed(() =>
  customers.value.filter((customer) =>
    customer.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
);
</script>



<style scoped>
/* Responsive Styling */
@media (max-width: 768px) {
  .cart-table-container {
    padding: 0;
  }

  .cart-summary, .cart-actions {
    flex-direction: column;
    align-items: center;
  }

  .table-wrapper {
    overflow-x: auto;
  }
}

/* Cart Table Section */
.cart-table-section {
  margin-top: 20px;
}

.cart-table-container {
  max-height: 400px;
  overflow-y: auto;
  margin-bottom: 20px;
}

.table-wrapper {
  overflow-x: auto;
  width: 100%;
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table th,
.table td {
  padding: 10px;
  border-bottom: 1px solid #ccc;
}

.qty-controls {
  display: flex;
  gap: 5px;
}

.qty-btn {
  background-color: #f0f0f0;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
  border-radius: 4px;
}

.remove-btn {
  background-color: red;
  color: white;
  border: none;
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
}

.cart-summary {
  margin-bottom: 20px;
}

/* Empty Cart Section */
.empty-cart {
  text-align: center;
}

.shop-btn {
  padding: 10px 20px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 10px;
}

.shop-btn:hover {
  opacity: 0.9;
}

/* Cart Actions styling */
.cart-actions {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.action-btn {
  padding: 15px 30px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  border: none;
  transition: all 0.3s ease;
  position: relative;
  z-index: 1;
  background-color: #c02323; /* Default red background */
  color: white;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  background-image: linear-gradient(to top, #c02323, #ff4d4d); /* Shiny effect */
}

.reset-btn {
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
}

.pay-btn {
  border-radius: 0; /* No rounded corners for middle button */
}

.draft-btn {
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
}

/* Shiny effect for buttons */
.action-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.3);
  z-index: -1;
  opacity: 0;
  border-radius: inherit;
  transition: opacity 0.3s ease;
}

.action-btn:hover::before {
  opacity: 1;
}

.action-btn:hover {
  background-color: #000;
}

.action-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

/* Shiny/glossy effect */
.action-btn {
  background: linear-gradient(145deg, #e63946, #f76c6c);
  border: none;
  color: white;
}

.action-btn:hover {
  background: linear-gradient(145deg, #000000, #343434); /* Black when hovered */
}

/* Customer Row */
.customer-row {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}

.toggle-search-btn {
  background-color: transparent;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #3498db;
}

.toggle-search-btn:hover {
  opacity: 0.7;
}

.customer-search {
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  flex: 1;
  transition: all 0.3s ease-in-out;
}

.customer-select {
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  flex: 1;
}

.add-user-btn {
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
}

/* Styling for the header-row */
.header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  background-color: #f7f7f7;
  border-bottom: 1px solid #ccc;
}

.header-row .logo img {
  height: 50px;
}

.header-row .link-icons a {
  margin-left: 15px;
  font-size: 1.5rem;
  color: #333;
}

.header-row .link-icons a:hover {
  color: #c02323;
}
</style>
