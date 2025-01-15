<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Add New Purchase</h4>

                        <form @submit.prevent="submitPurchase" ref="purchaseForm">
                            <div class="row">
                                <!-- Purchase Details -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Purchase No</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        v-model="purchase.purchase_no"
                                        readonly
                                    >
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Purchase Date</label>
                                    <input 
                                        type="date" 
                                        class="form-control" 
                                        v-model="purchase.purchase_date"
                                        required
                                    >
                                </div>

                                <!-- Supplier Search Section -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Supplier</label>
                                    <div class="supplier-search">
                                        <div class="search-container">
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="supplierSearch"
                                                    placeholder="Search suppliers..."
                                                    @input="handleSupplierSearch"
                                                >
                                                <button 
                                                    type="button"
                                                    class="btn btn-primary"
                                                    @click="showAddSupplierModal = true"
                                                >
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <div v-if="showSupplierResults" class="search-results">
                                                <div 
                                                    v-for="supplier in filteredSuppliers" 
                                                    :key="supplier.id"
                                                    class="supplier-result-item"
                                                    @click="selectSupplier(supplier)"
                                                >
                                                    {{ supplier.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Supplier Status Indicator -->
                                    <div class="supplier-status">
                                        <template v-if="purchase.supplier_id">
                                            <div class="selected-supplier">
                                                <i class="fas fa-user"></i>
                                                <span>{{ selectedSupplierName }}</span>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="no-supplier-warning">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <span>No supplier selected</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Product Selection -->
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Add Products</h5>
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <div class="product-search">
                                                        <div class="search-container">
                                                            <div class="input-group">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    v-model="productSearch"
                                                                    placeholder="Search products..."
                                                                    @input="handleProductSearch"
                                                                >
                                                                <button 
                                                                    type="button"
                                                                    class="btn btn-primary"
                                                                    @click="showAddProductModal = true"
                                                                >
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                            <div v-if="showProductResults" class="search-results">
                                                                <div 
                                                                    v-for="product in filteredProducts" 
                                                                    :key="product.id"
                                                                    class="product-result-item"
                                                                    @click="selectProduct(product)"
                                                                >
                                                                    {{ product.product_name }}
                                                                    <span class="product-code">{{ product.product_code }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <input 
                                                        type="number" 
                                                        class="form-control" 
                                                        v-model="quantity"
                                                        placeholder="Quantity"
                                                    >
                                                </div>
                                                <div class="col-md-2">
                                                    <input 
                                                        type="number" 
                                                        class="form-control" 
                                                        v-model="unitPrice"
                                                        placeholder="Unit Price"
                                                    >
                                                </div>
                                                <div class="col-md-2">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-primary"
                                                        @click="addProduct"
                                                        :disabled="!selectedProduct"
                                                    >
                                                        Add Product
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Products Table -->
                                            <div class="table-responsive">
                                                <table class="table table-centered table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in purchaseItems" :key="index">
                                                            <td>{{ item.product_name }}</td>
                                                            <td>{{ item.quantity }}</td>
                                                            <td>{{ item.unit_price }}</td>
                                                            <td>{{ item.total }}</td>
                                                            <td>
                                                                <button 
                                                                    type="button" 
                                                                    class="btn btn-danger btn-sm"
                                                                    @click="removeProduct(index)"
                                                                >
                                                                    Remove
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="3">Total</th>
                                                            <th>{{ totalAmount }}</th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Details -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Payment Status</label>
                                    <select 
                                        class="form-select" 
                                        v-model="purchase.payment_status"
                                        required
                                    >
                                        <option value="paid">Paid</option>
                                        <option value="partial">Partial</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Paid Amount</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        v-model="purchase.paid_amount"
                                        :max="totalAmount"
                                    >
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Due Amount</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        :value="dueAmount"
                                        readonly
                                    >
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea 
                                        class="form-control" 
                                        v-model="purchase.notes"
                                        rows="3"
                                    ></textarea>
                                </div>

                                <div class="col-12">
                                    <button 
                                        type="submit" 
                                        class="btn btn-primary"
                                        :disabled="!isFormValid || loading"
                                    >
                                        <span v-if="loading">Processing...</span>
                                        <span v-else>Submit Purchase</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <AddSupplierModal
        :showModal="showAddSupplierModal"
        @closeModal="showAddSupplierModal = false"
        @supplierAdded="handleSupplierAdded"
    />

    <AddProductModal
        :showModal="showAddProductModal"
        @closeModal="showAddProductModal = false"
        @productAdded="handleProductAdded"
    />
</template>

<script>
import { useToast } from "vue-toastification";
import AddSupplierModal from '../suppliers/AddSupplierModal.vue';
import AddProductModal from '../products/AddProductModal.vue';

export default {
    components: {
        AddSupplierModal,
        AddProductModal
    },
    setup() {
        const toast = useToast();
        return { toast }
    },
    data() {
        return {
            loading: false,
            suppliers: [],
            products: [],
            purchase: {
                purchase_no: '',
                supplier_id: '',
                purchase_date: '',
                total_amount: 0,
                total_products: 0,
                payment_status: 'pending',
                paid_amount: 0,
                due_amount: 0,
                notes: '',
                status: 'pending'
            },
            selectedProduct: null,
            quantity: '',
            unitPrice: '',
            purchaseItems: [],
            supplierSearch: '',
            showSupplierResults: false,
            filteredSuppliers: [],
            showAddSupplierModal: false,
            productSearch: '',
            showProductResults: false,
            filteredProducts: [],
            showAddProductModal: false
        }
    },
    computed: {
        generatePurchaseNo() {
            const date = new Date();
            return `PUR-${date.getFullYear()}${(date.getMonth() + 1).toString().padStart(2, '0')}${date.getDate().toString().padStart(2, '0')}-${Math.floor(Math.random() * 1000).toString().padStart(3, '0')}`;
        },
        totalAmount() {
            return this.purchaseItems.reduce((sum, item) => sum + item.total, 0);
        },
        dueAmount() {
            return this.totalAmount - this.purchase.paid_amount;
        },
        isFormValid() {
            return this.purchase.supplier_id && 
                   this.purchase.purchase_date && 
                   this.purchaseItems.length > 0;
        },
        selectedSupplierName() {
            const supplier = this.suppliers.find(s => s.id === this.purchase.supplier_id);
            return supplier ? supplier.name : '';
        }
    },
    methods: {
        async fetchSuppliers() {
            try {
                const response = await axios.get('/api/suppliers');
                this.suppliers = response.data;
            } catch (error) {
                console.error('Error fetching suppliers:', error);
            }
        },
        async fetchProducts() {
            try {
                const response = await axios.get('/api/products');
                this.products = response.data;
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        },
        handleSupplierSearch() {
            if (!this.supplierSearch) {
                this.showSupplierResults = false;
                this.filteredSuppliers = [];
                return;
            }

            this.showSupplierResults = true;
            this.filteredSuppliers = this.suppliers.filter(supplier =>
                supplier.name.toLowerCase().includes(this.supplierSearch.toLowerCase())
            );
        },
        selectSupplier(supplier) {
            this.purchase.supplier_id = supplier.id;
            this.supplierSearch = '';
            this.showSupplierResults = false;
        },
        handleProductSearch() {
            if (!this.productSearch) {
                this.showProductResults = false;
                this.filteredProducts = [];
                return;
            }

            this.showProductResults = true;
            this.filteredProducts = this.products.filter(product =>
                product.product_name.toLowerCase().includes(this.productSearch.toLowerCase()) ||
                product.product_code.toLowerCase().includes(this.productSearch.toLowerCase())
            );
        },
        selectProduct(product) {
            this.selectedProduct = product;
            this.productSearch = product.product_name;
            this.showProductResults = false;
            this.unitPrice = product.buying_price || '';
        },
        addProduct() {
            if (!this.selectedProduct || !this.quantity || !this.unitPrice) {
                this.toast.error('Please fill in all product details');
                return;
            }

            this.purchaseItems.push({
                product_id: this.selectedProduct.id,
                product_name: this.selectedProduct.product_name,
                quantity: parseFloat(this.quantity),
                unit_price: parseFloat(this.unitPrice),
                total: parseFloat(this.quantity) * parseFloat(this.unitPrice)
            });

            // Reset inputs
            this.selectedProduct = null;
            this.productSearch = '';
            this.quantity = '';
            this.unitPrice = '';
        },
        removeProduct(index) {
            this.purchaseItems.splice(index, 1);
        },
        async submitPurchase() {
            if (!this.isFormValid) return;

            this.loading = true;
            try {
                const purchaseData = {
                    ...this.purchase,
                    purchase_no: this.generatePurchaseNo,
                    total_amount: this.totalAmount,
                    total_products: this.purchaseItems.length,
                    due_amount: this.dueAmount,
                    items: this.purchaseItems.map(item => ({
                        product_id: item.product_id,
                        quantity: item.quantity,
                        unit_price: item.unit_price,
                        total: item.total
                    }))
                };

                const response = await axios.post('/api/purchases', purchaseData);
                
                if (response && response.data) {
                    this.toast.success("Purchase created successfully!");
                    this.resetForm();
                    
                    setTimeout(() => {
                        window.location.href = route('all.purchase');
                    }, 2000);
                }
                
            } catch (error) {
                console.error('Error creating purchase:', error);
                const errorMessage = error.response?.data?.message || 
                                   error.message || 
                                   'Error creating purchase';
                this.toast.error(errorMessage);
            } finally {
                this.loading = false;
            }
        },
        resetForm() {
            this.purchase = {
                purchase_no: this.generatePurchaseNo,
                supplier_id: '',
                purchase_date: '',
                total_amount: 0,
                total_products: 0,
                payment_status: 'pending',
                paid_amount: 0,
                due_amount: 0,
                notes: '',
                status: 'pending'
            };

            this.selectedProduct = null;
            this.quantity = '';
            this.unitPrice = '';
            this.purchaseItems = [];
            this.supplierSearch = '';

            this.$nextTick(() => {
                if (this.$refs.purchaseForm) {
                    this.$refs.purchaseForm.reset();
                }
            });
        },
        setupSupplierSearchClickOutside() {
            document.addEventListener('click', (e) => {
                const searchContainer = document.querySelector('.supplier-search');
                if (searchContainer && !searchContainer.contains(e.target)) {
                    this.showSupplierResults = false;
                }
            });
        },
        handleSupplierAdded(newSupplier) {
            this.suppliers.push(newSupplier);
            this.purchase.supplier_id = newSupplier.id;
            this.showAddSupplierModal = false;
            this.toast.success('Supplier added successfully!');
        },
        handleProductAdded(newProduct) {
            this.products.push(newProduct);
            this.selectProduct(newProduct);
            this.showAddProductModal = false;
            this.toast.success('Product added successfully!');
        }
    },
    mounted() {
        this.fetchSuppliers();
        this.fetchProducts();
        this.purchase.purchase_no = this.generatePurchaseNo;
        this.setupSupplierSearchClickOutside();
    },
    beforeUnmount() {
        document.removeEventListener('click', this.setupSupplierSearchClickOutside);
    }
}
</script>

<style scoped>
.supplier-search {
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

.supplier-result-item {
    padding: 8px 12px;
    cursor: pointer;
}

.supplier-result-item:hover {
    background-color: #f8f9fa;
}

.supplier-status {
    margin-top: 0.5rem;
    padding: 8px 12px;
    border-radius: 4px;
}

.selected-supplier {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #198754;
    font-weight: 500;
}

.no-supplier-warning {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #dc3545;
    font-weight: 500;
}

.selected-supplier i,
.no-supplier-warning i {
    font-size: 1.1rem;
}

.quantity-control {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.qty-btn {
    padding: 0.25rem 0.5rem;
    border: 1px solid #dee2e6;
    background: #fff;
    cursor: pointer;
}

.qty-input {
    width: 60px;
    text-align: center;
}

.cart-items-container {
    margin-top: 1rem;
}

.table td {
    vertical-align: middle;
}

.btn-danger {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.product-search {
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

.product-result-item {
    padding: 8px 12px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.product-result-item:hover {
    background-color: #f8f9fa;
}

.product-code {
    color: #6c757d;
    font-size: 0.875em;
}

.input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.input-group .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.product-status {
    margin-top: 0.5rem;
    padding: 8px 12px;
    border-radius: 4px;
}

.selected-product {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #198754;
    font-weight: 500;
}

.no-product-warning {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #dc3545;
    font-weight: 500;
}

.selected-product i,
.no-product-warning i {
    font-size: 1.1rem;
}

.selected-product .product-code {
    color: #6c757d;
    font-size: 0.875em;
    font-weight: normal;
}
</style> 