<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/userStore'

const email = ref('')
const password = ref('')
const rememberMe = ref(false)
const error = ref('')
const userStore = useUserStore()
const router = useRouter()

async function login() {
  error.value = ''
  const result = await userStore.login({ email: email.value, password: password.value })
  if (result && result.token) {
    await userStore.fetchMe() // <-- fetch full user info after login
    const redirect = router.currentRoute.value.query.redirect
    if (redirect) {
      router.push(redirect)
    } else if (result.userType === 'admin') {
      router.push('/dashboard')
    } else {
      router.push('/dashboard/user')
    }
  } else {
    error.value = userStore.error || 'Login failed'
  }
}
</script>

<template>
  <div class="text-center mb-4">
    <svg width="48" height="48" viewBox="0 0 48 48">
      <circle cx="24" cy="24" r="22" fill="#4f8cff" opacity="0.15" />
      <text x="50%" y="55%" text-anchor="middle" fill="#4f8cff" font-size="2rem"
        font-family="Segoe UI, Arial, sans-serif" font-weight="bold">🔒</text>
    </svg>
    <h2 class="fw-bold mt-2 mb-1">Welcome back!</h2>
    <p class="text-secondary mb-0">Sign in to your account.</p>
  </div>
  <form @submit.prevent="login">
    <div class="mb-3">
      <label for="email" class="form-label fw-semibold">Email address</label>
      <input v-model="email" type="email" class="form-control" id="email" placeholder="Enter email" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label fw-semibold">Password</label>
      <input v-model="password" type="password" class="form-control" id="password" placeholder="Password" required>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="rememberMe" v-model="rememberMe">
        <label class="form-check-label" for="rememberMe">
          Remember me
        </label>
      </div>
      <a href="#" class="text-decoration-none text-primary small">Forgot password?</a>
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-pill">Login</button>
    <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
  </form>
  <div class="text-center mt-3">
    <span class="text-secondary">Don't have an account?</span>
    <a href="/register" class="text-primary fw-semibold text-decoration-none ms-1">Sign up</a>
  </div>
</template>

<style scoped>
.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}
</style>