// stores/cart.js
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useCartStore = defineStore('cart', () => {
  const cart = ref([]);

  const addToCart = (product) => {
    const existingProduct = cart.value.find((item) => item.id === product.id);
    if (existingProduct) {
      existingProduct.quantity += 1;
    } else {
      cart.value.push({ ...product, quantity: 1 });
    }
  };

  const updateQuantity = (productId, newQuantity) => {
    const product = cart.value.find((item) => item.id === productId);
    if (product) {
      product.quantity = newQuantity;
    }
  };

  const removeFromCart = (productId) => {
    cart.value = cart.value.filter((item) => item.id !== productId);
  };

  const clearCart = () => {
    cart.value = [];
  };

  return {
    cart,
    addToCart,
    updateQuantity, // Ensure this is returned from the store
    removeFromCart,
    clearCart,
  };
});
