<script setup>

import AppLayout from './components/Layout/AppLayout.vue'
import AuthLayout from './components/Layout/AuthLayout.vue'
import DashboardLayout from './components/Layout/DashboardLayout.vue'
import { useRoute } from 'vue-router'
import { computed } from 'vue'

const route = useRoute()

const isManager = computed(() => {
  return route.matched.find(r => r.meta.isManager !== undefined)?.meta.isManager ?? false
})

const ManagerMenu = [
  { label: 'Overview', to: '/dashboard', icon: 'fas fa-home' },
  { label: 'Materials', to: '/dashboard/materials', icon: 'fas fa-boxes' },
  { label: 'Orders', to: '/dashboard/orders', icon: 'fas fa-shopping-cart' },
  { label: 'Users', to: '/dashboard/users', icon: 'fas fa-users' },
]

const UserMenu = [
  { label: 'Overview', to: '/dashboard/user', icon: 'fas fa-home' },
]

// Decide which menu to use
const dashboardMenu = computed(() => (isManager.value ? ManagerMenu : UserMenu))

const layoutComponent = computed(() => {
  const layout = route.meta.layout
  switch (layout) {
    case 'AppLayout':
      return AppLayout
    case 'AuthLayout':
      return AuthLayout
    case 'DashboardLayout':
      return DashboardLayout
    case 'none':
      return null
    default:
      return AppLayout
  }
})

</script>
<template>
  <DashboardLayout v-if="layoutComponent === DashboardLayout" :menu="dashboardMenu">
    <router-view />
  </DashboardLayout>
  <component v-else-if="layoutComponent" :is="layoutComponent">
    <router-view />
  </component>
  <router-view v-else />
</template>

<style scoped></style>
