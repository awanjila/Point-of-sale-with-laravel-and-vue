<template>
  <ModalWrapper :show="showModal" @close="closeModal">
    <div class="payment-modal">
      <template v-if="!showReceipt">
        <h2 class="modal-title">Payment Form</h2>

        <!-- Display customer name and order details -->
        <div class="payment-details">
          <p class="customer-name">{{ activeCustomer.name }}</p>
          <p class="order-amount">Order Amount: Ksh {{ totalPrice }}</p>
          <p><strong>Number of Products:</strong> {{ totalItems }}</p>
        </div>

        <!-- Payment form -->
        <div class="form-columns">
          <div class="form-left">
            <div class="form-group">
              <label for="receivedAmount">Received Amount:</label>
              <input
                type="number"
                v-model="receivedAmount"
                id="receivedAmount"
                class="form-control"
                placeholder="Enter received amount"
                required
              />
            </div>

            <div class="form-group">
              <label for="changeReturn">Change Return:</label>
              <p class="form-control-static">{{ changeReturn }}</p>
            </div>
          </div>

          <div class="form-right">
            <div class="form-group">
              <label for="paymentChoice">Payment Method:</label>
              <select v-model="paymentChoice" id="paymentChoice" class="form-control">
                <option value="cash">Cash</option>
                <option value="mpesa">M-Pesa</option>
                <option value="card">Card</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group full-width">
          <label for="paymentNotes">Payment Notes:</label>
          <textarea v-model="paymentNotes" id="paymentNotes" class="form-control payment-notes"></textarea>
        </div>

        <button @click="submitPayment" class="btn btn-primary" :disabled="loading">
          <span v-if="loading">Processing...</span>
          <span v-else>Submit Order</span>
        </button>
      </template>

      <!-- Display the receipt after payment -->
      <ReceiptPrint 
        v-if="showReceipt" 
        :orderId="orderId" 
        :userData="userData"
        :paymentMethod="paymentChoice"
        :changeReturn="changeReturn"
        :receivedAmount="receivedAmount"
        @close="closeReceipt" 
      />
    </div>
  </ModalWrapper>
</template>

<script setup>
// Add userData to props
defineProps({
  showModal: Boolean,
  activeCustomer: Object,
  totalItems: Number,
  totalPrice: Number,
  userData: {
    type: Object,
    required: true
  }
});
</script>

<script>
import ModalWrapper from '@/components/ModalWrapper.vue';
import { useCartStore } from './stores/cart';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import ReceiptPrint from '@/components/ReceiptPrint.vue';

export default {
  components: {
    ModalWrapper,
    ReceiptPrint,
  },
  data() {
    return {
      receivedAmount: this.totalPrice,
      paymentChoice: 'cash',
      paymentNotes: '',
      loading: false,
      showReceipt: false,
      orderId: '',
      changeReturn: 0.00,
      cart: [],
    };
  },
  methods: {
    closeModal() {
      this.$emit('closeModal');
      this.resetForm();
    },
    async submitPayment() {
      const toast = useToast();
      const cartStore = useCartStore();
      this.cart = cartStore.cart;

      if (!this.cart || this.cart.length === 0) {
        toast.error('Your cart is empty. Please add items to the cart before submitting.');
        return;
      }

      const payload = {
        customer_id: this.activeCustomer.id,
        total_items: this.totalItems,
        total_price: this.totalPrice,
        paying_amount: this.receivedAmount,
        payment_method: this.paymentChoice,
        change_return: this.changeReturn,
        cart: this.cart.map(item => ({
          product_id: item.id,
          quantity: item.quantity,
          unit_cost: item.selling_price,
          total: (item.selling_price * item.quantity).toFixed(2),
        })),
      };

      this.loading = true;

      try {
        const response = await axios.post('/api/orders', payload);
        toast.success('Order submitted successfully!');

        if (response.data && response.data.order_id) {
          this.orderId = response.data.order_id;
          this.showReceipt = true; // Show the receipt and hide the payment form
        } else {
          toast.error('Order ID missing from response.');
        }
      } catch (error) {
        toast.error('Error submitting your payment. Please try again.');
      } finally {
        this.loading = false;
      }
    },
    closeReceipt() {
      this.showReceipt = false;
      this.resetForm(); // Optionally reset the form when closing the receipt
    },
    resetForm() {
      this.receivedAmount = this.totalPrice;
      this.paymentChoice = 'cash';
      this.paymentNotes = '';
      this.changeReturn = 0.00;
    },
  },
  watch: {
    receivedAmount(newVal) {
      this.changeReturn = (newVal - this.totalPrice).toFixed(2);
    },
  },
};
</script>

<style scoped>
.payment-modal {
  font-family: 'Lato', sans-serif;
  padding: 20px;
  max-width: 500px;
  width: 100%;
  margin: 0 auto;
}

.modal-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.form-columns {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

@media(min-width: 768px) {
  .form-columns {
    flex-direction: row;
  }
}

.payment-notes {
  height: 100px;
  resize: vertical;
}

.form-left,
.form-right {
  flex: 1;
}

.full-width {
  width: 100%;
  margin-top: 20px;
}

.form-group {
  margin-bottom: 15px;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn-primary {
  background-color: #c02323;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 100%;
  margin-top: 20px;
}

.btn-primary:disabled {
  background-color: #aaa;
  cursor: not-allowed;
}
</style>
