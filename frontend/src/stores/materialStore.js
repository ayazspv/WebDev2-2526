// materialStore.js
import { defineStore } from 'pinia'
import { ref } from 'vue'
import $axios from '@/axios'

export const useMaterialStore = defineStore('materials', () => {
  const materials = ref([])
  const material = ref(null)
  const quantities = ref([])
  const error = ref(null)
  const loading = ref(false)

  // Fetch all materials
  const fetchMaterials = async () => {
    loading.value = true
    error.value = null
    try {
      const response = await $axios.get('materials')
      console.log('API response:', response.data)
      materials.value = response.data
      return materials.value
    } catch (err) {
      error.value = 'Error fetching materials: ' + (err.response?.data?.message || err.message)
      return []
    } finally {
      loading.value = false
    }
  }

  // Fetch material by ID
  const fetchMaterialById = async (id) => {
    loading.value = true
    error.value = null
    try {
      const response = await $axios.get(`materials/${id}`)
      material.value = response.data
      return material.value
    } catch (err) {
      error.value = 'Error fetching material by ID: ' + (err.response?.data?.message || err.message)
      return null
    } finally {
      loading.value = false
    }
  }

  // Fetch materials by city
  const fetchMaterialsByCity = async (city) => {
    loading.value = true
    error.value = null
    try {
      const response = await $axios.get(`materials/city/${encodeURIComponent(city)}`)
      materials.value = response.data
      return materials.value
    } catch (err) {
      error.value = 'Error fetching materials by city: ' + (err.response?.data?.message || err.message)
      return []
    } finally {
      loading.value = false
    }
  }

  // Fetch highest stock material
  const fetchHighestStockMaterial = async () => {
    loading.value = true
    error.value = null
    try {
      const response = await $axios.get('materials/highest-stock')
      material.value = response.data
      return material.value
    } catch (err) {
      error.value = 'Error fetching highest stock material: ' + (err.response?.data?.message || err.message)
      return null
    } finally {
      loading.value = false
    }
  }

  // Fetch all quantities
  const fetchAllQuantities = async () => {
    loading.value = true
    error.value = null
    try {
      const response = await $axios.get('materials/quantities')
      quantities.value = response.data
      return quantities.value
    } catch (err) {
      error.value = 'Error fetching quantities: ' + (err.response?.data?.message || err.message)
      return []
    } finally {
      loading.value = false
    }
  }

  // Add new material
  const addMaterial = async (data) => {
    loading.value = true
    error.value = null
    try {
      const response = await $axios.post('materials', data)
      await fetchMaterials()
      return response.data
    } catch (err) {
      error.value = 'Error adding material: ' + (err.response?.data?.message || err.message)
      return null
    } finally {
      loading.value = false
    }
  }

  // Edit material by ID
  const editMaterial = async (id, data) => {
    loading.value = true
    error.value = null
    try {
      const response = await $axios.put(`materials/${id}`, data)
      // Optionally update local materials list
      await fetchMaterials()
      return response.data
    } catch (err) {
      error.value = 'Error editing material: ' + (err.response?.data?.message || err.message)
      return null
    } finally {
      loading.value = false
    }
  }

  // Delete material by ID
  const deleteMaterial = async (id) => {
    loading.value = true
    error.value = null
    try {
      const response = await $axios.delete(`materials/${id}`)
      // Optionally update local materials list
      await fetchMaterials()
      return response.data
    } catch (err) {
      error.value = 'Error deleting material: ' + (err.response?.data?.message || err.message)
      return null
    } finally {
      loading.value = false
    }
  }

  return {
    materials,
    material,
    quantities,
    error,
    loading,
    fetchMaterials,
    fetchMaterialById,
    fetchMaterialsByCity,
    fetchHighestStockMaterial,
    fetchAllQuantities,
    addMaterial,
    editMaterial,
    deleteMaterial,
  }
}, {
  persist: true,
})
