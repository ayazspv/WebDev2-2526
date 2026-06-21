<script setup>
import { ref, computed, onMounted } from 'vue'
import { useOrderStore } from '@/stores/orderStore'
import { useUserStore } from '@/stores/userStore'
import OrderDetails from '../Admin/OrderDetails.vue'

const orderStore = useOrderStore()
const userStore = useUserStore()
const showDetails = ref(false)
const selectedOrder = ref(null)

onMounted(async () => {
  if (userStore.user?.id) {
    await orderStore.fetchOrdersByUserId(userStore.user.id)
  }
})

const orders = computed(() => orderStore.orders)

function openOrderDetails(order) {
  selectedOrder.value = order
  showDetails.value = true
}
</script>

<template>
    <section class="mb-5">
        <div class="section-header mb-3 d-flex align-items-center">
            <i class="fas fa-shopping-cart section-icon text-primary"></i>
            <h4 class="fw-semibold mb-0 ms-2">Orders</h4>
        </div>
        <div class="card shadow-lg border-0 rounded-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id" @click="openOrderDetails(order)"
                            style="cursor:pointer;">
                            <td class="fw-semibold">#{{ order.id }}</td>
                            <td>{{ order.userId }}</td>
                            <td>{{ order.created_at }}</td>
                            <td>
                                <span
                                    :class="order.status === 'completed' ? 'badge bg-success-soft text-success' : 'badge bg-warning-soft text-warning'">
                                    {{ order.status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <OrderDetails v-if="showDetails && selectedOrder" :order="selectedOrder" @close="showDetails = false" />
    </section>
</template>

<style scoped>
.section-icon {
    font-size: 1.6rem;
    background: #e0e7ef;
    border-radius: 12px;
    padding: 0.5rem;
    box-shadow: 0 2px 8px rgba(40, 76, 42, 0.07);
}

.bg-warning-soft {
    background: #fff7e6 !important;
}

.bg-success-soft {
    background: #e6f9ed !important;
}
</style>