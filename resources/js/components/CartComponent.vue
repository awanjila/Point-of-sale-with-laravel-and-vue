<template>
  <div class="cart-area">
    <h2>Your Cart</h2>
    <table v-if="cart.length" class="table">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in cart" :key="item.id" :class="index % 2 === 0 ? 'table-light' : 'table-white'">
          <td class="product-name">{{ item.product_name }}</td>
          <td>Ksh {{ item.selling_price }}</td>
          <td>
            <div class="qty-controls">
              <button @click="decreaseQty(item)" class="btn btn-sm qty-btn">-</button>
              <span class="mx-2">{{ item.quantity }}</span>
              <button @click="increaseQty(item)" class="btn btn-sm qty-btn">+</button>
            </div>
          </td>
          <td>
            <button @click="removeFromCart(item.id)" class="btn btn-sm remove-btn">❌</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-else>Your cart is empty</div>

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
import { computed } from 'vue';
import { useCartStore } from './stores/cart';

const cartStore = useCartStore();
const cart = computed(() => cartStore.cart);

const cartTotal = computed(() =>
  cartStore.cart.reduce((total, item) => total + item.selling_price * item.quantity, 0)
);

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
</script>

<style scoped>
.cart-area {
  padding: 20px;
}

/* Ensure the table content is inline */
.table td {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Quantity buttons */
.qty-controls {
  display: flex;
  align-items: center;
}

.qty-btn {
  width: 25px;
  height: 25px;
  line-height: 1;
  padding: 0;
  border-radius: 50%;
}

/* Remove button (red X) */
.remove-btn {
  background-color: red;
  color: white;
  border: none;
}

/* No hover effect */
.btn {
  background-color: initial;
  color: white;
}

/* Remove hover effects */
.btn:hover {
  background-color: initial;
  color: white;
}

/* Rounded and smaller buttons */
.action-btn {
  border-radius: 25px;
  padding: 5px 15px;
  font-size: 0.9rem;
}

.reset-btn {
  background-color: orange;
}

.pay-btn {
  background-color: green;
}

.draft-btn {
  background-color: blue;
}

.cart-total {
  text-align: center;
  margin-top: 20px;
  font-size: 1.2em;
  color: white;
  background-color: olive;
  padding: 10px;
  border-radius: 5px;
}

.cart-actions {
  margin-top: 20px;
  display: flex;
  justify-content: space-around;
}
</style>
