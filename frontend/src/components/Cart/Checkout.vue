<template>
  <div class="container py-5">
    <h1 class="mb-4 fw-bold text-primary"><i class="fas fa-credit-card me-2"></i>Checkout</h1>
    
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="mt-3">Processing your order...</p>
    </div>

    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>
    
    <div v-else class="row g-4">
      <div class="col-lg-7">
        <div class="card shadow border-0 rounded-4 mb-4">
          <div class="card-header bg-white border-0 rounded-top-4">
            <h5 class="mb-0 fw-semibold text-primary">Order Items</h5>
          </div>
          <div class="card-body p-0">
            <div class="list-group list-group-flush">
              <div v-for="item in cartItems" :key="item.id" class="list-group-item py-4 px-3">
                <div class="row align-items-center">
                  <div class="col-md-2 col-4">
                    <img :src="item.product.image" :alt="item.product.name"
                      class="img-fluid rounded-3 border cart-img" />
                  </div>
                  <div class="col-md-6 col-8">
                    <h5 class="mb-1">{{ item.product.name }}</h5>
                    <p class="mb-0 text-muted fs-6">
                      €{{ formatPrice(item.product.price) }} each
                    </p>
                  </div>
                  <div class="col-md-2 col-6 mt-3 mt-md-0 text-center">
                    <span class="badge bg-gradient-primary fs-6 px-3 py-2">Qty: {{ item.quantity }}</span>
                  </div>
                  <div class="col-md-2 col-6 mt-3 mt-md-0 text-end">
                    <span class="fw-bold fs-5">
                      €{{ formatPrice(item.product.price * item.quantity) }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-5">
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
            <div class="alert alert-info mb-4">
              <p class="mb-0"><strong>Note:</strong> By confirming this order, you agree to the terms and conditions.</p>
            </div>
            <div class="d-grid gap-2">
              <button class="btn btn-gradient" 
                      @click="placeOrder" 
                      :disabled="loading || cartItems.length === 0">
                <span v-if="loading">
                  <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                  Processing...
                </span>
                <span v-else>
                  <i class="fas fa-check-circle me-2"></i>
                  Confirm Order
                </span>
              </button>
              <router-link to="/cart" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Back to Cart
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '@/stores/cartStore'
import { useUserStore } from '@/stores/userStore'
import { useOrderStore } from '@/stores/orderStore'

const router = useRouter()
const cartStore = useCartStore()
const userStore = useUserStore()
const orderStore = useOrderStore()

const loading = ref(false)
const error = ref(null)

const cartItems = computed(() => (cartStore.items.value || []).filter(item => item.product))
const subtotal = computed(() =>
  cartItems.value.reduce((sum, item) => sum + Number(item.product.price) * item.quantity, 0)
)
const shipping = computed(() => (subtotal.value >= 50 ? 0 : 4.99))
const total = computed(() => subtotal.value + shipping.value)

function formatPrice(price) {
  return Number(price).toFixed(2)
}

async function placeOrder() {
  loading.value = true
  error.value = null
  try {
    if (!userStore.user || !userStore.user.id) {
      router.push({ name: 'Login', query: { redirect: '/checkout' } })
      loading.value = false
      return
    }
    console.log('Placing order with:', {
      userId: userStore.user.id,
      cartItems: cartItems.value,
      total: total.value
    })
    const orderId = await orderStore.placeOrder({
      userId: userStore.user.id,
      cartItems: cartItems.value,
      total: total.value
    })
    console.log('Order placed successfully, orderId:', orderId)
    cartStore.clearCart()
    router.push('/order-success')
  } catch (err) {
    console.error('Order placement failed:', err)
    if (err.response) {
      console.error('API response error:', err.response.data)
      error.value = `Failed to place order: ${err.response.data.message || err.response.statusText}`
    } else {
      error.value = err.message || 'Failed to place order. Please try again.'
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  if (!cartItems.value.length) {
    router.push('/cart')
  }
})
</script>

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
</style>