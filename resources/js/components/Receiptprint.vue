<template>
  <div class="receipt-container" v-if="orderDetails">
    <h3 class="text-center">Receipt</h3>

    <div class="text-center">
        <h1 class="title"><strong>Wabe Point</strong></h1>
        <span>Pos/Inventory System</span>
        <h3>Parklands 3rd Avenue</h3>
        <p>TEL: 0710909198, 0781312070</p>
        <p>info@wabestudio.co.ke</p>
        <p><strong>Receipt No:</strong> {{ orderDetails.invoice_no }}</p>
        <h1>CASH SALE</h1>
        <p><strong>Date:</strong> {{ orderDetails.order_date }}</p>
        <p><strong>Customer:</strong> {{ orderDetails.customer ? orderDetails.customer.name : 'walk-in-customer' }}</p>
    </div>

    <hr class="dotted-line" />

    <!-- Products Table -->
    <div v-for="item in orderDetails.cart" :key="item.product_name" class="product-item">
      <p>{{ item.product_name }}</p>
      <p>{{ item.quantity }} x {{ Number(item.unit_cost).toFixed(2) }} 
        <span class="total">{{ Number(item.total).toFixed(2) }}</span>
      </p>
      <hr class="dotted-line" />
    </div>

    <!-- Summary -->
    <p><strong>Order Tax:</strong> Ksh {{ Number(orderDetails.vat).toFixed(2) }} ({{ orderDetails.vat || '0.00' }}%)</p>
    <p><strong>Discount:</strong> Ksh {{ Number(orderDetails.discount).toFixed(2) }}</p>
    <p><strong>Grand Total:</strong> Ksh {{ Number(orderDetails.total).toFixed(2) }}</p>

    <hr class="dotted-line" />

    <!-- Payment Details -->
    <div class="payment-details">
      <p><strong>Paid By:</strong> {{ orderDetails.payment_method || 'N/A' }}</p>
      <p><strong>Amount:</strong> Ksh {{ Number(orderDetails.amount_paid).toFixed(2) }}</p>
      <p><strong>Change Return:</strong> Ksh {{ Number(orderDetails.change_return).toFixed(2) }}</p>
    </div>

    <hr class="dotted-line" />

    <!-- Served By -->
    <p><strong>You were served by:</strong> {{ userData && userData.name ? userData.name : 'Unknown' }}</p>

    <!-- Thank You Note -->
    <p class="thank-you">Thank You For Shopping With Us. Please Come Again.</p>
    <div class="footer">System By: <p class="small-print">Wabe Point: 0781312070</p></div>

    <!-- Print and Close Buttons -->
    <button class="print-button" @click="printReceipt"><i class="fa fa-print"></i> Print</button>
    <button @click="$emit('close')">Close</button>
  </div>
  <div v-else>
    <p>Loading order details...</p>
  </div>
</template>

<script>
import axios from 'axios';
import { useCartStore } from './stores/cart';

export default {
  props: {
    orderId: {
      type: Number,
      required: true,
    },
    userData: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      orderDetails: null,
      loading: true,
      error: null,
    };
  },
  created() {
    this.fetchOrderDetails();
  },
  methods: {
    async fetchOrderDetails() {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.get(`/api/order/${this.orderId}/details`);
        if (response.data && response.data.success) {
          this.orderDetails = response.data.data;
          // Clear the cart after successfully loading the order details
          const cartStore = useCartStore();
          cartStore.clearCart();
        } else {
          this.error = 'Failed to load order details.';
          console.error('Error fetching order details:', response.data.message);
        }
      } catch (error) {
        this.error = 'An error occurred while fetching the order details.';
        console.error('Error fetching order details:', error);
      } finally {
        this.loading = false;
      }
    },
    printReceipt() {
      window.print();
    },
  },
};
</script>

<style scoped>
/* Style for the receipt layout */
.receipt-container {
  font-family: 'Lato', sans-serif;
  width: 80mm;
}

/* Dotted line style */
.dotted-line {
  border-top: 1px dotted #000;
  margin: 8px 0;
}

/* Dotted border style for the product table */
.product-item {
  padding: 4px 0;
}

/* Footer and thank-you message */
.footer, .thank-you {
  margin-top: 20px;
  font-size: 12px;
  text-align: center;
}

/* Print and close button styling */
button {
  margin-top: 10px;
  width: 100%;
  font-size: 14px;
}

.print-button {
  background-color: #4CAF50;
  color: white;
  border: none;
}

button:hover {
  opacity: 0.8;
}

/* Small print text style */
.small-print {
  font-size: 10px;
}
</style>
