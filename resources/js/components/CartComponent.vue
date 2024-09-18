<script>
import axios from 'axios';
import eventBus from './eventBus';

export default {
  data() {
    return {
      cartItems: [],
      cartSubtotal: 0, // Define cartSubtotal property
      cartCount: 0, // Define cartCount property
      cartTax: 0, // Define cartTax property
      cartTotal: 0, // Define cartTotal property
       customers: [],
      selectedCustomer: null,

    loggedInUser: '', // Add a new data property to store the authenticated user's name
    };
  },
 
  mounted() {
     this.fetchCustomers(); // Fetch the customers data on component mount
    this.fetchCartItems();
    eventBus.on('product-added', this.fetchCartItems);
    


     axios.get('/get-logged-in-user')
      .then(response => {
        this.loggedInUser = response.data.username;
      })
      .catch(error => {
        console.error(error);
        // Handle the error gracefully or provide user feedback
      });
  
  },
  beforeUnmounted() {
    eventBus.off('product-added', this.fetchCartItems);
  },
  methods: {
    fetchCartItems() {
      axios
        .get('/cart-items')
        .then(response => {
           this.cartItems = response.data.cartItems;
           this.cartSubtotal = response.data.cartSubtotal;
           this.cartCount = response.data.cartCount; // Assign the cartCount to a data property
           this.cartTax = response.data.cartTax;
           this.cartTotal = response.data.cartTotal;
           
        })
        .catch(error => {
          console.error(error);
          // Handle the error gracefully or provide user feedback
        });
    },

    fetchCustomers() {
      axios
      .get('/get-customers') // Adjust the route URL as per your project structure
        .then(response => {
          this.customers = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },

    decreaseValue(item) {
      if (item.qty > 0) {
        item.qty--;
        this.updateCart(item);
        this.updateCartCount();
      }
    },
    increaseValue(item) {
      // Add limit check if necessary
      item.qty++;
      this.updateCart(item);
      this.updateCartCount();
    },

    deleteCartItem(item) {
  const rowId = item.rowId;
  axios
    .delete(`/cart-items/${rowId}`)
    .then(response => {
      // Cart item deleted successfully, you can update the UI or perform any other necessary actions
      // For example, you can fetch the updated cart items
      this.fetchCartItems();
    })
    .catch(error => {
      console.error(error);
      // Handle the error gracefully or provide user feedback
    });
},


updateCart(item) {
      const rowId = item.rowId;
      const qty = item.qty;
      
      axios
        .post(`/cart-update/${rowId}`, { qty: qty })
        .then(response => {
          // Cart updated successfully on the server
           this.cartTotal = response.data.cartTotal;
          this.cartSubtotal = response.data.cartSubtotal;
        })
        .catch(error => {
          console.error(error);
          // Handle the error gracefully or provide user feedback
        });
    },


    updateCartCount() {
        axios.get('/cart-count')
            .then(response => {
                this.cartCount = response.data.cartCount;
            })
            .catch(error => {
                console.log(error);
            });
    },

    
  },
};


</script>

<template>


    <div class="col-xl-6 px-1">
        <div class="top-area-btns d-xl-none">
            <div class="show-on-mob text-center">
                <a href="#calculationArea" class="btn btn-green active-btn" type="button"><i class="fa fa-shopping-cart"></i> Cart</a>
                <a href="#productArea" class="btn btn-green" type="button"><i class="fa fa-shopping-bag"></i> Product</a>
            </div>
            <div class="right-part">
                <button class="btn btn-green" type="button" data-toggle="modal" data-target="#allSaleModal"><i class="fa fa-history"></i> <span>Your all sales</span></button>
                <button class="btn btn-green" type="button"><i class="fa fa-tachometer"></i> <span>Dashboard</span></button>
                <button class="btn btn-green" type="button"><i class="fa fa-sign-out"></i> <span>Logout</span></button>
            </div>
        </div>
        <div id="calculationArea" class="calculation-area">
            <div class="top-area">
                <div class="input-group">
                    Logged in: {{ loggedInUser }}
                </div>
        <div class="input-group">
                  <select class="form-control" v-model="selectedCustomer" id="editable-select" placeholder="Choose Customer">
                <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                  {{ customer.name }}
                        </option>
                    </select>
        </div>
                <div class="edit-icon">
                    <button class="btn fa-btn" type="button" data-toggle="modal" data-target="#editCustomer"><i class="fa fa-pencil"></i></button>
                    <button class="btn fa-btn" type="button" data-toggle="modal" data-target="#addCustomer"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="cart-table">
                <table class="table">
                    <thead class="">
                    <tr>
                        <th scope="col">Item</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="cartItems.length === 0">
                        <td colspan="5" class="text-center">
                        <h1>Add Items, Your Cart is empty</h1>
                        </td>
                    </tr>
                    <tr v-for="item in cartItems" :key="item.id" class="table-row">
                        <td scope="col">{{ item.name }}</td>
                        <td scope="col">Ksh {{ item.price }}</td>
                        <td scope="col" class="inc-dec">
                          <button class="btn value-button" @click="decreaseValue(item)" value="Decrease Value">-</button>
                          <input class="form-control" type="" id="number" :value="item.qty" />
                          <button class="btn value-button" @click="increaseValue(item)" value="Increase Value">+</button>
                        </td>
                       
                        <td scope="col">Ksh {{item.price * item.qty }}</td>
                       <td class="edit-btn">
                          <button type="button" class="btn fa-btn delme" data-toggle="tooltip" title="Delete me" @click="deleteCartItem(item)">
  <i class="fa fa-trash-o"></i>
</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>



            
            <div class="final-calculation">
  <div class="top-section">
    <div class="column">
      <div>Total Items: <span>{{ cartCount }}</span></div>
    </div>
    <div class="column">
      <input type="text" class="reference-input" placeholder="Reference no." />
    </div>
    <div class="column">
      <div>Tax: Ksh <span>{{ cartTax }}</span></div>
    </div>
  </div>

  <div class="payable-section">
    <div>Total Payable</div>
    <div class="highlighted-total">Ksh {{ cartTotal }}.00</div>
  </div>
</div>

            
        </div>
        <div class="bottom-area-btns">
            <button class="btn btn-4" type="button" data-toggle="modal" data-target="#"><i class="fa fa-times-circle"></i> Cancel</button>
            <button class="btn btn-6" type="button" data-toggle="modal" data-target="#paymentModal"><i class="fa fa-credit-card"></i> Pay Now</button>
            <button class="btn btn-7" type="button" data-toggle="modal" data-target="#holdBox"><i class="fa fa-hand-rock-o"></i> Hold</button>
        </div>
    </div>

</template>
<style>
.final-calculation {
  display: flex;
  flex-direction: column;
  align-items: center; /* Center content horizontally */
  padding: 20px;
}

.top-section {
  display: flex;
  justify-content: space-between;
  width: 100%;
  margin-bottom: 20px;
}

.column {
  flex: 1;
  text-align: center;
}

.reference-input {
  width: 80%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin: 0 auto;
}

.payable-section {
  text-align: center;
  background-color: #f8f9fa; /* Light background to highlight the total */
  padding: 10px;
  border-radius: 8px;
  width: 100%;
}

.highlighted-total {
  font-size: 24px;
  font-weight: bold;
  color: #28a745; /* Green color to highlight total */
  background-color: #e9ffe9; /* Light green background */
  padding: 10px;
  border-radius: 5px;
  margin-top: 10px;
}

</style>