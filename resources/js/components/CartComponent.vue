<template>
  <div class="cart-area">
    <h2>Your Cart</h2>
    <div v-if="cart.length === 0">Your cart is empty</div>
    <div v-else>
      <div v-for="item in cart" :key="item.id" class="cart-item">
        <span>{{ item.product_name }} (x{{ item.quantity }})</span>
        <button @click="removeFromCart(item.id)">Remove</button>
      </div>
      <div class="cart-total">
        <strong>Total: Ksh {{ cartTotal }}</strong>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from './stores/cart';

const cartStore = useCartStore();

// Computed properties for cart items and total
const cart = computed(() => cartStore.cart);
const cartTotal = computed(() =>
  cartStore.cart.reduce((total, item) => total + item.selling_price * item.quantity, 0)
);

const removeFromCart = (id) => {
  cartStore.removeFromCart(id);
};
</script>

<style scoped>
.cart-area {
  padding: 20px;
}
</style>
