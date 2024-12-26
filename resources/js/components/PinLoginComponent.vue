<template>
  <div class="pin-login-container">
    <div class="login-wrapper">
      <div class="login-header">
        <img :src="'/assets/images/logo-dark.png'" alt="Wabe Point Logo" class="logo">
        <h2>Secure Login</h2>
      </div>

      <div class="login-description">
        <p>Enter your 4-digit PIN to access the system</p>
      </div>

      <div class="pin-display-container">
        <div class="pin-display">
          <input 
            type="password" 
            v-model="pinDisplay" 
            readonly 
            placeholder="Enter PIN"
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

      <div class="login-info">
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
        class="submit-btn glowing-btn" 
        :disabled="pin.length < 4"
      >
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
  font-family: 'Arial', sans-serif;
}

.login-wrapper {
  background: white;
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(0,0,0,0.1);
  padding: 40px;
  width: 350px;
  text-align: center;
}

.login-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 20px;
}

.logo {
  width: 120px;
  margin-bottom: 15px;
}

.login-header h2 {
  color: #333;
  margin: 0;
  font-weight: 700;
}

.login-description {
  color: #666;
  margin-bottom: 20px;
}

.pin-display-container {
  background: #f4f4f4;
  border-radius: 10px;
  padding: 15px;
  margin-bottom: 20px;
}

.pin-display {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.pin-input {
  width: 100%;
  text-align: center;
  letter-spacing: 15px;
  font-size: 24px;
  border: none;
  background: transparent;
  color: #333;
}

.clear-btn {
  position: absolute;
  right: 0;
  background: none;
  border: none;
  color: #666;
  cursor: pointer;
}

.keypad {
  display: grid;
  gap: 10px;
  margin-bottom: 20px;
}

.keypad-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}

.keypad-btn {
  background: #f4f4f4;
  border: none;
  border-radius: 10px;
  padding: 15px;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.keypad-btn:hover {
  background: #e0e0e0;
  transform: scale(1.05);
}

.empty-btn {
  background: transparent;
  cursor: default;
}

.submit-btn {
  width: 100%;
  padding: 15px;
  background: linear-gradient(to right, #667eea, #764ba2);
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.glowing-btn {
  box-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
  animation: glowing 1.5s infinite;
}

@keyframes glowing {
  0% { box-shadow: 0 0 5px rgba(102, 126, 234, 0.3); }
  50% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.6); }
  100% { box-shadow: 0 0 5px rgba(102, 126, 234, 0.3); }
}

.submit-btn:hover {
  transform: scale(1.02);
  background: linear-gradient(to right, #764ba2, #667eea);
}

.submit-btn:disabled {
  background: #cccccc;
  cursor: not-allowed;
  animation: none;
  box-shadow: none;
}

.login-info {
  margin-top: 20px;
}

.user-types {
  display: flex;
  justify-content: center;
  gap: 20px;
  color: #666;
}

.user-type {
  display: flex;
  align-items: center;
  gap: 10px;
}

.user-type i {
  color: #667eea;
}
</style>