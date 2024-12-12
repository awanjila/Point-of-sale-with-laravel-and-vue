<template>
    <tr>
      <td>{{ item.product_name }}</td>
      <td>Ksh {{ item.selling_price }}</td>
      <td>
        <div class="qty-controls">
          <button class="qty-btn" @click="decreaseQty">-</button>
          <span>{{ item.quantity }}</span>
          <button class="qty-btn" @click="increaseQty">+</button>
        </div>
      </td>
      <td>Ksh {{ item.selling_price * item.quantity }}</td>
      <td><button class="remove-btn" @click="removeItem">X</button></td>
    </tr>
  </template>
  
  <script>
  export default {
    props: {
      item: Object, // Item data passed from parent
    },
    methods: {
      increaseQty() {
        this.$emit('increaseQty', this.item); // Emit action to parent
      },
      decreaseQty() {
        this.$emit('decreaseQty', this.item);
      },
      removeItem() {
        this.$emit('removeItem', this.item.id);
      },
    },
  };
  </script>
  