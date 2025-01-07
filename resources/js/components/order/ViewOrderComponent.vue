<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">Order Details</h4>
                            <div>
                                <button 
                                    v-if="order?.order_status === 'pending'"
                                    @click="completeOrder" 
                                    class="btn btn-success me-2"
                                >
                                    <i class="fas fa-check me-1"></i>
                                    Complete Order
                                </button>
                                <a href="/orders" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to List
                                </a>
                            </div>
                        </div>

                        <div v-if="loading" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div v-else-if="order" class="order-details">
                            <!-- Order Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Order Information</h5>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td><strong>Invoice No:</strong></td>
                                                <td>{{ order.invoice_no }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Date:</strong></td>
                                                <td>{{ formatDate(order.order_date) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Status:</strong></td>
                                                <td>
                                                    <span :class="getStatusBadge(order.order_status)">
                                                        {{ order.order_status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Payment Information</h5>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td><strong>Payment Method:</strong></td>
                                                <td>{{ order.payment_method }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Status:</strong></td>
                                                <td>
                                                    <span :class="getPaymentStatusBadge(order.payment_status)">
                                                        {{ order.payment_status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Customer:</strong></td>
                                                <td>{{ order.customer?.name || 'Walk-in Customer' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="table-responsive mt-4">
                                <h5>Order Items</h5>
                                <table class="table table-centered table-bordered mb-0">
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
                                            <td>{{ item.product ? item.product.product_name : 'Product Not Found' }}</td>
                                            <td>{{ item.quantity }}</td>
                                            <td>{{ currency }}{{ formatNumber(item.product.selling_price) }}</td>
                                            <td>{{ currency }}{{ formatNumber(item.total) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Sub Total:</strong></td>
                                            <td>{{ currency }}{{ formatNumber(order.sub_total) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>VAT (16%):</strong></td>
                                            <td>{{ currency }}{{ formatNumber(order.vat) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                                            <td><strong>{{ currency }}{{ formatNumber(order.total) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Amount Paid:</strong></td>
                                            <td>{{ currency }}{{ formatNumber(order.pay) }}</td>
                                        </tr>
                                        <tr v-if="order.due > 0">
                                            <td colspan="3" class="text-end"><strong>Amount Due:</strong></td>
                                            <td class="text-danger">{{ currency }}{{ formatNumber(order.due) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
    props: {
        orderId: {
            type: [Number, String],
            required: true
        }
    },
    setup() {
        const toast = useToast();
        return { toast }
    },
    data() {
        return {
            order: null,
            loading: true,
            currency: 'KES'
        }
    },
    methods: {
        async fetchOrderDetails() {
            try {
                const response = await axios.get(`/api/orders/${this.orderId}`);
                this.order = response.data.order;
                this.currency = response.data.currency;
                
                // Add this for debugging
                console.log('Order details:', this.order);
                console.log('Order details with products:', this.order.order_details);
            } catch (error) {
                this.toast.error('Error fetching order details');
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        async completeOrder() {
            try {
                if (!confirm('Are you sure you want to complete this order? This will update the inventory.')) {
                    return;
                }

                const response = await axios.patch(`/api/orders/${this.orderId}/complete`);
                this.toast.success(response.data.message);
                await this.fetchOrderDetails(); // Refresh the order details
            } catch (error) {
                this.toast.error(error.response?.data?.message || 'Error completing order');
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
        getStatusBadge(status) {
            const classes = {
                'pending': 'badge bg-warning',
                'processing': 'badge bg-info',
                'completed': 'badge bg-success',
                'cancelled': 'badge bg-danger'
            };
            return classes[status?.toLowerCase()] || 'badge bg-secondary';
        },
        getPaymentStatusBadge(status) {
            const classes = {
                'paid': 'badge bg-success',
                'partial': 'badge bg-warning',
                'pending': 'badge bg-danger'
            };
            return classes[status?.toLowerCase()] || 'badge bg-secondary';
        }
    },
    mounted() {
        this.fetchOrderDetails();
    }
}
</script> 