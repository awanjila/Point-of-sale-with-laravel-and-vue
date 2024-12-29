<template>
  <div class="pin-login-container">
    <div class="login-wrapper">
      <div class="login-header mb-5">
        <h2 class="fw-bold mb-2">Secure Access</h2>
        <p class="text-muted">Enter your 4-digit PIN to continue</p>
      </div>

      <div class="pin-display-container">
        <div class="pin-display">
          <input 
            type="password" 
            v-model="pinDisplay" 
            readonly 
            placeholder="• • • •"
            class="pin-input"
          />
          <button 
            v-if="pin.length > 0" 
            @click="clearPin" 
            class="clear-btn"
          >
            <i class="fas fa-backspace"></i>
          </button>
        </div>
      </div>

      <div class="keypad">
        <div class="keypad-row" v-for="row in keypadLayout" :key="row.join('-')">
          <button 
            v-for="key in row" 
            :key="key" 
            @click="addDigit(key)"
            class="keypad-btn"
            :class="{'empty-btn': key === ''}"
          >
            {{ key }}
          </button>
        </div>
      </div>

      <div class="login-info mt-4">
        <div class="user-types">
          <div class="user-type">
            <i class="fas fa-user-shield"></i>
            <span>Admin PIN: 1111</span>
          </div>
          <div class="user-type">
            <i class="fas fa-user"></i>
            <span>Staff PIN: 2222</span>
          </div>
        </div>
      </div>

      <button 
        @click="submitPin" 
        class="submit-btn" 
        :disabled="pin.length < 4"
      >
        <i class="fas fa-arrow-right me-2"></i>
        Login
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  data() {
    return {
      pin: '',
      keypadLayout: [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
        ['', 0, '']
      ],
      toast: useToast()
    };
  },
  computed: {
    pinDisplay() {
      return this.pin.replace(/./g, '•');
    }
  },
  methods: {
    addDigit(digit) {
      if (digit !== '' && this.pin.length < 4) {
        this.pin += digit;
      }
    },
    clearPin() {
      this.pin = this.pin.slice(0, -1);
    },
    async submitPin() {
      if (this.pin.length !== 4) {
        this.toast.error('PIN must be 4 digits');
        return;
      }

      try {
        const response = await axios.post('/login', { 
          pin: this.pin,
          login_type: 'pin'
        });

        if (response.data.success) {
          this.toast.success('Login Successful');
          window.location.href = response.data.redirect;
        } else {
          this.toast.error(response.data.message || 'Invalid PIN');
        }
      } catch (error) {
        this.toast.error('Login failed. Please try again.');
        console.error('Login error:', error);
      }
    }
  }
};
</script>

<style scoped>
.pin-login-container {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: 'Inter', sans-serif;
}

.login-wrapper {
  width: 100%;
  max-width: 480px;
  padding: 2rem;
}

.login-header h2 {
  font-size: 2.5rem;
  color: #1a1a1a;
  margin-bottom: 0.5rem;
}

.pin-display-container {
  background: #f8f9fa;
  border-radius: 16px;
  padding: 1.5rem;
  margin: 2rem 0;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
}

.pin-display {
  position: relative;
}

.pin-input {
  width: 100%;
  text-align: center;
  letter-spacing: 1.5rem;
  font-size: 2.5rem;
  border: none;
  background: transparent;
  color: #1a1a1a;
  padding: 1rem 0;
  font-weight: 600;
}

.pin-input::placeholder {
  color: #dee2e6;
}

.clear-btn {
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: #6c757d;
  cursor: pointer;
  padding: 0.5rem;
  transition: color 0.2s;
}

.clear-btn:hover {
  color: #1a1a1a;
}

.keypad {
  display: grid;
  gap: 1rem;
  margin: 2rem 0;
}

.keypad-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
}

.keypad-btn {
  background: white;
  border: 1px solid #e9ecef;
  border-radius: 12px;
  padding: 1.5rem;
  font-size: 1.5rem;
  font-weight: 500;
  color: #1a1a1a;
  cursor: pointer;
  transition: all 0.2s;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.keypad-btn:hover {
  background: #f8f9fa;
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.keypad-btn:active {
  transform: translateY(0);
}

.empty-btn {
  background: transparent;
  border: none;
  box-shadow: none;
  cursor: default;
}

.empty-btn:hover {
  background: transparent;
  transform: none;
  box-shadow: none;
}

.submit-btn {
  width: 100%;
  padding: 1rem;
  font-size: 1.1rem;
  font-weight: 500;
  color: white;
  background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
  border: none;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s;
  box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
}

.submit-btn:not(:disabled):hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 8px rgba(13, 110, 253, 0.3);
}

.submit-btn:disabled {
  background: #e9ecef;
  cursor: not-allowed;
  box-shadow: none;
}

.user-types {
  display: flex;
  justify-content: center;
  gap: 2rem;
  color: #6c757d;
  margin: 2rem 0;
  font-size: 0.9rem;
}

.user-type {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  background: #f8f9fa;
  border-radius: 8px;
  transition: all 0.2s;
}

.user-type:hover {
  background: #e9ecef;
}

.user-type i {
  color: #0d6efd;
}
</style>