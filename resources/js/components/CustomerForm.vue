<template>
  <ModalWrapper :show="showModal" @close="closeModal">
    <h2>Add New Customer</h2>

    <!-- Customer Form -->
    <form @submit.prevent="handleSubmit" class="customer-form">
      <!-- First Row (Full Name, Email) -->
      <div class="form-row">
        <div class="form-group">
          <label for="name">Full Name</label>
          <input
            v-model="form.name"
            type="text"
            id="name"
            class="form-control"
            placeholder="Enter full name"
            required
          />
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input
            v-model="form.email"
            type="email"
            id="email"
            class="form-control"
            placeholder="Enter email"
            required
          />
        </div>
      </div>

      <!-- Second Row (Phone, Location) -->
      <div class="form-row">
        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input
            v-model="form.phone"
            type="tel"
            id="phone"
            class="form-control"
            placeholder="Enter phone number"
            required
          />
        </div>

        <div class="form-group">
          <label for="location">Location</label>
          <input
            v-model="form.location"
            type="text"
            id="location"
            class="form-control"
            placeholder="Enter location"
          />
        </div>
      </div>

      <!-- Full-Width Row (Address) -->
      <div class="form-row full-width">
        <div class="form-group">
          <label for="address">Address</label>
          <textarea
            v-model="form.address"
            id="address"
            class="form-control"
            placeholder="Enter address"
          ></textarea>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-buttons">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </ModalWrapper>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import ModalWrapper from './ModalWrapper.vue';

export default {
  components: { ModalWrapper },
  props: {
    showModal: Boolean, // Modal visibility passed from parent
  },
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        address: '',
        location: '',
      },
    };
  },
  methods: {
    async handleSubmit() {
      const toast = useToast();
      try {
        const response = await axios.post('/api/customers', this.form);

        if (response.status === 201 || response.status === 200) {
          toast.success('Customer added successfully!');
          this.clearForm();
          this.$emit('closeModal'); // Emit closeModal event to parent
        }
      } catch (error) {
        this.handleErrors(error, toast);
      }
    },
    clearForm() {
      this.form = {
        name: '',
        email: '',
        phone: '',
        address: '',
        location: '',
      };
    },
    handleErrors(error, toast) {
      if (error.response && error.response.data.errors) {
        Object.keys(error.response.data.errors).forEach((key) => {
          toast.error(`${key}: ${error.response.data.errors[key].join(', ')}`);
        });
      } else {
        toast.error('Failed to add customer. Please try again.');
      }
    },
    closeModal() {
      this.$emit('closeModal'); // Emit closeModal event to parent
    },
  },
};
</script>

<style scoped>
.customer-form {
  max-width: 600px;
  margin: 0 auto;
}

.form-row {
  display: flex;
  justify-content: space-between;
  gap: 20px;
}

.form-group {
  flex: 1;
  margin-bottom: 20px;
}

textarea {
  resize: vertical;
}

.form-buttons {
  text-align: center;
}
</style>
