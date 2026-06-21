<template>
  <div class="modal-backdrop">
    <div class="modal-content" style="min-width:350px;max-width:400px;">
      <h5 class="mb-3">Order Details</h5>
      <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Order ID:</strong> #{{ order.id }}</li>
        <li class="list-group-item"><strong>User:</strong> {{ order.user }}</li>
        <li class="list-group-item"><strong>Date:</strong> {{ order.date }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ order.status }}</li>
      </ul>
      <div>
        <h6 class="mb-2">Order Items</h6>
        <ul class="list-group mb-3" v-if="orderItems.length">
          <li class="list-group-item" v-for="item in orderItems" :key="item.id">
            <div>
              <strong>Material ID:</strong> {{ item.materialId }}<br>
              <strong>Quantity:</strong> {{ item.quantity }}<br>
              <strong>Price:</strong> €{{ item.price }}
            </div>
          </li>
        </ul>
        <div v-else class="text-muted mb-3">No items found for this order.</div>
      </div>
      <div class="d-flex justify-content-end">
        <button class="btn btn-secondary" @click="$emit('close')">Close</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useOrderStore } from '@/stores/orderStore'

const props = defineProps({
  order: { type: Object, required: true }
})
defineEmits(['close'])

const orderStore = useOrderStore()
const orderItems = ref([])

const fetchOrderItems = async () => {
  if (props.order?.id) {
    orderItems.value = await orderStore.fetchOrderItemsByOrderId(props.order.id) || []
  }
}

onMounted(fetchOrderItems)
watch(() => props.order?.id, fetchOrderItems)
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
}
.modal-content {
    background: #fff;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 2px 24px rgba(0,0,0,0.15);
}
</style>