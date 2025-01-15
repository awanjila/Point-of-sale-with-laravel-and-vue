<template>
  <div v-if="showModal" class="modal-overlay">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Add New Supplier</h3>
        <button class="close-btn" @click="$emit('closeModal')">&times;</button>
      </div>

      <div class="modal-body">
        <form @submit.prevent="handleSubmit" class="supplier-form">
          <!-- Show validation errors if any -->
          <div v-if="errors" class="alert alert-danger">
            <ul class="mb-0">
              <li v-for="(error, field) in errors" :key="field">
                {{ error[0] }}
              </li>
            </ul>
          </div>

          <div class="form-group">
            <label for="name">Supplier Name*</label>
            <input 
              type="text" 
              id="name" 
              v-model="formData.name"
              class="form-control"
              :class="{ 'is-invalid': errors?.name }"
              required
            >
            <div v-if="errors?.name" class="invalid-feedback">
              {{ errors.name[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="email">Email*</label>
            <input 
              type="email" 
              id="email" 
              v-model="formData.email"
              class="form-control"
              :class="{ 'is-invalid': errors?.email }"
              required
            >
            <div v-if="errors?.email" class="invalid-feedback">
              {{ errors.email[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="phone">Phone*</label>
            <input 
              type="tel" 
              id="phone" 
              v-model="formData.phone"
              class="form-control"
              :class="{ 'is-invalid': errors?.phone }"
              required
            >
            <div v-if="errors?.phone" class="invalid-feedback">
              {{ errors.phone[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="company">Company*</label>
            <input 
              type="text" 
              id="company" 
              v-model="formData.company"
              class="form-control"
              :class="{ 'is-invalid': errors?.company }"
              required
            >
            <div v-if="errors?.company" class="invalid-feedback">
              {{ errors.company[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="type">Type</label>
            <input 
              type="text" 
              id="type" 
              v-model="formData.type"
              class="form-control"
              :class="{ 'is-invalid': errors?.type }"
            >
            <div v-if="errors?.type" class="invalid-feedback">
              {{ errors.type[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <textarea 
              id="address" 
              v-model="formData.address"
              class="form-control"
              :class="{ 'is-invalid': errors?.address }"
              rows="2"
            ></textarea>
            <div v-if="errors?.address" class="invalid-feedback">
              {{ errors.address[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="location">Location</label>
            <input 
              type="text" 
              id="location" 
              v-model="formData.location"
              class="form-control"
              :class="{ 'is-invalid': errors?.location }"
            >
            <div v-if="errors?.location" class="invalid-feedback">
              {{ errors.location[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="photo">Photo</label>
            <input 
              type="file" 
              id="photo" 
              @change="handlePhotoUpload"
              class="form-control"
              :class="{ 'is-invalid': errors?.photo }"
              accept="image/*"
            >
            <div v-if="errors?.photo" class="invalid-feedback">
              {{ errors.photo[0] }}
            </div>
          </div>

          <div class="button-group">
            <button type="button" class="btn btn-secondary" @click="$emit('closeModal')">Cancel</button>
            <button type="submit" class="btn btn-primary" :disabled="loading">
              {{ loading ? 'Adding...' : 'Add Supplier' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  showModal: Boolean
});

const emit = defineEmits(['closeModal', 'supplierAdded']);

const loading = ref(false);
const errors = ref(null);
const formData = ref({
  name: '',
  email: '',
  phone: '',
  company: '',
  type: '',
  address: '',
  location: '',
  photo: null
});

const handlePhotoUpload = (event) => {
  formData.value.photo = event.target.files[0];
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

    const response = await axios.post('/api/suppliers', submitData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    emit('supplierAdded', response.data.supplier);
    emit('closeModal');
    
    // Reset form
    formData.value = {
      name: '',
      email: '',
      phone: '',
      company: '',
      type: '',
      address: '',
      location: '',
      photo: null
    };

  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      console.error('Error adding supplier:', error);
      alert('Failed to add supplier. Please try again.');
    }
  } finally {
    loading.value = false;
  }
};
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
  max-width: 500px;
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

.supplier-form {
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

.alert ul {
  padding-left: 1.25rem;
  margin-bottom: 0;
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