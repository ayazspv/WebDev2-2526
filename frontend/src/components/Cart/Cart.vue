<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '@/stores/cartStore'
import { useUserStore } from '@/stores/userStore'

const router = useRouter()
const cartStore = useCartStore()
const userStore = useUserStore()

const itemLoading = ref(false)
const error = ref(null)

// --- Add this function to reload from sessionStorage ---
function reloadCartFromStorage() {
  const stored = sessionStorage.getItem('cartItems')
  if (stored) {
    try {
      cartStore.items.value = JSON.parse(stored)
    } catch (e) {
      cartStore.items.value = []
    }
  }
}

onMounted(() => {
  reloadCartFromStorage()
})
// -------------------------------------------------------

const items = computed(() => (cartStore.items.value || []).filter(item => item.product))

const shipping = computed(() => (subtotal.value >= 50 ? 0 : 4.99))
const subtotal = computed(() =>
  items.value.reduce((sum, item) => sum + Number(item.product.price) * item.quantity, 0)
)
const total = computed(() => subtotal.value + shipping.value)

function formatPrice(price) {
  return Number(price).toFixed(2)
}

function updateQuantity(id, quantity) {
  if (quantity > 0) {
    cartStore.updateQuantity(id, quantity)
  }
}

function removeFromCart(id) {
  cartStore.removeFromCart(id)
}

function clearCart() {
  cartStore.clearCart()
}

function checkout() {
  if (!userStore.token) {
    router.push({ name: 'Login', query: { redirect: '/checkout' } })
  } else {
    router.push('/checkout')
  }
}
</script>

<template>
  <div class="container py-5 mb-5">
    <h1 class="mb-4 fw-bold text-primary"><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h1>

    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="mt-3">Loading your cart...</p>
    </div>

    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <div v-else-if="!items.length" class="empty-cart text-center py-5">
      <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
      <h3 class="fw-semibold">Your cart is empty</h3>
      <p class="text-muted">Add items to your cart to see them here.</p>
      <router-link to="/materials" class="btn btn-gradient mt-3">
        <i class="fas fa-store me-2"></i>Browse Products
      </router-link>
    </div>

    <div v-else class="row g-4">
      <div class="col-lg-8">
        <div class="card shadow border-0 rounded-4">
          <div class="card-header bg-white border-0 rounded-top-4">
            <h5 class="mb-0 fw-semibold text-primary">Cart Items ({{ items.length }})</h5>
          </div>
          <div class="card-body p-0">
            <div class="list-group list-group-flush">
              <div
                v-for="item in items"
                :key="item.id"
                class="list-group-item py-4 px-3"
              >
                <div class="row align-items-center">
                  <div class="col-md-2 col-4">
                    <img :src="item.product.image" :alt="item.product.name"
                      class="img-fluid rounded-3 border cart-img" />
                  </div>
                  <div class="col-md-4 col-8">
                    <h5 class="mb-1">{{ item.product.name }}</h5>
                    <p class="mb-0 text-muted fs-6">
                      €{{ formatPrice(item.product.price) }} each
                    </p>
                  </div>
                  <div class="col-md-3 col-6 mt-3 mt-md-0">
                    <div class="input-group input-group-sm">
                      <!-- <button @click="updateQuantity(item.id, item.quantity - 1)"
                        class="btn btn-outline-secondary"
                        :disabled="item.quantity <= 1 || itemLoading">
                        <i class="fas fa-minus"></i>
                      </button> -->
                      <input type="number" v-model.number="item.quantity"
                        @change="updateQuantity(item.id, item.quantity)"
                        class="form-control text-center" min="1">
                      <!-- <button @click="updateQuantity(item.id, item.quantity + 1)"
                        class="btn btn-outline-secondary" :disabled="itemLoading">
                        <i class="fas fa-plus"></i>
                      </button> -->
                    </div>
                  </div>
                  <div class="col-md-2 col-6 mt-3 mt-md-0 text-end">
                    <span class="fw-bold fs-5">
                      €{{ formatPrice(item.product.price * item.quantity) }}
                    </span>
                  </div>
                  <div class="col-md-1 col-12 mt-3 mt-md-0 text-end">
                    <button @click="removeFromCart(item.id)"
                      class="btn btn-sm btn-outline-danger" :disabled="itemLoading">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card shadow border-0 rounded-4 order-summary">
          <div class="card-header bg-white border-0 rounded-top-4">
            <h5 class="mb-0 fw-semibold text-primary">Order Summary</h5>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
              <span>Subtotal:</span>
              <span>€{{ formatPrice(subtotal) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Shipping:</span>
              <span v-if="shipping > 0">€{{ formatPrice(shipping) }}</span>
              <span v-else class="text-success">Free</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
              <strong>Total:</strong>
              <strong>€{{ formatPrice(total) }}</strong>
            </div>
            <button @click="checkout" class="btn btn-gradient w-100 mb-2" :disabled="itemLoading">
              <i class="fas fa-credit-card me-2"></i>
              Proceed to Checkout
            </button>
            <button @click="clearCart" class="btn btn-outline-secondary w-100" :disabled="itemLoading">
              <i class="fas fa-trash me-2"></i>
              Clear Cart
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- <pre>{{ items }}</pre> -->
  </div>
</template>

<style scoped>
.btn-gradient {
  background: linear-gradient(90deg, #4f8cff 0%, #27ae60 100%);
  color: #fff;
  border: none;
  transition: box-shadow 0.2s;
}
.btn-gradient:hover {
  box-shadow: 0 2px 12px rgba(79, 140, 255, 0.15);
}
.cart-img {
  width: 80px;
  height: 60px;
  object-fit: cover;
  border: 2px solid #e0e7ef;
}
.order-summary {
  background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%);
}
.empty-cart {
  min-height: 350px;
}
</style>