<template>
    <div class="category-menu">
      <div class="menu-header">
        <button class="close-button" @click="$emit('close')">X</button>
        <input type="text" v-model="searchTerm" placeholder="Search Categories" class="form-control mb-3" />
      </div>
      <ul class="list-group">
        <li class="list-group-item" @click="selectCategory(null)">All Categories</li>
        <li v-for="category in filteredCategories" :key="category.id" class="list-group-item" @click="selectCategory(category)">
          {{ category.category_name }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        searchTerm: '',
        categories: [] // Fetch from Axios
      };
    },
    computed: {
      filteredCategories() {
        return this.categories.filter(category =>
          category.category_name.toLowerCase().includes(this.searchTerm.toLowerCase())
        );
      }
    },
    methods: {
      selectCategory(category) {
        this.$emit('categorySelected', category);
      }
    },
    mounted() {
      // Fetch categories from API
      axios.get('/api/categories')
        .then(response => {
          this.categories = response.data;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    }
  };
  </script>
  
  <style scoped>
  .category-menu {
    position: fixed;
    right: 0;
    top: 0;
    width: 300px;
    height: 100vh;
    background-color: white;
    box-shadow: -3px 0 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    z-index: 1000;
  }
  
  .menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .close-button {
    background-color: red;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
  }
  
  .list-group-item {
    cursor: pointer;
  }
  </style>
  