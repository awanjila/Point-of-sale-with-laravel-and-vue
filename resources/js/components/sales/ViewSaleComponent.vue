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

        <div v-else class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Sale Details</h4>
                    <div class="btn-group">
                        <button @click="printSale" class="btn btn-primary">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button @click="deleteSale" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Sale Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Sale Information</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th>Sale No:</th>
                                <td>{{ sale.sale_no }}</td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{ formatDate(sale.sale_date) }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span :class="getStatusBadgeClass(sale.status)">
                                        {{ sale.status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Type:</th>
                                <td>{{ sale.sale_type }}</td>
                            </tr>
                            <tr>
                                <th>Payment Terms:</th>
                                <td>{{ formatPaymentTerms(sale.payment_terms) }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>Customer Information</h5>
                        <table class="table table-borderless" v-if="sale.customer">
                            <tr>
                                <th>Name:</th>
                                <td>{{ sale.customer.name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ sale.customer.email }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ sale.customer.phone }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ sale.customer.address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Sale Items -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5>Sale Items</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in sale.items" :key="item.id">
                                        <td>{{ item.product.product_name }}</td>
                                        <td>{{ item.quantity }}</td>
                                        <td>{{ formatCurrency(item.unit_price) }}</td>
                                        <td>
                                            {{ item.discount_type === 'percentage' 
                                                ? `${item.discount_amount}%` 
                                                : formatCurrency(item.discount_amount) }}
                                        </td>
                                        <td>{{ formatCurrency(item.tax_amount) }}</td>
                                        <td>{{ formatCurrency(item.total) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-end">Subtotal:</th>
                                        <td>{{ formatCurrency(sale.subtotal) }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-end">Tax:</th>
                                        <td>{{ formatCurrency(sale.tax_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-end">Shipping:</th>
                                        <td>{{ formatCurrency(sale.shipping_charges) }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-end">Total:</th>
                                        <td>{{ formatCurrency(sale.total) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="row mb-4" v-if="sale.documents && sale.documents.length">
                    <div class="col-12">
                        <h5>Documents</h5>
                        <div class="list-group">
                            <a 
                                v-for="doc in sale.documents" 
                                :key="doc.id"
                                :href="doc.url"
                                target="_blank"
                                class="list-group-item list-group-item-action"
                            >
                                {{ doc.document_name }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="row" v-if="sale.notes">
                    <div class="col-12">
                        <h5>Notes</h5>
                        <p>{{ sale.notes }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from 'vue-toastification';

export default {
    props: {
        saleId: {
            type: [Number, String],
            required: true
        }
    },

    setup() {
        const toast = useToast();
        return { toast };
    },

    data() {
        return {
            sale: null,
            loading: true,
            error: null
        };
    },

    methods: {
        async loadSale() {
            try {
                const response = await axios.get(`/api/sales/${this.saleId}`);
                if (response.data.status === 'success') {
                    this.sale = response.data.sale;
                } else {
                    throw new Error(response.data.message);
                }
            } catch (error) {
                console.error('Error loading sale:', error);
                this.error = error.response?.data?.message || 'Error loading sale details';
                this.toast.error(this.error);
            } finally {
                this.loading = false;
            }
        },

        async deleteSale() {
            if (!confirm('Are you sure you want to delete this sale?')) return;

            try {
                const response = await axios.delete(`/api/sales/${this.saleId}`);
                if (response.data.status === 'success') {
                    this.toast.success('Sale deleted successfully');
                    window.location.href = '/sales';
                }
            } catch (error) {
                console.error('Error deleting sale:', error);
                this.toast.error(error.response?.data?.message || 'Error deleting sale');
            }
        },

        printSale() {
            window.print();
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString();
        },

        formatCurrency(amount) {
            return new Intl.NumberFormat('en-KE', {
                style: 'currency',
                currency: 'KES'
            }).format(amount);
        },

        formatPaymentTerms(terms) {
            return terms.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        },

        getStatusBadgeClass(status) {
            const classes = {
                pending: 'badge bg-warning',
                processing: 'badge bg-info',
                completed: 'badge bg-success',
                cancelled: 'badge bg-danger'
            };
            return classes[status] || 'badge bg-secondary';
        }
    },

    mounted() {
        this.loadSale();
    }
};
</script>

<style scoped>
@media print {
    .btn-group {
        display: none !important;
    }
}

.badge {
    font-size: 0.8rem;
    padding: 0.35em 0.65em;
}
</style> 