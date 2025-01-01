<template>
  <div class="receipt" ref="receipt">
    <div v-if="loading" class="receipt-loading">
      <div class="spinner"></div>
      <p>Generating Receipt...</p>
    </div>
    
    <div v-else-if="error" class="receipt-error">
      <p>{{ error }}</p>
      <button @click="$emit('close')">Close</button>
    </div>
    
    <div v-else class="receipt-content">
      <!-- Company Info -->
      <div class="company-info">
        <h2>{{ mergedUserData.company_name }}</h2>
        <p>{{ mergedUserData.address }}</p>
        <p>Tel: {{ mergedUserData.phone }}</p>
        <p>Email: {{ mergedUserData.email }}</p>
      </div>

      <!-- Receipt Details -->
      <div class="receipt-details">
        <p><strong>Receipt No:</strong> {{ orderId }}</p>
        <p><strong>Date:</strong> {{ currentDate }}</p>
        <p><strong>Payment Method:</strong> {{ paymentMethod }}</p>
      </div>

      <!-- Order Items -->
      <table class="items-table">
        <thead>
          <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in orderItems" :key="item.id">
            <td>{{ item.product?.product_name || item.name }}</td>
            <td>{{ item.quantity }}</td>
            <td>{{ formatPrice(item.unit_cost || item.unit_price) }}</td>
            <td>{{ formatPrice(item.total) }}</td>
          </tr>
        </tbody>
      </table>

      <!-- Totals -->
      <div class="totals">
        <p><strong>Subtotal:</strong> {{ formatPrice(subtotal) }}</p>
        <p><strong>VAT (16%):</strong> {{ formatPrice(vat) }}</p>
        <p><strong>Total:</strong> {{ formatPrice(total) }}</p>
        <p><strong>Amount Paid:</strong> {{ formatPrice(receivedAmount) }}</p>
        <p><strong>Change:</strong> {{ formatPrice(changeReturn) }}</p>
      </div>

      <!-- Footer -->
      <div class="receipt-footer">
        <p>Thank you for your business!</p>
        <p>{{ mergedUserData.footer_message }}</p>
      </div>
    </div>

    <!-- Print/Close Buttons -->
    <div v-if="!loading && !error" class="receipt-actions">
      <button @click="printReceipt" class="btn btn-primary">Print Receipt</button>
      <button @click="$emit('close')" class="btn btn-secondary">Close</button>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  props: {
    orderId: {
      type: [String, Number],
      required: true
    },
    userData: {
      type: Object,
      default: () => ({})
    },
    paymentMethod: {
      type: String,
      required: true
    },
    changeReturn: {
      type: [String, Number],
      required: true
    },
    receivedAmount: {
      type: [String, Number],
      required: true
    }
  },

  setup(props) {
    const orderItems = ref([]);
    const subtotal = ref(0);
    const vat = ref(0);
    const total = ref(0);
    const loading = ref(true);
    const error = ref(null);
    const currentDate = ref(new Date().toLocaleString());
    const companySettings = ref({});

    const fetchCompanySettings = async () => {
      try {
        const response = await axios.get('/api/settings');
        console.log('Settings response:', response.data);
        
        if (response.data.status === 'success') {
          companySettings.value = response.data.settings;
          console.log('Company settings:', companySettings.value);
        } else {
          console.error('Failed to fetch settings:', response.data);
        }
      } catch (err) {
        console.error('Failed to fetch company settings:', err);
      }
    };

    const fetchOrderDetails = async () => {
      try {
        loading.value = true;
        error.value = null;

        // Fetch company settings first
        await fetchCompanySettings();

        const response = await axios.get(`/api/orders/${props.orderId}`);
        
        if (response.data.status === 'success' && response.data.order) {
          const order = response.data.order;
          
          orderItems.value = order.order_details.map(detail => ({
            id: detail.id,
            name: detail.product?.product_name || 'Unknown Product',
            quantity: detail.quantity,
            unit_cost: parseFloat(detail.product?.selling_price || detail.unit_price || 0),
            total: parseFloat(detail.total)
          }));

          subtotal.value = parseFloat(order.sub_total);
          vat.value = parseFloat(order.vat);
          total.value = parseFloat(order.total);
        } else {
          throw new Error('Unable to retrieve order details');
        }
      } catch (err) {
        console.error('Failed to fetch order details:', err);
        error.value = 'Failed to load receipt. Please try again.';
      } finally {
        loading.value = false;
      }
    };

    const formatPrice = (price) => {
      return `Ksh ${parseFloat(price).toFixed(2)}`;
    };

    const printReceipt = () => {
      window.print();
    };

    onMounted(() => {
      fetchOrderDetails();
    });

    return {
      orderItems,
      subtotal,
      vat,
      total,
      loading,
      error,
      currentDate,
      formatPrice,
      printReceipt,
      companySettings
    };
  },

  computed: {
    mergedUserData() {
      return {
        company_name: this.companySettings.business_name || this.userData.company_name,
        address: this.companySettings.business_address || this.userData.address,
        phone: this.companySettings.business_phone || this.userData.phone,
        email: this.companySettings.business_email || this.userData.email,
        footer_message: this.companySettings.receipt_footer || 'Thank you for your business!'
      };
    }
  }
};
</script>

<style scoped>
.receipt-loading, .receipt-error {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 300px;
  text-align: center;
}

.spinner {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #c02323;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
  margin-bottom: 20px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.receipt {
  background: white;
  padding: 20px;
  max-width: 300px;
  margin: 0 auto;
  font-family: 'Courier New', monospace;
  display: flex;
  flex-direction: column;
  height: 80vh;
  max-height: 80vh;
  position: relative;
}

.receipt-content {
  flex-grow: 1;
  overflow-y: auto;
  padding-right: 10px;
}

.receipt-actions {
  position: sticky;
  bottom: 0;
  background: white;
  padding-top: 10px;
  border-top: 1px solid #eee;
  display: flex;
  gap: 10px;
  justify-content: center;
}

.receipt-content::-webkit-scrollbar {
  width: 6px;
}

.receipt-content::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.receipt-content::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.receipt-content::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.receipt-actions {
  z-index: 10;
}

.company-info {
  text-align: center;
  margin-bottom: 20px;
}

.company-info h2 {
  margin-bottom: 5px;
}

.receipt-details {
  margin-bottom: 20px;
}

.items-table {
  width: 100%;
  margin-bottom: 20px;
  border-collapse: collapse;
}

.items-table th,
.items-table td {
  padding: 5px;
  text-align: left;
  border-bottom: 1px dashed #ccc;
}

.totals {
  margin-bottom: 20px;
}

.totals p {
  display: flex;
  justify-content: space-between;
  margin: 5px 0;
}

.receipt-footer {
  text-align: center;
  margin-top: 20px;
  padding-top: 10px;
  border-top: 1px dashed #ccc;
}

@media print {
  .receipt {
    height: auto;
    max-height: none;
  }
  
  .receipt-content {
    overflow-y: visible;
  }
  
  .receipt-actions {
    display: none;
  }
}
</style>
