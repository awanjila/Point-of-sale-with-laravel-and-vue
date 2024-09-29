<template>
  <!-- Show modal only when showModal prop is true -->
  <div v-if="showModal" class="modal-backdrop">
    <div class="modal-container">
      <!-- Close button in red with click functionality -->
      <button class="close-button" @click="closeModal"> 
        X
      </button>

      <h2 class="modal-title">Add New Customer</h2>
      
      <!-- Customer Form -->
      <form @submit.prevent="handleSubmit" class="customer-form">
        <!-- Two inputs per row -->
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
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

// Initialize the toast notification
const toast = useToast();

const form = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  location: '',
});

const props = defineProps({
  showModal: Boolean,
  closeModal: Function,
});

// Handle form submission
const handleSubmit = async () => {
  try {
    // Send a POST request with form data to your server
    const response = await axios.post('/api/customers', form.value);

    // Handle success response
    if (response.status === 201 || response.status === 200) {
      // Show a success notification
      toast.success('Customer added successfully!');

      // Optionally, clear the form after submission
      form.value = {
        name: '',
        email: '',
        phone: '',
        address: '',
        location: '',
      };

      // Close the modal
      props.closeModal();
    }
  } catch (error) {
    // Show an error notification if the request fails
    if (error.response) {
      // Server responded with a status code that falls out of the range of 2xx
      const errors = error.response.data.errors; // Adjust based on your API response
      if (errors) {
        // Handle validation errors
        for (const key in errors) {
          // Show each validation error as a toast notification
          toast.error(`${key}: ${errors[key].join(', ')}`);
        }
      } else {
        // Generic error message for other types of errors
        toast.error('Failed to add customer. Please try again.');
      }
    } else {
      // Network or other errors
      toast.error('Failed to add customer. Please check your network connection.');
    }

    console.error(error);
  }
};
</script>



<style scoped>
/* Modal backdrop */
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.7); /* Darker backdrop */
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Modal container */
.modal-container {
  background-color: white;
  padding: 3rem 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  width: 50%; /* Adjust width for better form layout */
  max-width: 600px; /* Ensure responsiveness */
  position: relative;
}

/* Red Close button in the top-right corner */
.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: red;
  color: white;
  border: none;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  cursor: pointer;
}

.close-button:hover {
  background-color: darkred;
}

/* Form title */
.modal-title {
  text-align: center;
  margin-bottom: 20px;
  font-size: 1.5em;
}

/* Form layout */
.customer-form .form-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.customer-form .form-group {
  flex: 1;
  margin-right: 10px;
}

.customer-form .form-group:last-child {
  margin-right: 0;
}

/* Full width row for the address */
.full-width .form-group {
  width: 100%;
}

/* Buttons */
.form-buttons {
  text-align: center;
  margin-top: 20px;
}

.btn-primary {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn-primary:hover {
  background-color: #0056b3;
}

/* Input fields */
.form-control {
  width: 100%;
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ced4da;
  border-radius: 5px;
}

.form-control:focus {
  border-color: #007bff;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
}

/* Textarea for address */
textarea.form-control {
  resize: vertical;
  min-height: 100px;
}
</style>
