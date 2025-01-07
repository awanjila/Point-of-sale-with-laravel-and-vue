<template>
  <div class="sales-report-container">
    <!-- Header with Title and Export Dropdown -->
    <div class="header">
      <h2 class="title">Sales Report</h2>
      
      <div class="dropdown">
        <button 
          @click="showExportDropdown = !showExportDropdown"
          class="dropdown-button"
        >
          Export Report
          <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        
        <div v-if="showExportDropdown" class="dropdown-menu">
          <button @click="exportToExcel" class="dropdown-item">Export to Excel</button>
          <button @click="exportToPDF" class="dropdown-item">Export to PDF</button>
        </div>
      </div>
    </div>

    <!-- Date Range Dropdown and Search Section -->
    <div class="filters">
      <div class="date-filter">
        <select v-model="selectedDateFilter" class="filter-select">
          <option v-for="filter in dateFilters" :key="filter.value" :value="filter.value">
            {{ filter.label }}
          </option>
        </select>
      </div>

      <!-- Custom Date Range Picker -->
      <div v-if="selectedDateFilter === 'custom'" class="custom-date-range">
        <input type="date" v-model="dateRange.start" class="date-input">
        <input type="date" v-model="dateRange.end" class="date-input">
      </div>
    </div>

    <!-- Search Input -->
    <div class="search-container">
      <input 
        type="text"
        v-model="searchQuery"
        placeholder="Search by date..."
        class="search-input"
      >
    </div>

    <!-- Data Table -->
    <div class="table-container">
      <table class="data-table">
        <thead>
          <tr>
            <th v-for="header in tableHeaders" :key="header.value" @click="sortBy(header.value)">
              <div class="header-cell">
                {{ header.label }}
                <span v-if="sortColumn === header.value" class="sort-icon">
                  {{ sortDirection === 'asc' ? '↑' : '↓' }}
                </span>
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in filteredData" :key="index">
            <td>{{ formatDate(row.order_date) }}</td>
            <td>{{ row.order_count }}</td>
            <td>{{ row.products_sold }}</td>
            <td>{{ formatCurrency(row.tax) }}</td>
            <td>{{ formatCurrency(row.total) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>



<style scoped>
/* Container */
.sales-report-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Header */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.title {
  font-size: 24px;
  font-weight: 600;
  color: #333;
}

.dropdown {
  position: relative;
}

.dropdown-button {
  display: flex;
  align-items: center;
  padding: 10px 16px;
  background-color: #007BFF;
  color: #fff;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.dropdown-button:hover {
  background-color: #0056b3;
}

.icon {
  width: 16px;
  height: 16px;
  margin-left: 8px;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  right: 0;
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-top: 5px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 10;
}

.dropdown-item {
  padding: 10px 16px;
  font-size: 14px;
  color: #333;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.dropdown-item:hover {
  background-color: #f2f2f2;
}

/* Filters */
.filters {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.filter-select, .date-input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  width: 100%;
}

/* Search */
.search-container {
  margin-bottom: 20px;
}

.search-input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}

/* Table */
.table-container {
  overflow-x: auto;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
}

.data-table thead {
  background-color: #f9f9f9;
}

.data-table th, .data-table td {
  text-align: left;
  padding: 12px;
  border-bottom: 1px solid #ddd;
}

.header-cell {
  display: flex;
  align-items: center;
  cursor: pointer;
}

.sort-icon {
  margin-left: 5px;
  font-size: 12px;
}

.data-table tbody tr:hover {
  background-color: #f2f2f2;
}
</style>



<script>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import * as XLSX from 'xlsx'
import jsPDF from 'jspdf'
import 'jspdf-autotable'

export default {
  name: 'SalesReportComponent',
  setup() {
    const salesData = ref([])
    const searchQuery = ref('')
    const selectedDateFilter = ref('today')
    const sortColumn = ref('order_date')
    const sortDirection = ref('desc')
    const dateRange = ref({ start: '', end: '' })
    const showExportDropdown = ref(false)
    const currencySettings = ref({
      symbol: '$',
      position: 'before' // or 'after'
    })

    const dateFilters = [
      { label: 'Today', value: 'today' },
      { label: 'Yesterday', value: 'yesterday' },
      { label: 'Last 7 Days', value: 'last7days' },
      { label: 'Last 30 Days', value: 'last30days' },
      { label: 'This Month', value: 'thisMonth' },
      { label: 'Last Month', value: 'lastMonth' },
      { label: 'Custom Range', value: 'custom' }
    ]

    const tableHeaders = [
      { label: 'Order Date', value: 'order_date' },
      { label: 'Number of Orders', value: 'order_count' },
      { label: 'Products Sold', value: 'products_sold' },
      { label: 'Tax', value: 'tax' },
      { label: 'Total', value: 'total' }
    ]

    // Fetch Settings
    const fetchSettings = async () => {
      try {
        const response = await axios.get('/api/settings')
        currencySettings.value = {
          symbol: response.data.currency.symbol,
          position: response.data.currency.position || 'before'
        }
      } catch (error) {
        console.error('Error fetching settings:', error)
      }
    }

    // Fetch Data
    const fetchSalesData = async () => {
      try {
        const response = await axios.get('/api/sales-report')
        salesData.value = response.data
      } catch (error) {
        console.error('Error fetching sales data:', error)
      }
    }

    // Format Currency with Settings
    const formatCurrency = (amount) => {
      const formattedAmount = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }).format(amount)

      return currencySettings.value.position === 'before'
        ? `${currencySettings.value.symbol}${formattedAmount}`
        : `${formattedAmount}${currencySettings.value.symbol}`
    }

    // Filter and Sort Logic
    const filteredData = computed(() => {
      let filtered = [...salesData.value]

      // Apply date filter
      filtered = filtered.filter(row => {
        const rowDate = new Date(row.order_date)
        const today = new Date()
        
        switch (selectedDateFilter.value) {
          case 'today':
            return isSameDay(rowDate, today)
          case 'yesterday':
            const yesterday = new Date(today)
            yesterday.setDate(yesterday.getDate() - 1)
            return isSameDay(rowDate, yesterday)
          case 'last7days':
            const last7Days = new Date(today)
            last7Days.setDate(last7Days.getDate() - 7)
            return rowDate >= last7Days
          case 'last30days':
            const last30Days = new Date(today)
            last30Days.setDate(last30Days.getDate() - 30)
            return rowDate >= last30Days
          case 'thisMonth':
            return rowDate.getMonth() === today.getMonth() &&
                   rowDate.getFullYear() === today.getFullYear()
          case 'lastMonth':
            const lastMonth = new Date(today)
            lastMonth.setMonth(lastMonth.getMonth() - 1)
            return rowDate.getMonth() === lastMonth.getMonth() &&
                   rowDate.getFullYear() === lastMonth.getFullYear()
          case 'custom':
            if (dateRange.value.start && dateRange.value.end) {
              const start = new Date(dateRange.value.start)
              const end = new Date(dateRange.value.end)
              return rowDate >= start && rowDate <= end
            }
            return true
          default:
            return true
        }
      })

      // Apply search filter
      if (searchQuery.value) {
        filtered = filtered.filter(row =>
          row.order_date.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
      }

      // Apply sorting
      filtered.sort((a, b) => {
        const modifier = sortDirection.value === 'asc' ? 1 : -1
        if (a[sortColumn.value] < b[sortColumn.value]) return -1 * modifier
        if (a[sortColumn.value] > b[sortColumn.value]) return 1 * modifier
        return 0
      })

      return filtered
    })

    // Export Functions with Currency Settings
    const exportToExcel = () => {
      const exportData = filteredData.value.map(row => ({
        'Order Date': formatDate(row.order_date),
        'Number of Orders': row.order_count,
        'Products Sold': row.products_sold,
        'Tax': formatCurrency(row.tax),
        'Total': formatCurrency(row.total)
      }))

      const ws = XLSX.utils.json_to_sheet(exportData)
      const wb = XLSX.utils.book_new()
      XLSX.utils.book_append_sheet(wb, ws, 'Sales Report')
      XLSX.writeFile(wb, 'sales-report.xlsx')
      showExportDropdown.value = false
    }

    const exportToPDF = () => {
      const doc = new jsPDF()
      doc.autoTable({
        head: [tableHeaders.map(header => header.label)],
        body: filteredData.value.map(row => [
          formatDate(row.order_date),
          row.order_count,
          row.products_sold,
          formatCurrency(row.tax),
          formatCurrency(row.total)
        ])
      })
      doc.save('sales-report.pdf')
      showExportDropdown.value = false
    }

    // Utility Functions
    const formatDate = (date) => {
      return new Date(date).toLocaleDateString()
    }

    const isSameDay = (date1, date2) => {
      return date1.getDate() === date2.getDate() &&
             date1.getMonth() === date2.getMonth() &&
             date1.getFullYear() === date2.getFullYear()
    }

    const sortBy = (column) => {
      if (sortColumn.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
      } else {
        sortColumn.value = column
        sortDirection.value = 'asc'
      }
    }

    // Click outside to close export dropdown
    const handleClickOutside = (event) => {
      if (showExportDropdown.value && !event.target.closest('.relative')) {
        showExportDropdown.value = false
      }
    }

    onMounted(() => {
      fetchSettings()
      fetchSalesData()
      document.addEventListener('click', handleClickOutside)
    })

    return {
      salesData,
      searchQuery,
      selectedDateFilter,
      dateRange,
      dateFilters,
      tableHeaders,
      sortColumn,
      sortDirection,
      showExportDropdown,
      filteredData,
      exportToExcel,
      exportToPDF,
      formatDate,
      formatCurrency,
      sortBy
    }
  }
}
</script>