<template>
    <div class="container">
      <div class="row">
        <!-- Products Section (Left Side) -->
        <div class="col-md-8">
          <Products />
        </div>
        
        <!-- Cart Section (Right Side) -->
        <div class="col-md-4">
          <Cart />
        </div>
      </div>
    </div>
  </template>
  

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
