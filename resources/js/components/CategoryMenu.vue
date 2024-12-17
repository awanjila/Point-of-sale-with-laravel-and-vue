<template>
  <div class="category-menu">
    <div class="menu-header">
      <button class="close-button" @click="$emit('close')">X</button>
      <input type="text" v-model="searchTerm" placeholder="Search Categories" class="form-control mb-3" />
    </div>
    <ul class="list-group">
      <li class="list-group-item" @click="selectCategory(null)">All Categories</li>
      <li v-for="category in paginatedCategories" :key="category.id" class="list-group-item category-item" @click="selectCategory(category)">
        {{ category.category_name }}
      </li>
    </ul>
    <div class="pagination-controls">
      <button class="btn btn-light" @click="previousPage" :disabled="currentPage === 1">Previous</button>
      <span>{{ currentPage }} / {{ totalPages }}</span>
      <button class="btn btn-light" @click="nextPage" :disabled="currentPage === totalPages">Next</button>
    </div>
  </div>
</template>

<script>
import debounce from 'lodash/debounce';
export default {
  data() {
    return {
      searchTerm: '',
      categories: [], // Categories fetched from API
      filteredCategories: [],
      currentPage: 1, // Current page number for pagination
      pageSize: 5, // Number of categories per page
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.filteredCategories.length / this.pageSize);
    },
    paginatedCategories() {
      const start = (this.currentPage - 1) * this.pageSize;
      const end = start + this.pageSize;
      return this.filteredCategories.slice(start, end);
    },
  },
  watch: {
    searchTerm() {
      this.debouncedFilter();
    },
  },
  methods: {
    selectCategory(category) {
      console.group('Category Selection in Menu');
      console.log('Raw Category Object:', category);
      console.log('Category Type:', typeof category);
      console.log('Category ID:', category ? category.id : 'No Category');
      console.log('Category Name:', category ? category.category_name : 'All Categories');
      console.groupEnd();
      
      // Ensure the category is a plain object, not a Proxy
      const plainCategory = category ? { ...category } : null;
      
      // Emit both events with plain object
      this.$emit('categorySelected', plainCategory);
      this.$emit('update:selectedCategory', plainCategory);
      this.$emit('close');
    },
    filterCategories() {
      this.filteredCategories = this.categories.filter(category =>
        category.category_name.toLowerCase().includes(this.searchTerm.toLowerCase())
      );
      this.currentPage = 1; // Reset to first page when filtering
    },
    debouncedFilter: debounce(function () {
      this.filterCategories();
    }, 300),
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
  },
  mounted() {
    axios.get('/api/pos/categories')
      .then(response => {
        this.categories = response.data;
        this.filteredCategories = this.categories;
      })
      .catch(error => {
        console.error('Error fetching categories:', error);
      });
  },
};
</script>

<style scoped>
.category-menu {
  position: fixed;
  right: 0;
  top: 0;
  width: 400px; /* Increased width */
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
  margin-bottom: 10px; /* Add margin between categories */
  padding: 10px 15px; /* Increase padding */
  background-color: #f9f9f9;
  border-radius: 5px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Add box shadow */
  transition: transform 0.2s ease;
}

.list-group-item:hover {
  transform: translateY(-2px); /* Slight lift effect on hover */
}

.pagination-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
}
</style>
