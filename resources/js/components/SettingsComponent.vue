<template>
  <div class="settings-container">
    <div class="settings-header">
      <h2>Business Settings</h2>
    </div>

    <form @submit.prevent="updateSettings" class="settings-form">
      <div class="form-row">
        <div class="form-group">
          <label>Business Name</label>
          <input 
            type="text" 
            v-model="settings.business_name" 
            :placeholder="settings.business_name || 'Enter Business Name'"
            required
            minlength="3"
            maxlength="100"
          />
          <div v-if="validationErrors.business_name" class="error-message">
            {{ validationErrors.business_name }}
          </div>
        </div>
        <div class="form-group">
          <label>Business Email</label>
          <input 
            type="email" 
            v-model="settings.business_email" 
            :placeholder="settings.business_email || 'Enter Business Email'"
            required
            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
          />
          <div v-if="validationErrors.business_email" class="error-message">
            {{ validationErrors.business_email }}
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Business Phone</label>
          <input 
            type="tel" 
            v-model="settings.business_phone" 
            :placeholder="settings.business_phone || 'Enter Phone Number'"
            required
            pattern="^[0-9]{10}$"
          />
          <div v-if="validationErrors.business_phone" class="error-message">
            {{ validationErrors.business_phone }}
          </div>
        </div>
        <div class="form-group">
          <label>Business Address</label>
          <input 
            type="text" 
            v-model="settings.business_address" 
            :placeholder="settings.business_address || 'Enter Business Address'"
            required
            minlength="5"
            maxlength="200"
          />
          <div v-if="validationErrors.business_address" class="error-message">
            {{ validationErrors.business_address }}
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Tax Percentage</label>
          <input 
            type="number" 
            v-model="settings.tax_percentage" 
            :placeholder="settings.tax_percentage || 'Enter Tax %'"
            step="0.01"
            min="0"
            max="100"
            required
          />
          <div v-if="validationErrors.tax_percentage" class="error-message">
            {{ validationErrors.tax_percentage }}
          </div>
        </div>
        <div class="form-group">
          <label>Currency</label>
          <input 
            type="text" 
            v-model="settings.currency" 
            :placeholder="settings.currency || 'Enter Currency'"
            required
            minlength="2"
            maxlength="5"
          />
          <div v-if="validationErrors.currency" class="error-message">
            {{ validationErrors.currency }}
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Till Number</label>
          <input 
            type="text" 
            v-model="settings.till_number" 
            :placeholder="settings.till_number || 'Enter Till Number'"
            minlength="3"
            maxlength="20"
          />
          <div v-if="validationErrors.till_number" class="error-message">
            {{ validationErrors.till_number }}
          </div>
        </div>
      </div>

      <div class="form-group full-width">
        <label>Receipt Header</label>
        <textarea 
          v-model="settings.receipt_header" 
          :placeholder="settings.receipt_header || 'Enter Receipt Header'"
          maxlength="500"
        ></textarea>
        <div v-if="validationErrors.receipt_header" class="error-message">
          {{ validationErrors.receipt_header }}
        </div>
      </div>

      <div class="form-group full-width">
        <label>Receipt Footer</label>
        <textarea 
          v-model="settings.receipt_footer" 
          :placeholder="settings.receipt_footer || 'Enter Receipt Footer'"
          maxlength="500"
        ></textarea>
        <div v-if="validationErrors.receipt_footer" class="error-message">
          {{ validationErrors.receipt_footer }}
        </div>
      </div>

      <div class="form-group full-width">
        <label>Business Logo</label>
        <input 
          type="file" 
          @change="handleLogoUpload"
          accept="image/*"
        />
        <div v-if="settings.logo_path" class="logo-preview">
          <img :src="logoPreview" alt="Business Logo" />
        </div>
      </div>

      <div class="form-actions">
        <button 
          type="submit" 
          class="btn btn-primary" 
          :disabled="loading"
        >
          {{ loading ? 'Updating...' : 'Update Settings' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  data() {
    return {
      settings: {
        business_name: '',
        business_email: '',
        business_phone: '',
        business_address: '',
        tax_percentage: null,
        currency: '',
        till_number: '',
        receipt_header: '',
        receipt_footer: '',
        logo_path: null
      },
      logoFile: null,
      logoPreview: null,
      loading: false,
      validationErrors: {}
    };
  },
  mounted() {
    this.fetchSettings();
  },
  methods: {
    validateForm() {
      this.validationErrors = {};

      // Business Name validation
      if (!this.settings.business_name || this.settings.business_name.length < 3) {
        this.validationErrors.business_name = 'Business name must be at least 3 characters long';
      }

      // Email validation
      const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!this.settings.business_email || !emailRegex.test(this.settings.business_email)) {
        this.validationErrors.business_email = 'Please enter a valid email address';
      }

      // Phone validation (10 digit number)
      const phoneRegex = /^[0-9]{10}$/;
      if (!this.settings.business_phone || !phoneRegex.test(this.settings.business_phone)) {
        this.validationErrors.business_phone = 'Phone number must be 10 digits';
      }

      // Address validation
      if (!this.settings.business_address || this.settings.business_address.length < 5) {
        this.validationErrors.business_address = 'Address must be at least 5 characters long';
      }

      // Tax Percentage validation
      if (this.settings.tax_percentage === null || this.settings.tax_percentage < 0 || this.settings.tax_percentage > 100) {
        this.validationErrors.tax_percentage = 'Tax percentage must be between 0 and 100';
      }

      // Currency validation
      if (!this.settings.currency || this.settings.currency.length < 2 || this.settings.currency.length > 5) {
        this.validationErrors.currency = 'Currency must be 2-5 characters long';
      }

      // Till Number validation (optional)
      if (this.settings.till_number && (this.settings.till_number.length < 3 || this.settings.till_number.length > 20)) {
        this.validationErrors.till_number = 'Till number must be 3-20 characters long';
      }

      // Receipt Header validation
      if (this.settings.receipt_header && this.settings.receipt_header.length > 500) {
        this.validationErrors.receipt_header = 'Receipt header cannot exceed 500 characters';
      }

      // Receipt Footer validation
      if (this.settings.receipt_footer && this.settings.receipt_footer.length > 500) {
        this.validationErrors.receipt_footer = 'Receipt footer cannot exceed 500 characters';
      }

      // Return true if no errors
      return Object.keys(this.validationErrors).length === 0;
    },
    async updateSettings() {
      // Validate form first
      if (!this.validateForm()) {
        useToast().error('Please correct the errors in the form');
        return;
      }

      this.loading = true;
      const toast = useToast();

      try {
        const formData = new FormData();
        
        // Append all settings, ensuring no null values
        Object.keys(this.settings).forEach(key => {
          const value = this.settings[key];
          if (value !== null && value !== '') {
            formData.append(key, value);
          }
        });

        // Append logo if selected
        if (this.logoFile) {
          formData.append('logo', this.logoFile);
        }

        // Log form data for debugging
        for (let pair of formData.entries()) {
          console.log(pair[0] + ': ' + pair[1]);
        }

        const response = await axios.post('/api/settings', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        toast.success('Settings updated successfully');
        this.settings = response.data.settings;
      } catch (error) {
        toast.error('Failed to update settings');
        console.error('Error details:', error.response ? error.response.data : error);
      } finally {
        this.loading = false;
      }
    },
    async fetchSettings() {
      try {
        const response = await axios.get('/api/settings');
        this.settings = response.data;
        
        // Set logo preview if exists
        if (response.data.logo_url) {
          this.logoPreview = response.data.logo_url;
        }
      } catch (error) {
        useToast().error('Failed to load settings');
      }
    },
    handleLogoUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.logoFile = file;
        
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          this.logoPreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }
  }
};
</script>

<style scoped>
.settings-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.settings-header {
  text-align: center;
  margin-bottom: 20px;
}

.settings-form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-row {
  display: flex;
  gap: 15px;
}

.form-group {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.form-group label {
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input,
.form-group textarea {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.full-width {
  width: 100%;
}

.logo-preview img {
  max-width: 200px;
  max-height: 200px;
  object-fit: contain;
  margin-top: 10px;
}

.form-actions {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.btn-primary {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn-primary:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

@media (max-width: 768px) {
  .form-row {
    flex-direction: column;
  }
}

.error-message {
  color: red;
  font-size: 0.8em;
  margin-top: 5px;
}

.form-group {
  position: relative;
}
</style> 