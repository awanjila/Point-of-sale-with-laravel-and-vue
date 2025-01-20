<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">Add New Sale</h4>
                            <div class="sale-type-buttons">
                                <button 
                                    v-for="type in saleTypes" 
                                    :key="type.value"
                                    :class="['btn', sale.sale_type === type.value ? 'btn-primary' : 'btn-outline-primary', 'me-2']"
                                    @click="sale.sale_type = type.value"
                                >
                                    {{ type.label }}
                                </button>
                            </div>
                        </div>

                        <form @submit.prevent="submitSale" ref="saleForm">
                            <!-- Basic Sale Info -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Sale No</label>
                                    <input type="text" class="form-control" v-model="sale.sale_no" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Sale Date</label>
                                    <input type="date" class="form-control" v-model="sale.sale_date" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" v-model="sale.status" required>
                                        <option value="pending">Pending</option>
                                        <option value="processing">Processing</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Payment Terms</label>
                                    <select class="form-select" v-model="sale.payment_terms">
                                        <option value="immediate">Immediate</option>
                                        <option value="15_days">15 Days</option>
                                        <option value="30_days">30 Days</option>
                                        <option value="45_days">45 Days</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Customer Section -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Customer</label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="customerSearch"
                                            @input="searchCustomers"
                                            placeholder="Search customers..."
                                        >
                                        <button 
                                            type="button" 
                                            class="btn btn-primary"
                                            @click="showAddCustomerModal = true"
                                        >
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- Customer Search Results -->
                                    <div v-if="showCustomerResults" class="search-results">
                                        <div 
                                            v-for="customer in filteredCustomers" 
                                            :key="customer.id"
                                            class="search-item"
                                            @click="selectCustomer(customer)"
                                        >
                                            {{ customer.name }} - {{ customer.phone }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Selected Customer Details -->
                                <div class="col-md-6" v-if="selectedCustomer">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6>Selected Customer</h6>
                                            <p class="mb-1"><strong>Name:</strong> {{ selectedCustomer.name }}</p>
                                            <p class="mb-1"><strong>Phone:</strong> {{ selectedCustomer.phone }}</p>
                                            <p class="mb-0"><strong>Email:</strong> {{ selectedCustomer.email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Upload -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Attach Documents</label>
                                    <input 
                                        type="file" 
                                        class="form-control" 
                                        @change="handleFileUpload" 
                                        multiple
                                    >
                                </div>
                                <div class="col-md-6">
                                    <div v-if="sale.documents.length" class="attached-files">
                                        <div v-for="(doc, index) in sale.documents" :key="index" class="file-item">
                                            {{ doc.name }}
                                            <button type="button" class="btn-close" @click="removeDocument(index)"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Products Section -->
                            <div class="products-section mb-4">
                                <h5 class="mb-3">Products</h5>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in sale.items" :key="index">
                                                <td>
                                                    <div class="product-select">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            v-model="item.productSearch"
                                                            @input="searchProducts(index)"
                                                            placeholder="Search products..."
                                                        >
                                                        <!-- Product Search Results -->
                                                        <div v-if="item.showResults" class="search-results">
                                                            <div 
                                                                v-for="product in item.filteredProducts" 
                                                                :key="product.id"
                                                                class="search-item"
                                                                @click="selectProduct(product, index)"
                                                            >
                                                                {{ product.name }} - {{ formatCurrency(product.selling_price) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input 
                                                        type="number" 
                                                        class="form-control" 
                                                        v-model="item.quantity"
                                                        @input="calculateItemTotal(index)"
                                                    >
                                                </td>
                                                <td>
                                                    <input 
                                                        type="number" 
                                                        class="form-control" 
                                                        v-model="item.unit_price"
                                                        @input="calculateItemTotal(index)"
                                                    >
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input 
                                                            type="number" 
                                                            class="form-control" 
                                                            v-model="item.discount"
                                                            @input="calculateItemTotal(index)"
                                                        >
                                                        <select 
                                                            class="form-select" 
                                                            v-model="item.discount_type"
                                                            @change="calculateItemTotal(index)"
                                                        >
                                                            <option value="percentage">%</option>
                                                            <option value="fixed">Fixed</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>{{ calculateTax(item) }}</td>
                                                <td>{{ formatCurrency(item.total) }}</td>
                                                <td>
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-danger btn-sm"
                                                        @click="removeItem(index)"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button 
                                    type="button" 
                                    class="btn btn-success mt-2"
                                    @click="addNewItem"
                                >
                                    Add Product
                                </button>
                            </div>

                            <!-- Totals Section -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <!-- Shipping Details -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Shipping Details</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Shipping Address</label>
                                                <textarea 
                                                    class="form-control" 
                                                    v-model="sale.shipping_address"
                                                    rows="3"
                                                ></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Delivered To</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control"
                                                    v-model="sale.delivered_to"
                                                >
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Delivery Person</label>
                                                <select class="form-select" v-model="sale.delivery_person_id">
                                                    <option value="">Select Delivery Person</option>
                                                    <option 
                                                        v-for="person in deliveryPersons" 
                                                        :key="person.id" 
                                                        :value="person.id"
                                                    >
                                                        {{ person.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Shipping Charges</label>
                                                <input 
                                                    type="number" 
                                                    class="form-control"
                                                    v-model="sale.shipping_charges"
                                                    @input="calculateTotal"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Sale Totals -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Sale Totals</h6>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Subtotal:</span>
                                                <span>{{ formatCurrency(sale.subtotal) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Total Discount:</span>
                                                <span>{{ formatCurrency(sale.total_discount) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Order Tax ({{ sale.tax_rate }}%):</span>
                                                <span>{{ formatCurrency(sale.tax_amount) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Shipping:</span>
                                                <span>{{ formatCurrency(sale.shipping_charges) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 fw-bold">
                                                <span>Total:</span>
                                                <span>{{ formatCurrency(sale.total) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label">Sale Notes</label>
                                    <textarea 
                                        class="form-control" 
                                        v-model="sale.notes"
                                        rows="3"
                                    ></textarea>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-2">
                                        Save Sale
                                    </button>
                                    <button 
                                        type="button" 
                                        class="btn btn-secondary"
                                        @click="saveDraft"
                                    >
                                        Save as Draft
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Customer Modal -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" v-if="showAddCustomerModal">
            <!-- Modal content will be added in the next part -->
        </div>
    </div>
</template>

<script>
import { useToast } from 'vue-toastification';
import axios from 'axios';

export default {
    setup() {
        const toast = useToast();
        return { toast };
    },

    data() {
        return {
            sale: {
                sale_no: '',  // Will be set in created()
                sale_date: new Date().toISOString().split('T')[0],
                sale_type: 'final', // final, draft, quotation, proforma
                status: 'pending',
                payment_terms: 'immediate',
                customer_id: null,
                items: [],
                documents: [],
                subtotal: 0,
                total_discount: 0,
                discount_type: 'fixed', // or 'percentage'
                discount_amount: 0,
                tax_rate: 16,
                tax_amount: 0,
                shipping_charges: 0,
                total: 0,
                shipping_address: '',
                delivered_to: '',
                delivery_person_id: '',
                notes: ''
            },
            saleTypes: [
                { value: 'final', label: 'Final' },
                { value: 'draft', label: 'Draft' },
                { value: 'quotation', label: 'Quotation' },
                { value: 'proforma', label: 'Proforma' }
            ],
            customerSearch: '',
            showCustomerResults: false,
            filteredCustomers: [],
            customers: [],
            selectedCustomer: null,
            showAddCustomerModal: false,
            deliveryPersons: [],
            loading: false
        };
    },

    computed: {
        saleNo() {
            const date = new Date();
            return `SALE-${date.getFullYear()}${(date.getMonth() + 1).toString().padStart(2, '0')}${date.getDate().toString().padStart(2, '0')}-${Math.floor(Math.random() * 1000).toString().padStart(3, '0')}`;
        }
    },

    methods: {
        async searchCustomers() {
            if (this.customerSearch.length < 2) {
                this.showCustomerResults = false;
                return;
            }

            try {
                const response = await axios.get(`/api/customers/search?q=${this.customerSearch}`);
                this.filteredCustomers = response.data;
                this.showCustomerResults = true;
            } catch (error) {
                this.toast.error('Error searching customers');
            }
        },

        selectCustomer(customer) {
            this.selectedCustomer = customer;
            this.sale.customer_id = customer.id;
            this.customerSearch = customer.name;
            this.showCustomerResults = false;
        },

        handleFileUpload(event) {
            const files = Array.from(event.target.files);
            this.sale.documents.push(...files);
        },

        removeDocument(index) {
            this.sale.documents.splice(index, 1);
        },

        addNewItem() {
            this.sale.items.push({
                product_id: null,
                productSearch: '',
                showResults: false,
                filteredProducts: [],
                quantity: 1,
                unit_price: 0,
                discount: 0,
                discount_type: 'fixed',
                tax: 0,
                total: 0
            });
        },

        async searchProducts(index) {
            const item = this.sale.items[index];
            if (item.productSearch.length < 2) {
                item.showResults = false;
                return;
            }

            try {
                const response = await axios.get(`/api/products/search?q=${item.productSearch}`);
                item.filteredProducts = response.data;
                item.showResults = true;
            } catch (error) {
                this.toast.error('Error searching products');
            }
        },

        selectProduct(product, index) {
            const item = this.sale.items[index];
            item.product_id = product.id;
            item.productSearch = product.name;
            item.unit_price = product.selling_price;
            item.showResults = false;
            this.calculateItemTotal(index);
        },

        calculateItemTotal(index) {
            const item = this.sale.items[index];
            const subtotal = item.quantity * item.unit_price;
            const discount = item.discount || 0;
            const discountAmount = item.discount_type === 'percentage' 
                ? (subtotal * discount / 100) 
                : discount;
            
            const taxableAmount = subtotal - discountAmount;
            const tax = (taxableAmount * (this.sale.tax_rate || 0)) / 100;
            
            item.total = taxableAmount + tax;
            this.calculateTotal();
        },

        calculateTotal() {
            this.sale.subtotal = this.sale.items.reduce((sum, item) => sum + item.total, 0);
            
            // Calculate discount
            if (this.sale.discount_type === 'percentage') {
                this.sale.total_discount = (this.sale.subtotal * this.sale.discount_amount) / 100;
            } else {
                this.sale.total_discount = this.sale.discount_amount;
            }

            // Calculate tax
            const taxableAmount = this.sale.subtotal - this.sale.total_discount;
            this.sale.tax_amount = (taxableAmount * this.sale.tax_rate) / 100;

            // Calculate total
            this.sale.total = taxableAmount + this.sale.tax_amount + (this.sale.shipping_charges || 0);
        },

        calculateTax(item) {
            if (!item.unit_price || !item.quantity) {
                return this.formatCurrency(0);
            }

            const subtotal = item.quantity * item.unit_price;
            const discount = item.discount || 0;
            const discountAmount = item.discount_type === 'percentage' 
                ? (subtotal * discount / 100) 
                : discount;
            
            const taxableAmount = subtotal - discountAmount;
            const tax = (taxableAmount * (this.sale.tax_rate || 0)) / 100;
            
            return this.formatCurrency(tax);
        },

        async submitSale() {
            try {
                this.loading = true;
                const formData = new FormData();
                
                // Append sale data
                formData.append('sale_data', JSON.stringify(this.sale));
                
                // Append documents
                this.sale.documents.forEach((doc, index) => {
                    formData.append(`documents[${index}]`, doc);
                });

                const response = await axios.post('/api/sales', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                this.toast.success('Sale created successfully');
                this.$router.push('/sales');
            } catch (error) {
                this.toast.error(error.response?.data?.message || 'Error creating sale');
            } finally {
                this.loading = false;
            }
        },

        saveDraft() {
            this.sale.sale_type = 'draft';
            this.submitSale();
        },

        formatCurrency(amount) {
            return new Intl.NumberFormat('en-KE', {
                style: 'currency',
                currency: 'KES'
            }).format(amount);
        }
    },

    created() {
        this.sale.sale_no = this.saleNo;
        this.addNewItem();
        
        // Load delivery persons
        axios.get('/api/delivery-persons')
            .then(response => {
                if (response.data.status === 'success') {
                    this.deliveryPersons = response.data.data;
                } else {
                    this.toast.error('Error loading delivery persons');
                }
            })
            .catch(error => {
                console.error('Error loading delivery persons:', error);
                this.toast.error('Error loading delivery persons');
            });
    }
};
</script>

<style scoped>
.customer-search {
    position: relative;
    margin-bottom: 0.5rem;
}

.search-container {
    position: relative;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
