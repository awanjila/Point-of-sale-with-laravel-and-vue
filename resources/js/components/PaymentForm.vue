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

    <!-- Customer Form Modal -->
    <CustomerForm
      :showModal="showCustomerForm"
      @closeModal="closeCustomerModal"
      @customerAdded="fetchCustomers"
    />

    <!-- Second Row: Select Customer and Add User -->
    <div class="customer-row">
      <!-- Search Input -->
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search Customers"
        class="customer-search"
      />
      <select class="customer-select">
        <option v-for="customer in filteredCustomers" :key="customer.id">
          {{ customer.name }}
        </option>
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

    <!-- Cart Summary -->
    <div class="cart-summary">
      <!-- Total Products -->
      <div class="cart-total-products">
        <strong>Total Products: {{ totalProducts }}</strong>
      </div>

      <!-- Total Payable -->
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
import { ref } from 'vue';

const receivedPayment = ref('');
const payingAmount = ref('');
const changeToReturn = ref('');
const paymentMethod = ref('cash');
const salesNotes = ref('');
</script>

<style scoped>
.payment-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000; /* Make sure it's on top */
}

.payment-form {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  max-width: 600px;
  width: 100%;
  display: flex;
  justify-content: space-between;
  gap: 20px;
}

.payment-column {
  flex: 1;
}

.payment-input {
  margin-bottom: 20px;
}

.form-control {
  width: 100%;
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.submit-btn {
  width: 100%;
  padding: 12px;
  font-size: 1rem;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.submit-btn:disabled {
  background-color: #ccc;
}
</style>
