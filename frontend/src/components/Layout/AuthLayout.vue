<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const email = ref('')
const password = ref('')
const rememberMe = ref(false)

function login() {
  // Add your login logic here
  alert(`Email: ${email.value}\nPassword: ${password.value}\nRemember Me: ${rememberMe.value}`)
}

function goHome() {
  router.push('/')
}
</script>

<template>
  <div class="login-bg d-flex align-items-center justify-content-center vh-100 position-relative min-vh-100">
    <div class="home-link position-absolute top-0 start-0 m-4">
      <button class="btn btn-outline-primary rounded-pill px-3 fw-semibold" @click="goHome">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" class="me-2" style="vertical-align: middle;">
          <path d="M3 12L12 4l9 8" stroke="#4f8cff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M5 10v10a1 1 0 0 0 1 1h4m4 0h4a1 1 0 0 0 1-1V10" stroke="#4f8cff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Home
      </button>
    </div>
    <div class="login-card shadow-lg p-4 rounded-4 bg-white w-100">
      <slot />
    </div>
  </div>
</template>

<style scoped>
.login-bg {
  background: linear-gradient(135deg, #e0e7ef 0%, #f8fafc 100%);
}

.login-card {
  max-width: 380px;
  border: none;
}

input:focus,
.form-control:focus {
  border-color: #4f8cff;
  box-shadow: 0 0 0 0.2rem rgba(79, 140, 255, 0.15);
}

.btn-primary {
  background: #4f8cff;
  border: none;
  transition: background 0.2s;
}

.btn-primary:hover {
  background: #2563eb;
}

.home-link {
  z-index: 10;
}
</style>