<template>
  <div class="container pos-dashboard">
    <div class="row justify-content-between">
      <!-- Products Section (Left Side) -->
      <div class="col-md-7 product-container shadow-sm p-3 mb-5 bg-white rounded">
        <Products />
      </div>
      
      <!-- Cart Section (Right Side) -->
      <div class="col-md-5 cart-container shadow-sm p-3 mb-5 bg-white rounded mx-auto">
        <Cart />
      </div>
    </div>
  </div>
</template>

<script>
import Products from '../components/ProductsComponent.vue';
import Cart from '../components/CartComponent.vue';

export default {
  components: {
    Products,
    Cart,
  },
};
</script>

<style scoped>
.pos-dashboard {
  margin-top: 20px;
}

/* Center the cart */
.cart-container {
  padding: 15px;
  margin-right: auto;
  margin-left: auto;
  text-align: center;
  background-color: #f9f9f9;
  border-radius: 10px;
}

.product-container {
  padding: 15px;
  background-color: #f9f9f9;
  border-radius: 10px;
}
</style>
