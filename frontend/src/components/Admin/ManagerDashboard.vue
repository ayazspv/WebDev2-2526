<script setup>
import { ref, computed, onMounted } from 'vue'
import { useMaterialStore } from '@/stores/materialStore'
import { useOrderStore } from '@/stores/orderStore'
import { useUserStore } from '@/stores/userStore'

const materialStore = useMaterialStore()
const orderStore = useOrderStore()
const userStore = useUserStore()

onMounted(async () => {
  if (!materialStore.materials.length) await materialStore.fetchMaterials()
  if (!orderStore.orders.length) await orderStore.fetchOrders()
  if (!userStore.users.length) await userStore.fetchAllUsers()
})

const items = computed(() => materialStore.materials || [])
const orders = computed(() => orderStore.orders || [])
const users = computed(() => userStore.users || [])

const stats = computed(() => [
  {
    title: "Items & Materials",
    icon: "fas fa-boxes",
    value: items.value.length,
    desc: "Tracked types"
  },
  {
    title: "Total Quantity",
    icon: "fas fa-cubes",
    value: items.value.reduce((sum, i) => sum + (i.quantity || 0), 0),
    desc: "All items in stock"
  },
  {
    title: "Orders",
    icon: "fas fa-shopping-cart",
    value: orders.value.length,
    desc: "Orders placed"
  },
  {
    title: "Users",
    icon: "fas fa-users",
    value: users.value.length,
    desc: "Registered users"
  }
])

const mostStockedItem = computed(() =>
  items.value.length
    ? items.value.reduce((max, i) => (i.quantity > max.quantity ? i : max), items.value[0]).name
    : 'N/A'
)

const latestOrder = computed(() =>
  orders.value.length ? orders.value[orders.value.length - 1] : null
)

const newestUser = computed(() =>
  users.value.length ? users.value[users.value.length - 1] : null
)
</script>

<template>
  <div class="manager-dashboard-bg min-vh-100 py-4 px-2 px-md-4">
    <h2 class="fw-bold mb-5 text-gradient">Manager Dashboard Overview</h2>
    <div class="row g-4 mb-5">
      <div v-for="stat in stats" :key="stat.title" class="col-12 col-sm-6 col-lg-3">
        <div class="card stat-card shadow-sm border-0 rounded-4 text-center py-4 h-100">
          <div class="mb-3">
            <i :class="stat.icon + ' fa-2x text-primary'"></i>
          </div>
          <div class="fw-bold display-6 mb-1">{{ stat.value }}</div>
          <div class="text-muted mb-1">{{ stat.title }}</div>
          <small class="text-secondary">{{ stat.desc }}</small>
        </div>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="card shadow border-0 rounded-4 h-100 p-4 d-flex flex-column align-items-center justify-content-center">
          <i class="fas fa-boxes fa-lg text-primary mb-2"></i>
          <div class="fw-semibold mb-1">Most Stocked Item</div>
          <div class="fs-5">
            {{ mostStockedItem }}
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card shadow border-0 rounded-4 h-100 p-4 d-flex flex-column align-items-center justify-content-center">
          <i class="fas fa-shopping-cart fa-lg text-primary mb-2"></i>
          <div class="fw-semibold mb-1">Latest Order</div>
          <div class="fs-6 text-muted mb-1" v-if="latestOrder">
            #{{ latestOrder.id }} &mdash; {{ latestOrder.item || latestOrder.materialName || 'N/A' }}
          </div>
          <div class="small text-secondary" v-if="latestOrder">
            by {{ latestOrder.user || latestOrder.userName || latestOrder.userId || 'N/A' }} on {{ latestOrder.date || latestOrder.created_at || 'N/A' }}
          </div>
          <div v-else class="text-muted">No orders yet</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card shadow border-0 rounded-4 h-100 p-4 d-flex flex-column align-items-center justify-content-center">
          <i class="fas fa-user-plus fa-lg text-primary mb-2"></i>
          <div class="fw-semibold mb-1">Newest User</div>
          <div class="fs-5">
            {{ newestUser ? (newestUser.name || (newestUser.firstname + ' ' + newestUser.lastname)) : 'N/A' }}
          </div>
          <div class="small text-secondary">
            {{ newestUser ? (newestUser.role || 'N/A') : '' }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.manager-dashboard-bg {
  background: linear-gradient(120deg, #f8fafc 60%, #e0e7ef 100%);
}

.text-gradient {
  background: linear-gradient(90deg, #4f8cff 0%, #27ae60 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.stat-card {
  background: rgba(255,255,255,0.97);
  border-radius: 1.5rem !important;
  transition: box-shadow 0.18s;
}

.stat-card:hover {
  box-shadow: 0 8px 32px rgba(40,76,42,0.13);
}

.card {
  border-radius: 1.5rem !important;
  background: rgba(255,255,255,0.95);
  border: none;
}










</style>