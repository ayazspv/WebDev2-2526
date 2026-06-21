<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useMaterialStore } from '../stores/materialStore'
import { useCartStore } from '../stores/cartStore'

const route = useRoute()
const router = useRouter()
const materialStore = useMaterialStore()
const cartStore = useCartStore()
const loading = ref(true)
const material = ref(null)
const selectedQuantity = ref(1)

const formatPrice = (price) => {
  return new Intl.NumberFormat('nl-NL', {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2,
  }).format(price)
}

onMounted(async () => {
  loading.value = true
  const id = route.params.id
  material.value = await materialStore.fetchMaterialById(id)
  loading.value = false
})

function addToCart() {
  cartStore.addToCart({
    id: material.value.id,
    product: { ...material.value },
    quantity: selectedQuantity.value || 1
  })
  router.push('/cart')
}
</script>

<template>
  <div class="container py-5 mb-5">
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
    </div>
    <div v-else-if="material" class="detail-card shadow-lg rounded-4 p-4 d-flex gap-4 align-items-start bg-white">
      <img
        :src="material.image"
        :alt="material.name"
        class="material-img rounded-4 shadow"
      />
      <div class="flex-grow-1">
        <h2 class="fw-bold text-primary mb-2">
          <i class="fas fa-cube me-2"></i>{{ material.name }}
        </h2>
        <div class="mb-3">
          <span class="badge bg-gradient-primary fs-6 px-3 py-2 me-2">{{ material.status }}</span>
          <span class="badge bg-secondary fs-6 px-3 py-2">{{ material.location }}</span>
        </div>
        <p class="lead mb-4">{{ material.description }}</p>
        <div class="mb-4">
          <strong>Price:</strong>
          <span class="fs-5 ms-2">{{ formatPrice(material.price) }}</span>
        </div>
        <div class="mb-4">
          <strong>Quantity:</strong>
          <span class="fs-5 ms-2">{{ material.quantity }}</span>
        </div>
        <div class="mb-4">
          <strong>Seller:</strong>
          <span class="fs-5 ms-2">{{ material.seller }}</span>
        </div>
        <div class="mb-4">
          <strong>Date:</strong>
          <span class="fs-5 ms-2">{{ material.date }}</span>
        </div>
        <div class="mb-4">
          <label for="quantity" class="form-label">Select Quantity:</label>
          <input
            type="number"
            id="quantity"
            v-model="selectedQuantity"
            min="1"
            class="form-control"
          />
        </div>
        <button class="btn btn-gradient px-4 py-2 fs-6" @click="addToCart">
          <i class="fas fa-cart-plus me-2"></i>Add to the cart
        </button>
      </div>
    </div>
    <div v-else class="alert alert-danger mt-5">
      Material not found.
    </div>
  </div>
</template>

<style scoped>
.detail-card {
  background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%);
  min-height: 350px;
}
.material-img {
  width: 320px;
  height: 220px;
  object-fit: cover;
  border: 4px solid #e0e7ef;
}
.bg-gradient-primary {
  background: linear-gradient(90deg, #4f8cff 0%, #27ae60 100%) !important;
  color: #fff !important;
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