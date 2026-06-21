<template>
  <header class="bg-white text-menu py-3">
    <nav class="navbar navbar-expand-lg navbar-dark container">
      <router-link class="navbar-brand logo-text" to="/">CircuTrade</router-link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item me-4">
            <router-link class="nav-link" to="/">Home</router-link>
          </li>
          <li class="nav-item me-4">
            <router-link class="nav-link" to="/materials">Buy Materials</router-link>
          </li>
          <li class="nav-item me-4">
            <router-link class="nav-link" to="/sell">Sell Materials</router-link>
          </li>
          <li class="nav-item me-4">
            <router-link class="nav-link" to="/about">About Us</router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Account
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <template v-if="!isAuthenticated">
                <li>
                  <router-link class="dropdown-item" to="/login">Login</router-link>
                </li>
                <li>
                  <router-link class="dropdown-item" to="/register">Register</router-link>
                </li>
              </template>
              <template v-else>
                <li>
                  <router-link class="dropdown-item" to="/dashboard">Dashboard</router-link>
                </li>
                <li>
                  <a class="dropdown-item" href="#" @click.prevent="logout">Logout</a>
                </li>
              </template>
            </ul>
          </li>
          <li class="nav-item me-4">
            <router-link class="nav-link position-relative" to="/cart">
              <i class="fas fa-shopping-cart"></i>
              <span class="visually-hidden">Cart</span>
              <!-- Optionally show cart count badge here -->
            </router-link>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/userStore'

const userStore = useUserStore()
const router = useRouter()

const isAuthenticated = computed(() => !!userStore.token)

function logout() {
  userStore.logout() // Use the store's logout method for consistency
  router.push('/login')
}
</script>

<style scoped>
.nav-link {
  color: #284C2A;
}

.logo-text {
  color: #284C2A;
  font-family: arial black;
  font-size: 24px;
}
</style>