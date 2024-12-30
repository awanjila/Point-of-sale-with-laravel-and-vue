<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">Purchase List</h4>
                            <a href="/add/purchase" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Purchase
                            </a>
                        </div>

                        <!-- Search and Filter -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input 
                                    type="text" 
                                    v-model="search" 
                                    class="form-control" 
                                    placeholder="Search purchases..."
                                >
                            </div>
                            <div class="col-md-3">
                                <select v-model="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <!-- Purchases Table -->
                        <div class="table-responsive">
                            <table class="table table-centered table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Purchase No</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Total Products</th>
                                        <th>Total Amount</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="purchase in filteredPurchases" :key="purchase.id">
                                        <td>{{ purchase.purchase_no }}</td>
                                        <td>{{ formatDate(purchase.purchase_date) }}</td>
                                        <td>{{ purchase.supplier?.name }}</td>
                                        <td>{{ purchase.total_products }}</td>
                                        <td>{{ currency }}{{ formatNumber(purchase.total_amount) }}</td>
                                        <td>
                                            <span :class="getPaymentStatusBadge(purchase.payment_status)">
                                                {{ purchase.payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span :class="getStatusBadge(purchase.status)">
                                                {{ purchase.status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-info me-1" @click="viewPurchase(purchase)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success me-1" @click="completePurchase(purchase)" v-if="purchase.status === 'pending'">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" @click="deletePurchase(purchase)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";

export default {
    setup() {
        const toast = useToast();
        return { toast }
    },
    data() {
        return {
            purchases: [],
            search: '',
            statusFilter: '',
            loading: false,
            currency: '$' // Default currency
        }
    },
    computed: {
        filteredPurchases() {
            return this.purchases.filter(purchase => {
                const matchesSearch = 
                    purchase.purchase_no.toLowerCase().includes(this.search.toLowerCase()) ||
                    purchase.supplier?.name.toLowerCase().includes(this.search.toLowerCase());
                
                const matchesStatus = !this.statusFilter || 
                    purchase.status === this.statusFilter;

                return matchesSearch && matchesStatus;
            });
        }
    },
    methods: {
        async fetchPurchases() {
            try {
                const response = await axios.get('/api/purchases');
                this.purchases = response.data.purchases;
                this.currency = response.data.currency;
            } catch (error) {
                this.toast.error('Error fetching purchases');
            }
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString();
        },
        formatNumber(number) {
            return number.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },
        getPaymentStatusBadge(status) {
            const classes = {
                'paid': 'badge bg-success',
                'partial': 'badge bg-warning',
                'pending': 'badge bg-danger'
            };
            return classes[status.toLowerCase()] || 'badge bg-secondary';
        },
        getStatusBadge(status) {
            const classes = {
                'pending': 'badge bg-warning',    // Yellow for pending
                'received': 'badge bg-info',      // Blue for received
                'completed': 'badge bg-success',  // Green for completed
                'cancelled': 'badge bg-danger',   // Red for cancelled
                'returned': 'badge bg-secondary'  // Grey for returned
            };
            return classes[status.toLowerCase()] || 'badge bg-secondary';
        },
        async viewPurchase(purchase) {
            try {
                const response = await axios.get(`/api/purchases/${purchase.id}`);
                // Store the purchase details
                this.selectedPurchase = response.data.purchase;
                // You might want to redirect to a details page or show a modal
                window.location.href = `/purchases/${purchase.id}`;
            } catch (error) {
                this.toast.error('Error fetching purchase details');
            }
        },
        async completePurchase(purchase) {
            try {
                if (!confirm('Are you sure you want to mark this purchase as completed?')) {
                    return;
                }

                await axios.patch(`/api/purchases/${purchase.id}/complete`);
                this.toast.success('Purchase marked as completed');
                await this.fetchPurchases(); // Refresh the list
            } catch (error) {
                this.toast.error(error.response?.data?.message || 'Error completing purchase');
            }
        },
        async deletePurchase(purchase) {
            try {
                if (!confirm('Are you sure you want to delete this purchase? This action cannot be undone.')) {
                    return;
                }

                await axios.delete(`/api/purchases/${purchase.id}`);
                this.toast.success('Purchase deleted successfully');
                await this.fetchPurchases(); // Refresh the list
            } catch (error) {
                this.toast.error(error.response?.data?.message || 'Error deleting purchase');
            }
        }
    },
    mounted() {
        this.fetchPurchases();
    }
}
</script> 