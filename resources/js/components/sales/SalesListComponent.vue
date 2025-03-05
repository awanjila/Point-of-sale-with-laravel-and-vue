<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Sales List</h4>
                            <a href="/add/sales" class="btn btn-primary">
                                <i class="fas fa-plus"></i> New Sale
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="filters.search"
                                    placeholder="Search sales..."
                                    @input="loadSales"
                                >
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" v-model="filters.status" @change="loadSales">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" v-model="filters.type" @change="loadSales">
                                    <option value="">All Types</option>
                                    <option value="final">Final</option>
                                    <option value="draft">Draft</option>
                                    <option value="quotation">Quotation</option>
                                    <option value="proforma">Proforma</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    v-model="filters.date_from"
                                    @change="loadSales"
                                >
                            </div>
                            <div class="col-md-2">
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    v-model="filters.date_to"
                                    @change="loadSales"
                                >
                            </div>
                        </div>

                        <!-- Sales Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sale No</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody v-if="sales.length">
                                    <tr v-for="sale in sales" :key="sale.id">
                                        <td>{{ sale.sale_no }}</td>
                                        <td>{{ formatDate(sale.sale_date) }}</td>
                                        <td>{{ sale.customer?.name || 'N/A' }}</td>
                                        <td>
                                            <span :class="getTypeBadgeClass(sale.sale_type)">
                                                {{ sale.sale_type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span :class="getStatusBadgeClass(sale.status)">
                                                {{ sale.status }}
                                            </span>
                                        </td>
                                        <td>{{ formatCurrency(sale.total) }}</td>
                                        <td>{{ formatCurrency(sale.paid_amount) }}</td>
                                        <td>{{ formatCurrency(sale.due_amount) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a 
                                                    :href="`/sales/${sale.id}`"
                                                    class="btn btn-sm btn-info"
                                                    title="View"
                                                >
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button 
                                                    class="btn btn-sm btn-danger"
                                                    @click="deleteSale(sale.id)"
                                                    title="Delete"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="9" class="text-center">No sales found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} entries
                            </div>
                            <nav v-if="pagination.last_page > 1">
                                <ul class="pagination mb-0">
                                    <li 
                                        v-for="page in pagination.last_page" 
                                        :key="page"
                                        :class="['page-item', page === pagination.current_page ? 'active' : '']"
                                    >
                                        <a 
                                            class="page-link" 
                                            href="#"
                                            @click.prevent="goToPage(page)"
                                        >
                                            {{ page }}
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from 'vue-toastification';

export default {
    setup() {
        const toast = useToast();
        return { toast };
    },

    data() {
        return {
            sales: [],
            filters: {
                search: '',
                status: '',
                type: '',
                date_from: '',
                date_to: ''
            },
            pagination: {
                current_page: 1,
                from: 0,
                to: 0,
                total: 0,
                last_page: 0
            },
            loading: false
        };
    },

    methods: {
        async loadSales(page = 1) {
            try {
                this.loading = true;
                const response = await axios.get('/api/sales', {
                    params: {
                        ...this.filters,
                        page
                    }
                });

                if (response.data.status === 'success') {
                    this.sales = response.data.data;
                    this.pagination = response.data.meta;
                }
            } catch (error) {
                console.error('Error loading sales:', error);
                this.toast.error('Error loading sales');
            } finally {
                this.loading = false;
            }
        },

        async deleteSale(id) {
            if (!confirm('Are you sure you want to delete this sale?')) return;

            try {
                const response = await axios.delete(`/api/sales/${id}`);
                if (response.data.status === 'success') {
                    this.toast.success('Sale deleted successfully');
                    this.loadSales(this.pagination.current_page);
                }
            } catch (error) {
                console.error('Error deleting sale:', error);
                this.toast.error('Error deleting sale');
            }
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

        getStatusBadgeClass(status) {
            const classes = {
                pending: 'badge bg-warning',
                processing: 'badge bg-info',
                completed: 'badge bg-success',
                cancelled: 'badge bg-danger'
            };
            return classes[status] || 'badge bg-secondary';
        },

        getTypeBadgeClass(type) {
            const classes = {
                final: 'badge bg-success',
                draft: 'badge bg-warning',
                quotation: 'badge bg-info',
                proforma: 'badge bg-primary'
            };
            return classes[type] || 'badge bg-secondary';
        },

        goToPage(page) {
            this.loadSales(page);
        }
    },

    mounted() {
        this.loadSales();
    }
};
</script>

<style scoped>
.badge {
    font-size: 0.8rem;
    padding: 0.35em 0.65em;
}
</style> 