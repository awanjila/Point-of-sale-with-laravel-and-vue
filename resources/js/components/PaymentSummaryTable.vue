<template>
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="header-title">Payment Summary</h4>
        <div class="d-flex gap-2">
          <input 
            type="text" 
            v-model="search" 
            class="form-control form-control-sm" 
            style="width: 200px"
            placeholder="Search payment method..."
          >
          <select v-model="sortOrder" class="form-select form-select-sm" style="width: 150px">
            <option value="asc">Amount (Low to High)</option>
            <option value="desc">Amount (High to Low)</option>
          </select>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-centered table-hover">
          <thead class="table-light">
            <tr>
              <th>Payment Method</th>
              <th>Number of Transactions</th>
              <th>Total Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="payment in filteredAndSortedPayments" :key="payment.payment_method">
              <td>
                <span class="badge" :class="getPaymentBadgeClass(payment.payment_method)">
                  {{ payment.payment_method }}
                </span>
              </td>
              <td>{{ payment.count }}</td>
              <td>Ksh {{ formatNumber(payment.total) }}</td>
            </tr>
          </tbody>
          <tfoot class="table-light">
            <tr>
              <td><strong>Total</strong></td>
              <td><strong>{{ totalTransactions }}</strong></td>
              <td><strong>Ksh {{ formatNumber(totalAmount) }}</strong></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    payments: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      search: '',
      sortOrder: 'desc'
    }
  },
  computed: {
    filteredAndSortedPayments() {
      let filtered = this.payments.filter(payment => 
        payment.payment_method.toLowerCase().includes(this.search.toLowerCase())
      );
      
      return filtered.sort((a, b) => {
        const aTotal = parseFloat(a.total);
        const bTotal = parseFloat(b.total);
        return this.sortOrder === 'asc' ? aTotal - bTotal : bTotal - aTotal;
      });
    },
    totalTransactions() {
      return this.filteredAndSortedPayments.reduce((sum, payment) => sum + payment.count, 0);
    },
    totalAmount() {
      return this.filteredAndSortedPayments.reduce((sum, payment) => sum + parseFloat(payment.total), 0);
    }
  },
  methods: {
    formatNumber(number) {
      return parseFloat(number).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },
    getPaymentBadgeClass(status) {
      const classes = {
        'cash': 'bg-success',
        'card': 'bg-info',
        'mpesa': 'bg-primary',
        'pending': 'bg-warning',
        'partial': 'bg-warning'
      };
      return classes[status.toLowerCase()] || 'bg-secondary';
    }
  }
}
</script>