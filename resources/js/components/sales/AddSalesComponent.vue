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
                                    <div class="customer-search">
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
                                            <i class="fas fa-plus"></i> Add New
                                        </button>
                                    </div>
                                    <!-- Customer Search Results -->
                                        <div v-if="showCustomerResults && filteredCustomers.length > 0" class="search-results">
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
                                                    <div class="product-search">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            v-model="item.productSearch"
                                                            @input="searchProducts(index)"
                                                            placeholder="Search products..."
                                                        >
                                                        <!-- Search Results Dropdown -->
                                                        <div v-if="item.showResults && item.filteredProducts.length > 0" class="search-results">
                                                            <div 
                                                                v-for="product in item.filteredProducts" 
                                                                :key="product.id"
                                                                class="search-item"
                                                                @click="selectProduct(product, index)"
                                                            >
                                                                <div>{{ product.product_name }}</div>
                                                                <div class="small text-muted">
                                                                    Price: {{ formatCurrency(product.selling_price) }} | 
                                                                    Stock: {{ product.product_store }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input 
                                                        type="number" 
                                                        class="form-control" 
                                                        v-model="item.quantity"
                                                        @input="validateQuantity(index)"
                                                        :max="item.available_quantity"
                                                        min="1"
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

                            <!-- Add this after the Products Section -->
                            <div class="payment-section mb-4">
                                <h5 class="mb-3">Payment Details</h5>
                                <div class="row">
                                    <!-- Payment Summary -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Subtotal:</span>
                                                    <strong>{{ formatCurrency(calculateSubtotal) }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Tax ({{ sale.tax_rate }}%):</span>
                                                    <strong>{{ formatCurrency(calculateTotalTax) }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Discount:</span>
                                                    <strong>{{ formatCurrency(calculateTotalDiscount) }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Shipping:</span>
                                                    <strong>{{ formatCurrency(sale.shipping_charges) }}</strong>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between">
                                                    <h6>Total:</h6>
                                                    <h6>{{ formatCurrency(calculateTotal) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Input -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Payment Method</label>
                                                    <select v-model="sale.payment_method" class="form-select">
                                                        <option value="cash">Cash</option>
                                                        <option value="bank_transfer">Bank Transfer</option>
                                                        <option value="cheque">Cheque</option>
                                                        <option value="mobile_money">Mobile Money</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Paid Amount</label>
                                                    <input 
                                                        type="number" 
                                                        class="form-control" 
                                                        v-model="sale.paid_amount"
                                                        @input="calculateDueAmount"
                                                    >
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Reference No.</label>
                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        v-model="sale.payment_reference"
                                                        placeholder="Cheque/Transaction reference"
                                                    >
                                                </div>

                                                <div class="alert" :class="dueAmountAlertClass">
                                                    <strong>Due Amount: {{ formatCurrency(sale.due_amount) }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        <add-customer-modal
            v-if="showAddCustomerModal"
            :show-modal="showAddCustomerModal"
            @close-modal="showAddCustomerModal = false"
            @customer-added="handleCustomerAdded"
        />
    </div>
</template>

<script>
import { useToast } from 'vue-toastification';
import axios from 'axios';
import AddCustomerModal from '../customers/AddCustomerModal.vue';

export default {
    components: {
        AddCustomerModal
    },
    setup() {
        const toast = useToast();
        return { toast };
    },

    data() {
        return {
            sale: {
                sale_no: '',
                sale_date: new Date().toISOString().split('T')[0],
                sale_type: 'final',
                status: 'pending',
                payment_terms: 'immediate',
                customer_id: null,
                items: [],
                documents: [],
                subtotal: 0,
                total_discount: 0,
                discount_type: 'fixed',
                discount_amount: 0,
                tax_rate: 0, // Set default tax rate
                tax_amount: 0,
                shipping_charges: 0,
                total: 0,
                shipping_address: '',
                delivered_to: '',
                delivery_person_id: '',
                notes: '',
                payment_method: 'cash',
                paid_amount: 0,
                due_amount: 0,
                payment_reference: '',
                payment_status: 'unpaid'
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
        },
        calculateSubtotal() {
            return this.sale.items.reduce((total, item) => {
                return total + (item.quantity * item.unit_price);
            }, 0);
        },
        calculateTotalTax() {
            return this.sale.items.reduce((total, item) => {
                return total + parseFloat(item.tax_amount || 0);
            }, 0);
        },
        calculateTotalDiscount() {
            return this.sale.items.reduce((total, item) => {
                const itemTotal = item.quantity * item.unit_price;
                const discount = item.discount_type === 'percentage' 
                    ? (itemTotal * item.discount / 100) 
                    : item.discount;
                return total + discount;
            }, 0);
        },
        calculateTotal() {
            return this.calculateSubtotal 
                + this.calculateTotalTax 
                - this.calculateTotalDiscount 
                + parseFloat(this.sale.shipping_charges || 0);
        },
        dueAmountAlertClass() {
            const dueAmount = this.sale.due_amount;
            if (dueAmount <= 0) return 'alert-success';
            if (dueAmount < this.calculateTotal) return 'alert-warning';
            return 'alert-danger';
        }
    },

    methods: {
        async searchCustomers() {
            console.log('Search triggered:', this.customerSearch); // Debug log

            if (this.customerSearch.length < 2) {
                this.showCustomerResults = false;
                this.filteredCustomers = [];
                return;
            }

            try {
                const response = await axios.get('/api/customers/search', {
                    params: {
                        q: this.customerSearch
                    }
                });

                console.log('Search response:', response.data); // Debug log

                if (response.data.status === 'success') {
                    this.filteredCustomers = response.data.data;
                    this.showCustomerResults = true;
                    console.log('Filtered customers:', this.filteredCustomers); // Debug log
                }
            } catch (error) {
                console.error('Error searching customers:', error);
                this.toast.error('Error searching customers');
                this.showCustomerResults = false;
                this.filteredCustomers = [];
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
            const newItem = {
                product_id: null,
                productSearch: '',
                showResults: false,
                filteredProducts: [],
                quantity: 1,
                unit_price: 0,
                discount: 0,
                discount_type: 'fixed',
                tax_amount: 0,
                total: 0
            };
            
            console.log('Adding new item:', newItem); // Debug log
            this.sale.items.push(newItem);
        },

        async searchProducts(index) {
            const item = this.sale.items[index];
            console.log('Starting product search for:', item.productSearch);

            if (item.productSearch.length < 2) {
                item.showResults = false;
                item.filteredProducts = [];
                return;
            }

            try {
                const response = await axios.get(`/api/products/search`, {
                    params: {
                        q: item.productSearch
                    }
                });

                console.log('Product search response:', response.data);

                if (response.data.status === 'success') {
                    item.filteredProducts = response.data.data;
                    item.showResults = true;
                } else {
                    throw new Error(response.data.message || 'Error searching products');
                }
            } catch (error) {
                console.error('Error searching products:', error);
                this.toast.error('Error searching products');
                item.showResults = false;
                item.filteredProducts = [];
            }
        },

        selectProduct(product, index) {
            console.log('Selecting product:', product);
            
            const item = this.sale.items[index];
            
            // Ensure all required fields are set
            item.product_id = parseInt(product.id);  // Ensure it's a number
            item.productSearch = product.product_name;
            item.unit_price = parseFloat(product.selling_price);
            item.available_quantity = parseInt(product.product_store);
            item.showResults = false;
            
            console.log('Updated sale item:', item);

            // Stock warnings
            if (product.product_store <= 0) {
                this.toast.warning(`Warning: ${product.product_name} is out of stock!`);
            } else if (product.product_store < 5) {
                this.toast.info(`Low stock alert: Only ${product.product_store} units available for ${product.product_name}`);
            }

            // Recalculate totals
            this.calculateItemTotal(index);
        },

        calculateItemTax(item) {
            if (!item.unit_price || !item.quantity) return 0;
            
            const subtotal = item.quantity * item.unit_price;
            const discountAmount = item.discount_type === 'percentage' 
                ? (subtotal * item.discount / 100) 
                : (item.discount || 0);
            
            const taxableAmount = subtotal - discountAmount;
            return (taxableAmount * (this.sale.tax_rate || 0)) / 100;
        },

        calculateItemTotal(index) {
            const item = this.sale.items[index];
            console.log('Calculating total for item:', item);
            
            // Validate required fields
            if (!item.product_id || !item.unit_price || !item.quantity) {
                console.warn('Missing required fields for calculation:', {
                    product_id: item.product_id,
                    unit_price: item.unit_price,
                    quantity: item.quantity
                });
                return;
            }

            const subtotal = parseFloat(item.quantity) * parseFloat(item.unit_price);
            const discountAmount = item.discount_type === 'percentage' 
                ? (subtotal * parseFloat(item.discount || 0) / 100) 
                : parseFloat(item.discount || 0);
            
            item.tax_amount = this.calculateItemTax(item);
            item.total = subtotal - discountAmount + item.tax_amount;

            console.log('Calculation results:', {
                subtotal,
                discountAmount,
                tax_amount: item.tax_amount,
                total: item.total
            });

            this.updateSaleTotals();
        },

        updateSaleTotals() {
            this.sale.subtotal = this.calculateSubtotal;
            this.sale.tax_amount = this.calculateTotalTax;
            this.sale.total_discount = this.calculateTotalDiscount;
            this.sale.total = this.calculateTotal;
            this.calculateDueAmount();
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
                // Validate items before submission
                const invalidItems = this.sale.items.filter(item => !item.product_id);
                if (invalidItems.length > 0) {
                    this.toast.error('Please select products for all items');
                    console.error('Invalid items:', invalidItems);
                    return;
                }

                this.loading = true;

                // Calculate all totals before submission
                const saleData = {
                    ...this.sale,
                    subtotal: this.calculateSubtotal,
                    tax_amount: this.calculateTotalTax,
                    total_discount: this.calculateTotalDiscount,
                    total: this.calculateTotal,
                    items: this.sale.items.map(item => ({
                        product_id: item.product_id,
                        quantity: item.quantity,
                        unit_price: item.unit_price,
                        discount_type: item.discount_type,
                        discount: item.discount || 0,
                        tax_amount: parseFloat(item.tax_amount || 0),
                        total: item.total
                    }))
                };

                const formData = new FormData();
                formData.append('sale_data', JSON.stringify(saleData));
                
                // Append documents if any
                if (this.sale.documents.length > 0) {
                    this.sale.documents.forEach((doc, index) => {
                        formData.append(`documents[${index}]`, doc);
                    });
                }

                const response = await axios.post('/api/sales', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.status === 'success') {
                    this.toast.success('Sale created successfully');
                    // Redirect to sales list page
                    window.location.href = '/sales';  // Using window.location for full page reload
                } else {
                    throw new Error(response.data.message || 'Error creating sale');
                }
            } catch (error) {
                console.error('Sale submission error:', error);
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
        },

        validateQuantity(index) {
            const item = this.sale.items[index];
            if (!item.product_id) return;

            if (item.quantity > item.available_quantity) {
                this.toast.error(`Only ${item.available_quantity} units available`);
                item.quantity = item.available_quantity;
            }

            this.calculateItemTotal(index);
        },

        handleCustomerAdded(customer) {
            this.selectedCustomer = customer;
            this.sale.customer_id = customer.id;
            this.customerSearch = customer.name;
            this.showAddCustomerModal = false;
            this.toast.success('Customer added successfully');
        },

        calculateDueAmount() {
            const total = this.calculateTotal;
            const paid = parseFloat(this.sale.paid_amount || 0);
            this.sale.due_amount = total - paid;

            // Update payment status
            if (this.sale.due_amount <= 0) {
                this.sale.payment_status = 'paid';
            } else if (this.sale.paid_amount > 0) {
                this.sale.payment_status = 'partial';
            } else {
                this.sale.payment_status = 'unpaid';
            }
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
    margin-bottom: 1rem;
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

.search-item {
    padding: 8px 12px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
}

.search-item:hover {
    background-color: #f5f5f5;
}

.search-item .small {
    font-size: 0.875em;
    color: #6c757d;
}

.product-search {
    position: relative;
}
</style>
