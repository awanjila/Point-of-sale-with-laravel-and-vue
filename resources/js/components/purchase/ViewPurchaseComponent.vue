<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">Purchase Details</h4>
                            <a href="/purchases" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>

                        <div v-if="loading" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div v-else-if="purchase">
                            <!-- Purchase Header Info -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Purchase Information</h5>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td><strong>Purchase No:</strong></td>
                                                <td>{{ purchase.purchase_no }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Date:</strong></td>
                                                <td>{{ formatDate(purchase.purchase_date) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    <span :class="getStatusBadge(purchase.status)">
                                                        {{ purchase.status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Supplier Information</h5>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td><strong>Name:</strong></td>
                                                <td>{{ purchase.supplier.name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone:</strong></td>
                                                <td>{{ purchase.supplier.phone }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ purchase.supplier.email }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Purchase Items Table -->
                            <div class="table-responsive mt-4">
                                <h5>Purchase Items</h5>
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
                                        <tr v-for="item in purchase.items" :key="item.id">
                                            <td>{{ item.product.product_name }}</td>
                                            <td>{{ item.quantity }}</td>
                                            <td>{{ currency }}{{ formatNumber(item.unit_price) }}</td>
                                            <td>{{ currency }}{{ formatNumber(item.total) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                                            <td><strong>{{ currency }}{{ formatNumber(purchase.total_amount) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Payment Information -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h5>Payment Information</h5>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td><strong>Payment Status:</strong></td>
                                                <td>
                                                    <span :class="getPaymentStatusBadge(purchase.payment_status)">
                                                        {{ purchase.payment_status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Paid Amount:</strong></td>
                                                <td>{{ currency }}{{ formatNumber(purchase.paid_amount) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Due Amount:</strong></td>
                                                <td>{{ currency }}{{ formatNumber(purchase.due_amount) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Notes</h5>
                                    <p>{{ purchase.notes || 'No notes available' }}</p>
                                </div>
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
        purchaseId: {
            type: Number,
            required: true
        }
    },
    setup() {
        const toast = useToast();
        return { toast }
    },
    data() {
        return {
            purchase: null,
            loading: true,
            currency: 'KES'
        }
    },
    methods: {
        async fetchPurchaseDetails() {
            try {
                const response = await axios.get(`/api/purchases/${this.purchaseId}`);
                this.purchase = response.data.purchase;
                this.currency = response.data.currency;
            } catch (error) {
                this.toast.error('Error fetching purchase details');
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString();
        },
        formatNumber(number) {
            return Number(number).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },
        getStatusBadge(status) {
            const classes = {
                'pending': 'badge bg-warning',
                'completed': 'badge bg-success',
                'cancelled': 'badge bg-danger'
            };
            return classes[status.toLowerCase()] || 'badge bg-secondary';
        },
        getPaymentStatusBadge(status) {
            const classes = {
                'paid': 'badge bg-success',
                'partial': 'badge bg-warning',
                'pending': 'badge bg-danger'
            };
            return classes[status.toLowerCase()] || 'badge bg-secondary';
        }
    },
    mounted() {
        this.fetchPurchaseDetails();
    }
}
</script> 