<template>
  <div v-if="showModal" class="modal-overlay">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Add New Product</h3>
        <button class="close-btn" @click="$emit('closeModal')">&times;</button>
      </div>

      <div class="modal-body">
        <form @submit.prevent="handleSubmit" class="product-form">
          <div v-if="errors" class="alert alert-danger">
            <ul class="mb-0">
              <li v-for="(error, field) in errors" :key="field">
                {{ error[0] }}
              </li>
            </ul>
          </div>

          <div class="form-group">
            <label for="product_name">Product Name*</label>
            <input 
              type="text" 
              id="product_name" 
              v-model="formData.product_name"
              class="form-control"
              :class="{ 'is-invalid': errors?.product_name }"
              required
            >
          </div>

          <div class="form-group">
            <label for="category_id">Category*</label>
            <select 
              id="category_id" 
              v-model="formData.category_id"
              class="form-control"
              :class="{ 'is-invalid': errors?.category_id }"
              required
            >
              <option value="">Select Category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="supplier_id">Supplier*</label>
            <select 
              id="supplier_id" 
              v-model="formData.supplier_id"
              class="form-control"
              :class="{ 'is-invalid': errors?.supplier_id }"
              required
            >
              <option value="">Select Supplier</option>
              <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                {{ supplier.name }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="product_code">Product Code*</label>
            <input 
              type="text" 
              id="product_code" 
              v-model="formData.product_code"
              class="form-control"
              :class="{ 'is-invalid': errors?.product_code }"
              required
            >
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="buying_price">Buying Price</label>
                <input 
                  type="number" 
                  id="buying_price" 
                  v-model="formData.buying_price"
                  class="form-control"
                  :class="{ 'is-invalid': errors?.buying_price }"
                >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="selling_price">Selling Price</label>
                <input 
                  type="number" 
                  id="selling_price" 
                  v-model="formData.selling_price"
                  class="form-control"
                  :class="{ 'is-invalid': errors?.selling_price }"
                >
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="buying_date">Buying Date</label>
                <input 
                  type="date" 
                  id="buying_date" 
                  v-model="formData.buying_date"
                  class="form-control"
                  :class="{ 'is-invalid': errors?.buying_date }"
                >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="expire_date">Expire Date</label>
                <input 
                  type="date" 
                  id="expire_date" 
                  v-model="formData.expire_date"
                  class="form-control"
                  :class="{ 'is-invalid': errors?.expire_date }"
                >
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="product_store">Store Location</label>
            <input 
              type="text" 
              id="product_store" 
              v-model="formData.product_store"
              class="form-control"
              :class="{ 'is-invalid': errors?.product_store }"
            >
          </div>

          <div class="form-group">
            <label for="product_image">Product Image</label>
            <input 
              type="file" 
              id="product_image" 
              @change="handleImageUpload"
              class="form-control"
              :class="{ 'is-invalid': errors?.product_image }"
              accept="image/*"
            >
          </div>

          <div class="button-group">
            <button type="button" class="btn btn-secondary" @click="$emit('closeModal')">Cancel</button>
            <button type="submit" class="btn btn-primary" :disabled="loading">
              {{ loading ? 'Adding...' : 'Add Product' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
  showModal: Boolean
});

const emit = defineEmits(['closeModal', 'productAdded']);

const loading = ref(false);
const errors = ref(null);
const categories = ref([]);
const suppliers = ref([]);

const formData = ref({
  product_name: '',
  category_id: '',
  supplier_id: '',
  product_code: '',
  buying_price: '',
  selling_price: '',
  buying_date: '',
  expire_date: '',
  product_store: '',
  product_image: null
});

const fetchCategories = async () => {
  try {
    const response = await axios.get('/api/categories');
    categories.value = response.data;
  } catch (error) {
    console.error('Error fetching categories:', error);
  }
};

const fetchSuppliers = async () => {
  try {
    const response = await axios.get('/api/suppliers');
    suppliers.value = response.data;
  } catch (error) {
    console.error('Error fetching suppliers:', error);
  }
};

const handleImageUpload = (event) => {
  formData.value.product_image = event.target.files[0];
};

const handleSubmit = async () => {
  try {
    loading.value = true;
    errors.value = null;
    
    const submitData = new FormData();
    Object.keys(formData.value).forEach(key => {
      if (formData.value[key] !== null && formData.value[key] !== '') {
        submitData.append(key, formData.value[key]);
      }
    });

    const response = await axios.post('/api/products', submitData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    emit('productAdded', response.data.product);
    emit('closeModal');
    
    // Reset form
    formData.value = {
      product_name: '',
      category_id: '',
      supplier_id: '',
      product_code: '',
      buying_price: '',
      selling_price: '',
      buying_date: '',
      expire_date: '',
      product_store: '',
      product_image: null
    };

  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      console.error('Error adding product:', error);
      alert('Failed to add product. Please try again.');
    }
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchCategories();
  fetchSuppliers();
});
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050;
}

.modal-content {
  background: white;
  border-radius: 8px;
  width: 90%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #dee2e6;
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}

.modal-body {
  padding: 1rem;
}

.product-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 1rem;
}

.alert {
  padding: 0.75rem 1.25rem;
  margin-bottom: 1rem;
  border: 1px solid transparent;
  border-radius: 0.25rem;
}

.alert-danger {
  color: #721c24;
  background-color: #f8d7da;
  border-color: #f5c6cb;
}

.invalid-feedback {
  display: block;
  width: 100%;
  margin-top: 0.25rem;
  font-size: 0.875em;
  color: #dc3545;
}

.is-invalid {
  border-color: #dc3545;
}
</style> 