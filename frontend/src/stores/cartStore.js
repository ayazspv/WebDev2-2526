import { defineStore } from 'pinia'
import { ref, watch } from 'vue'

export const useCartStore = defineStore('cart', () => {
  // Always wrap in ref
  const items = ref([])

  // Load cart from sessionStorage if available
  const stored = sessionStorage.getItem('cartItems')
  if (stored) {
    try {
      items.value = JSON.parse(stored)
    } catch (e) {
      items.value = []
    }
  }

  function addToCart(material) {
    const existing = items.value.find(i => i.id === material.id)
    if (existing) {
      existing.quantity += material.quantity ?? 1
    } else {
      items.value.push({ ...material, quantity: material.quantity ?? 1 })
    }
  }

  function removeFromCart(id) {
    items.value = items.value.filter(i => i.id !== id)
  }

  function clearCart() {
    items.value = []
  }

  function updateQuantity(id, quantity) {
    const item = items.value.find(i => i.id === id)
    if (item && quantity > 0) {
      item.quantity = quantity
    }
  }

  // Watch for changes and update sessionStorage
  watch(items, (newItems) => {
    sessionStorage.setItem('cartItems', JSON.stringify(newItems))
  }, { deep: true })

  return { items, addToCart, removeFromCart, clearCart, updateQuantity }
})