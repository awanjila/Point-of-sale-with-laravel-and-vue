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
                <table class="table">
                    <tbody>
                    <tr class="table-row">
                        <td>
                            <table class="table mini-table mb-0">
                                <tbody>
                                <tr class="table-row">
                                    <td>Total Item: <span>{{ cartCount }}</span></td>
                                    <td></td>
                                    <td><i class="fa fa-file fa-green" data-toggle="modal" data-target="#typeNoteBox"></i></td>
                                    <td><input type="" class="form-control" placeholder="Reference no."></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>Sub Total</td>
                        <td>Ksh <span>{{ cartSubtotal }}</span></td>
                    </tr>
                   
                    <tr class="table-row">
                        <td></td>
                        <td>Tax</td>
                        <td>Ksh <span>{{cartTax}}</span></td>
                    </tr>
                  
                    <tr class="table-row">
                        <td></td>
                        <td>Total Payable</td>
                        <td>Ksh <span>{{ cartTotal }}</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="calculator">
                <div class="displayBox">
                    <p class="displayText" id="display">0</p>
                </div>
                <table>
                    <tr>
                        <td><button class="btn clear hvr-back-pulse" id="clear">C</button></td>
                        <td><button class="btn btn-calc hvr-radial-out" id="sqrt">√</button></td>
                        <td><button class="btn btn-calc hvr-radial-out hvr-radial-out" id="square">x<sup>2</sup></button></td>
                        <td><button id="divide" class="btn btn-operation hvr-fade">÷</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-calc hvr-radial-out" id="seven">7</button></td>
                        <td><button class="btn btn-calc hvr-radial-out" id="eight">8</button></td>
                        <td><button class="btn btn-calc hvr-radial-out" id="nine">9</button></td>
                        <td><button id="multiply" class="btn btn-operation hvr-fade">×</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-calc hvr-radial-out" id="four">4</button></td>
                        <td><button class="btn btn-calc hvr-radial-out" id="five">5</button></td>
                        <td><button class="btn btn-calc hvr-radial-out" id="six">6</button></td>
                        <td><button id="subtract" class="btn btn-operation hvr-fade">−</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-calc hvr-radial-out" id="one">1</button></td>
                        <td><button class="btn btn-calc hvr-radial-out" id="two">2</button></td>
                        <td><button class="btn btn-calc hvr-radial-out" id="three">3</button></td>
                        <td><button id="add" class="btn btn-operation hvr-fade">+</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-calc hvr-radial-out" id="zero">0</button></td>
                        <td><button class="btn btn-calc hvr-radial-out" id="decimal">.</button></td>
                        <td class="equal"><button id="equals" class="btn btn-operation equals hvr-back-pulse">=</button></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="bottom-area-btns">
            <button class="btn btn-1 calculator-btn" type="button"><i class="fa fa-calculator"></i> Calculator</button>
            <button class="btn btn-green" type="button" data-toggle="modal" data-target="#"><i class="fa fa-keyboard-o"></i> Keyboard</button>
            <button class="btn btn-3" type="button" data-toggle="modal" data-target="#holdSaleModal"><i class="fa fa-folder-open"></i> Hold Sales</button>
            <button class="btn btn-4" type="button" data-toggle="modal" data-target="#"><i class="fa fa-times-circle"></i> Cancel</button>
            <button class="btn btn-yellow" type="button" data-toggle="modal" data-target="#holdBox"><i class="fa fa-hand-rock-o"></i> Hold</button>
            <button class="btn btn-6" type="button" data-toggle="modal" data-target="#paymentModal"><i class="fa fa-credit-card"></i> Payment</button>
            <button class="btn btn-7" type="button" data-toggle="modal" data-target="#holdBox"><i class="fa fa-hand-rock-o"></i> Hold</button>
        </div>
    </div>

</template>
