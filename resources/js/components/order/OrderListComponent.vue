<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">Orders List</h4>
                            <a href="/add/order" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Order
                            </a>
                        </div>

                        <!-- Search and Filter -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input 
                                    type="text" 
                                    v-model="search" 
                                    class="form-control" 
                                    placeholder="Search orders..."
                                >
                            </div>
                            <div class="col-md-3">
                                <select v-model="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <!-- Orders Table -->
                        <div class="table-responsive">
                            <table class="table table-centered table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Total Products</th>
                                        <th>Sub Total</th>
                                        <th>VAT</th>
                                        <th>Total</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Pay</th>
                                        <th>Due</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="order in filteredOrders" :key="order.id">
                                        <td>{{ order.invoice_no }}</td>
                                        <td>{{ formatDate(order.order_date) }}</td>
                                        <td>{{ order.customer?.name || 'Walk-in Customer' }}</td>
                                        <td>{{ order.total_products }}</td>
                                        <td>{{ currency }}{{ formatNumber(order.sub_total) }}</td>
                                        <td>{{ currency }}{{ formatNumber(order.vat) }}</td>
                                        <td>{{ currency }}{{ formatNumber(order.total) }}</td>
                                        <td>
                                            <span :class="getPaymentStatusBadge(order.payment_status)">
                                                {{ order.payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span :class="getStatusBadge(order.order_status)">
                                                {{ order.order_status }}
                                            </span>
                                        </td>
                                        <td>{{ currency }}{{ formatNumber(order.pay) }}</td>
                                        <td>{{ currency }}{{ formatNumber(order.due) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-info me-1" @click="viewOrder(order)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success me-1" 
                                                    @click="completeOrder(order)" 
                                                    v-if="order.order_status === 'pending'">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" 
                                                    @click="deleteOrder(order)"
                                                    v-if="order.order_status !== 'completed'">
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
            orders: [],
            search: '',
            statusFilter: '',
            loading: false,
            currency: 'KES'
        }
    },
    computed: {
        filteredOrders() {
            return this.orders.filter(order => {
                const searchTerm = this.search.toLowerCase();
                
                const matchesSearch = 
                    (order.invoice_no?.toLowerCase() || '').includes(searchTerm) ||
                    (order.customer?.name?.toLowerCase() || '').includes(searchTerm);
                
                const matchesStatus = !this.statusFilter || 
                    order.order_status === this.statusFilter;

                return matchesSearch && matchesStatus;
            });
        }
    },
    methods: {
        async fetchOrders() {
            try {
                const response = await axios.get('/api/orders');
                this.orders = response.data.orders || [];
                this.currency = response.data.currency;
            } catch (error) {
                console.error('Error fetching orders:', error);
                this.toast.error('Error fetching orders');
                this.orders = [];
            }
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString();
        },
        formatNumber(number) {
            return parseFloat(number || 0).toLocaleString('en-US', {
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
            return classes[status?.toLowerCase()] || 'badge bg-secondary';
        },
        getStatusBadge(status) {
            const classes = {
                'pending': 'badge bg-warning',
                'processing': 'badge bg-info',
                'completed': 'badge bg-success',
                'cancelled': 'badge bg-danger'
            };
            return classes[status?.toLowerCase()] || 'badge bg-secondary';
        },

        async viewOrder(order) {
    try {
        const response = await axios.get(`/orders/${order.id}`);
        window.location.href = `/orders/${order.id}`;
    } catch (error) {
        this.toast.error('Error fetching order details');
    }
},

        async completeOrder(order) {
            try {
                if (!confirm('Are you sure you want to mark this order as completed?')) {
                    return;
                }

                const response = await axios.patch(`/api/orders/${order.id}/complete`);
                
                // Show success message with stock details
                if (response.data.stockDetails) {
                    const stockMessages = response.data.stockDetails.map(detail => 
                        `${detail.product}: ${detail.original_stock} → ${detail.new_stock} (-${detail.reduced_by})`
                    );
                    
                    this.toast.success(
                        `Order completed successfully!\n\nStock Updates:\n${stockMessages.join('\n')}`, 
                        {
                            timeout: 5000,
                            position: "bottom-right"
                        }
                    );
                } else {
                    this.toast.success('Order completed successfully!');
                }

                await this.fetchOrders(); // Refresh the list
            } catch (error) {
                this.toast.error(error.response?.data?.message || 'Error completing order');
            }
        },
        async deleteOrder(order) {
            try {
                if (!confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
                    return;
                }

                await axios.delete(`/api/orders/${order.id}`);
                this.toast.success('Order deleted successfully');
                await this.fetchOrders(); // Refresh the list
            } catch (error) {
                this.toast.error(error.response?.data?.message || 'Error deleting order');
            }
        }
    },
    mounted() {
        this.fetchOrders();
    }
}
</script> 