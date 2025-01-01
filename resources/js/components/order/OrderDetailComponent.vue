<template>
    <div class="container-fluid">
        <div v-if="loading" class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else-if="error" class="alert alert-danger">
            {{ error }}
        </div>

        <div v-else-if="order" class="card">
            <div class="card-header">
                <h4 class="card-title">Order Details</h4>
            </div>
            <div class="card-body">
                <!-- Order Information -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Order Information</h5>
                        <p><strong>Invoice No:</strong> {{ order.invoice_no }}</p>
                        <p><strong>Order Date:</strong> {{ formatDate(order.order_date) }}</p>
                        <p><strong>Order Status:</strong> 
                            <span :class="getStatusBadge(order.order_status)">
                                {{ order.order_status }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Customer Details</h5>
                        <p><strong>Name:</strong> {{ order.customer?.name || 'Walk-in Customer' }}</p>
                        <p v-if="order.customer?.email"><strong>Email:</strong> {{ order.customer.email }}</p>
                        <p v-if="order.customer?.phone"><strong>Phone:</strong> {{ order.customer.phone }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="row">
                    <div class="col-12">
                        <h5>Order Items</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in order.order_details" :key="item.id">
                                        <td>{{ item.product?.name || 'Unknown Product' }}</td>
                                        <td>{{ item.quantity }}</td>
                                        <td>{{ formatCurrency(item.unit_cost) }}</td>
                                        <td>{{ formatCurrency(item.total) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Subtotal</th>
                                        <th>{{ formatCurrency(order.sub_total) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">VAT (16%)</th>
                                        <th>{{ formatCurrency(order.vat) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th>{{ formatCurrency(order.total) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
    props: {
        orderId: {
            type: [String, Number],
            required: true
        }
    },
    setup() {
        const toast = useToast();
        return { toast };
    },
    data() {
        return {
            order: null,
            loading: true,
            error: null
        }
    },
    methods: {
        async fetchOrderDetails() {
            try {
                this.loading = true;
                this.error = null;

                const response = await axios.get(`/api/orders/${this.orderId}`);
                
                if (response.data.status === 'success') {
                    this.order = response.data.order;
                } else {
                    throw new Error(response.data.message || 'Failed to fetch order details');
                }
            } catch (error) {
                console.error('Error fetching order details:', error);
                this.error = error.response?.data?.message || 'Error fetching order details';
                this.toast.error(this.error);
            } finally {
                this.loading = false;
            }
        },
        formatDate(dateString) {
            return new Date(dateString).toLocaleString();
        },
        formatCurrency(amount) {
            return `KES ${parseFloat(amount || 0).toLocaleString('en-US', { 
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
            })}`;
        },
        getStatusBadge(status) {
            const classes = {
                'pending': 'badge bg-warning',
                'processing': 'badge bg-info',
                'completed': 'badge bg-success',
                'cancelled': 'badge bg-danger'
            };
            return classes[status?.toLowerCase()] || 'badge bg-secondary';
        }
    },
    mounted() {
        this.fetchOrderDetails();
    }
}
</script> 