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

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Supplier</label>
                                    <select 
                                        class="form-select" 
                                        v-model="purchase.supplier_id"
                                        required
                                    >
                                        <option value="">Select Supplier</option>
                                        <option 
                                            v-for="supplier in suppliers" 
                                            :key="supplier.id" 
                                            :value="supplier.id"
                                        >
                                            {{ supplier.name }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Product Selection -->
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Add Products</h5>
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <select 
                                                        class="form-select" 
                                                        v-model="selectedProduct"
                                                    >
                                                        <option value="">Select Product</option>
                                                        <option 
                                                            v-for="product in products" 
                                                            :key="product.id" 
                                                            :value="product"
                                                        >
                                                            {{ product.product_name }}
                                                        </option>
                                                    </select>
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
            purchaseItems: []
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
        addProduct() {
            if (!this.selectedProduct || !this.quantity || !this.unitPrice) {
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
                    
                    // Use route() helper for redirection
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
            // Reset main purchase object
            this.purchase = {
                purchase_no: this.generatePurchaseNo, // Generate new purchase number
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

            // Reset product selection
            this.selectedProduct = null;
            this.quantity = '';
            this.unitPrice = '';

            // Clear purchase items
            this.purchaseItems = [];

            // Reset any validation states if you have them
            this.$nextTick(() => {
                // This ensures the form is reset after the DOM updates
                if (this.$refs.purchaseForm) {
                    this.$refs.purchaseForm.reset();
                }
            });
        }
    },
    mounted() {
        this.fetchSuppliers();
        this.fetchProducts();
        this.purchase.purchase_no = this.generatePurchaseNo;
    }
}
</script> 