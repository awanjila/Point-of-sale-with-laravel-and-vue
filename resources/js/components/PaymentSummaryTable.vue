<template>
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="header-title">Payment Summary</h4>
        <div class="d-flex gap-2">
          <select v-model="dateFilter" class="form-select form-select-sm" style="width: 150px">
            <option value="all">All Time</option>
            <option value="today">Today</option>
            <option value="month">This Month</option>
            <option value="year">This Year</option>
          </select>
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
      sortOrder: 'desc',
      dateFilter: 'all'
    }
  },
  computed: {
    filteredAndSortedPayments() {
      let filtered = this.filterByDate(this.payments);
      
      filtered = filtered.filter(payment => 
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
    filterByDate(payments) {
      const today = new Date();
      const startOfDay = new Date(today.getFullYear(), today.getMonth(), today.getDate());
      const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
      const startOfYear = new Date(today.getFullYear(), 0, 1);

      switch (this.dateFilter) {
        case 'today':
          return payments.filter(payment => {
            const paymentDate = new Date(payment.created_at);
            return paymentDate >= startOfDay;
          });
        case 'month':
          return payments.filter(payment => {
            const paymentDate = new Date(payment.created_at);
            return paymentDate >= startOfMonth;
          });
        case 'year':
          return payments.filter(payment => {
            const paymentDate = new Date(payment.created_at);
            return paymentDate >= startOfYear;
          });
        default:
          return payments;
      }
    },
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