<template>
  <div class="receipt-wrapper">
    <!-- Close button -->
    <button class="close-btn no-print" @click="$emit('close')">×</button>

    <div class="receipt-container" v-if="orderDetails && settings">
      <!-- Header Section -->
      <div class="receipt-header">
        <h1 class="company-name">{{ settings.business_name || 'Wabe Point' }}</h1>
        <p class="sub-header">Pos/Inventory System</p>
        <p>{{ settings.business_address || 'Parklands 3rd Avenue' }}</p>
        <p>TEL: {{ settings.business_phone || '0710909198, 0781312070' }}</p>
        <p v-if="settings.till_number">Till Number: {{ settings.till_number }}</p>
      </div>

      <!-- Receipt Info -->
      <div class="receipt-info">
        <div class="receipt-no">
          <strong>#{{ orderDetails.invoice_no }}</strong>
        </div>
        <div class="receipt-type">CASH SALE</div>
        <div class="receipt-details">
          <span>{{ orderDetails.order_date }}</span>
          <span>{{ orderDetails.customer ? orderDetails.customer.name : 'walk-in-customer' }}</span>
        </div>
      </div>

      <div class="divider"></div>

      <!-- Products Table Header -->
      <div class="products-header">
        <div class="product-name">Item</div>
        <div class="qty-price">Qty×Price</div>
        <div class="total">Total</div>
      </div>

      <!-- Products List -->
      <div class="products-list">
        <div v-for="item in orderDetails.cart" :key="item.product_name" class="product-item">
          <div class="product-name">{{ item.product_name }}</div>
          <div class="qty-price">{{ item.quantity }}×{{ Number(item.unit_cost).toFixed(2) }}</div>
          <div class="total">{{ Number(item.total).toFixed(2) }}</div>
        </div>
      </div>

      <div class="divider"></div>

      <!-- Summary Section -->
      <div class="summary-section">
        <div class="summary-row">
          <span>Tax ({{ settings.tax_percentage || '0.00' }}%)</span>
          <span>{{ Number(orderDetails.vat || 0).toFixed(2) }}</span>
        </div>
        <div class="summary-row">
          <span>Discount</span>
          <span>{{ Number(orderDetails.discount || 0).toFixed(2) }}</span>
        </div>
        <div class="summary-row total">
          <strong>Grand Total</strong>
          <strong>{{ Number(orderDetails.total).toFixed(2) }} {{ settings.currency || 'KES' }}</strong>
        </div>
      </div>

      <div class="divider"></div>

      <!-- Payment Info -->
      <div class="payment-info">
        <div class="payment-row">
          <span>Paid By</span>
          <span>{{ paymentMethod || orderDetails.payment_method || 'N/A' }}</span>
        </div>
        <div class="payment-row">
          <span>Amount Paid</span>
          <span>{{ Number(receivedAmount || orderDetails.amount_paid).toFixed(2) }}</span>
        </div>
        <div class="payment-row">
          <span>Change</span>
          <span>{{ Number(changeReturn || orderDetails.change_return).toFixed(2) }}</span>
        </div>
      </div>

      <div class="divider"></div>

      <!-- Receipt Header/Footer -->
      <div class="receipt-custom-text">
        <p v-if="settings.receipt_header" class="receipt-header-text">
          {{ settings.receipt_header }}
        </p>
      </div>

      <!-- Footer Section -->
      <div class="receipt-footer">
        <p class="served-by">Served by: {{ userData.name }}</p>
        <p class="thank-you">{{ settings.receipt_footer || 'Thank You For Shopping With Us' }}</p>
        <p class="footer-contact">System By: Wabe Point • {{ settings.business_phone || '0781312070' }}</p>
      </div>
    </div>

    <!-- Loading State -->
    <div v-else class="loading-state">
      <p>Loading receipt...</p>
    </div>

    <!-- Print Button -->
    <button class="print-btn no-print" @click="printReceipt">
      <i class="fa fa-print"></i> Print Receipt
    </button>
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
      required: true,
    },
    paymentMethod: {
      type: String,
      default: null
    },
    changeReturn: {
      type: [Number, String],
      default: null
    },
    receivedAmount: {
      type: [Number, String],
      default: null
    }
  },
  data() {
    return {
      orderDetails: null,
      settings: null
    };
  },
  mounted() {
    this.fetchOrderDetails();
    this.fetchSettings();
  },
  methods: {
    async fetchOrderDetails() {
      try {
        const response = await axios.get(`/api/order/${this.orderId}/details`);
        this.orderDetails = response.data;
      } catch (error) {
        console.error('Error fetching order details:', error);
      }
    },
    async fetchSettings() {
      try {
        const response = await axios.get('/api/settings');
        this.settings = response.data;
      } catch (error) {
        console.error('Error fetching settings:', error);
      }
    },
    printReceipt() {
      window.print();
    }
  }
};
</script>

<style scoped>
/* Receipt Wrapper */
.receipt-wrapper {
  position: relative;
  height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  background: #f5f5f5;
  padding: 20px 0;
}

/* Receipt Container */
.receipt-container {
  width: 80mm; /* Thermal printer width */
  background: white;
  padding: 10px;
  margin: 0 auto;
  overflow-y: auto;
  max-height: calc(100vh - 120px); /* Account for print button */
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Close Button */
.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #666;
  padding: 5px 10px;
}

.close-btn:hover {
  color: #333;
}

/* Print Button */
.print-btn {
  position: fixed;
  bottom: 20px;
  padding: 12px 24px;
  background: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.print-btn:hover {
  background: #45a049;
}

/* Header Styles */
.receipt-header {
  text-align: center;
  margin-bottom: 10px;
}

.company-name {
  font-size: 20px;
  font-weight: bold;
  margin: 0;
}

.sub-header {
  font-size: 12px;
  color: #666;
  margin: 4px 0;
}

/* Receipt Info */
.receipt-info {
  text-align: center;
  margin: 10px 0;
}

.receipt-no {
  font-size: 14px;
}

.receipt-type {
  font-weight: bold;
  margin: 5px 0;
}

/* Products Table */
.products-header {
  display: grid;
  grid-template-columns: 1.5fr 1fr 0.8fr;
  font-size: 12px;
  font-weight: bold;
  padding: 5px 0;
  border-bottom: 1px solid #eee;
}

.product-item {
  display: grid;
  grid-template-columns: 1.5fr 1fr 0.8fr;
  font-size: 12px;
  padding: 5px 0;
}

.product-name {
  padding-right: 5px;
}

/* Summary Section */
.summary-section, .payment-info {
  font-size: 12px;
}

.summary-row, .payment-row {
  display: flex;
  justify-content: space-between;
  padding: 3px 0;
}

.summary-row.total {
  font-size: 14px;
  font-weight: bold;
  margin-top: 5px;
}

/* Divider */
.divider {
  border-top: 1px dashed #ddd;
  margin: 8px 0;
}

/* Footer */
.receipt-footer {
  text-align: center;
  font-size: 12px;
  margin-top: 10px;
}

.thank-you {
  font-weight: bold;
  margin: 5px 0;
}

.footer-contact {
  font-size: 10px;
  color: #666;
}

/* Print-specific styles */
@media print {
  .no-print {
    display: none !important;
  }

  .receipt-wrapper {
    padding: 0;
    height: auto;
  }

  .receipt-container {
    box-shadow: none;
    max-height: none;
    width: 100%;
  }
}

.receipt-custom-text {
  text-align: center;
  margin: 10px 0;
  font-style: italic;
  color: #666;
}

.receipt-header-text {
  font-size: 0.9em;
}
</style>
