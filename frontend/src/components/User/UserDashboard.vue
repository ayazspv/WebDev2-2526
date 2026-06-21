<script setup>
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/userStore'
import Orders from '@/components/User/UserOrders.vue'

const router = useRouter()
const userStore = useUserStore()

if (userStore.user?.role === 'admin') {
  router.replace({ name: 'Dashboard' })
}
</script>
<template>
    <!-- Only user dashboard content here -->
    <Orders />
</template>