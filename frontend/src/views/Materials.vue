<script setup>
import { ref } from 'vue'
import MaterialsList from '../components/Home/Materials.vue'

// Example filter state
const search = ref('')
const status = ref('')
const minQuantity = ref('')
const maxQuantity = ref('')

// Emit filter values to MaterialsList (assume it accepts props or events)
const filters = ref({
    search: '',
    location: '',
    minQuantity: '',
    maxQuantity: ''
})

const locations = ref([
    'Utrecht',
    'Amsterdam',
    'Leiden',
    'Rotterdam'
])
const location = ref('')

function applyFilters() {
    filters.value = {
        search: search.value,
        location: status.value,
        minQuantity: minQuantity.value,
        maxQuantity: maxQuantity.value
    }
}
</script>
<template>
    <div class="container d-flex gap-4 align-items-top mb-5">
        <div class="w-25 sidebar p-4 rounded-4 shadow bg-white">
            <h5 class="mb-4 text-primary fw-bold">
                <i class="fas fa-filter me-2"></i>Filter Materials
            </h5>
            <div class="mb-3">
                <label class="form-label">Search</label>
                <input v-model="search" type="text" class="form-control" placeholder="Material name..." />
            </div>
            <div class="mb-3">
                <label class="form-label">location</label>
                <select v-model="location" class="form-select">
                    <option value="">All</option>
                    <option v-for="loc in locations" :key="loc" :value="loc">
                        {{ loc }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity Range</label>
                <div class="d-flex gap-2">
                    <input v-model="minQuantity" type="number" min="0" class="form-control" placeholder="Min" />
                    <input v-model="maxQuantity" type="number" min="0" class="form-control" placeholder="Max" />
                </div>
            </div>
            <button class="btn btn-gradient w-100 mt-3" @click="applyFilters">
                <i class="fas fa-search me-1"></i>Apply Filters
            </button>
        </div>
        <MaterialsList :filters="filters" />
    </div>
</template>

<style scoped>
.sidebar {
    background: linear-gradient(135deg, #e0e7ef 0%, #f8fafc 100%);
    min-height: 400px;
    border: 1px solid #e3e6ed;
}

.btn-gradient {
    background: linear-gradient(90deg, #4f8cff 0%, #27ae60 100%);
    color: #fff;
    border: none;
    transition: box-shadow 0.2s;
}

.btn-gradient:hover {
    box-shadow: 0 2px 12px rgba(79, 140, 255, 0.15);
}
</style>