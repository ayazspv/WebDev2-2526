<script setup>
import { ref, computed, onMounted } from 'vue'
import { useMaterialStore } from '@/stores/materialStore'
import { useUserStore } from '@/stores/userStore'

const search = ref('')
const location = ref('')

const materialStore = useMaterialStore()
const userStore = useUserStore()

onMounted(async () => {
  if (!materialStore.materials.length) {
    await materialStore.fetchMaterials()
  }
  if (!userStore.users.length) {
    await userStore.fetchAllUsers()
  }
})

const materialsReused = computed(() => materialStore.materials.length)
const activeUsers = computed(() => userStore.users.length)
const citiesConnected = computed(() => {
  // Get unique cities from materials
  const cities = materialStore.materials
    .map(m => m.location || m.city)
    .filter(Boolean)
  return new Set(cities).size
})

function onSearch(e) {
  e.preventDefault()
  alert(`Searching for: ${search.value} in ${location.value || 'all locations'}`)
}
</script>

<template>
    <section
        class="hero-section position-relative d-flex align-items-center justify-content-center text-center min-vh-100">
        <!-- Animated Blobs Background -->
        <div class="hero-blobs">
            <div class="blob blob1"></div>
            <div class="blob blob2"></div>
            <div class="blob blob3"></div>
        </div>
        <div class="hero-content bg-white bg-opacity-90 rounded-4 shadow-lg mx-auto p-4 p-md-5">
            <div class="mb-4">
                <!-- <img src="#" alt="CircuTrade Logo" class="brand-logo mb-3" /> -->
                <h1 class="hero-title fw-bold display-4">
                    <span class="first-half">Circu</span><span class="second-half">Trade</span>
                </h1>
                <p class="hero-subtitle mt-3 fs-4 fw-semibold">
                    <span class="first-half">Circular Materials,</span>
                    <span class="second-half">Infinite Possibilities</span>
                </p>
            </div>
            <!-- <form
                class="hero-search-form d-flex flex-column flex-md-row align-items-stretch justify-content-center gap-2 gap-md-3 mb-4"
                @submit="onSearch">
                <input v-model="search" class="form-control form-control-lg shadow-sm" type="search"
                    placeholder="What are you looking for?" aria-label="Search" />
                <select v-model="location" class="form-select form-select-lg shadow-sm" aria-label="Filter by location">
                    <option value="">All Locations</option>
                    <option value="Leiden">Leiden</option>
                    <option value="Amsterdam">Amsterdam</option>
                    <option value="Rotterdam">Rotterdam</option>
                    <option value="Utrecht">Utrecht</option>
                </select>
                <button class="btn btn-primary btn-lg px-4 fw-bold shadow" type="submit">
                    <i class="fas fa-search me-2"></i>Search
                </button>
            </form> -->
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <router-link to="/register" class="btn btn-success btn-lg rounded-pill px-4 shadow-sm">Create Free
                    Account</router-link>
                <router-link to="/login" class="btn btn-outline-primary btn-lg rounded-pill px-4 shadow-sm">Sign
                    In</router-link>
            </div>
            <div class="d-flex flex-wrap justify-content-center gap-4 mt-5">
                <div class="stat-card bg-white bg-opacity-75 px-4 py-3 rounded-4 shadow text-center">
                    <i class="fas fa-recycle text-success fa-lg mb-1"></i>
                    <div class="fw-bold">{{ materialsReused }}</div>
                    <div class="stat-label text-secondary">Materials Reused</div>
                </div>
                <div class="stat-card bg-white bg-opacity-75 px-4 py-3 rounded-4 shadow text-center">
                    <i class="fas fa-users text-primary fa-lg mb-1"></i>
                    <div class="fw-bold">{{ activeUsers }}</div>
                    <div class="stat-label text-secondary">Active Users</div>
                </div>
                <div class="stat-card bg-white bg-opacity-75 px-4 py-3 rounded-4 shadow text-center">
                    <i class="fas fa-globe-europe text-warning fa-lg mb-1"></i>
                    <div class="fw-bold">{{ citiesConnected }}</div>
                    <div class="stat-label text-secondary">Cities Connected</div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.hero-section {
    background: linear-gradient(120deg, #e0e7ef 60%, #f8fafc 100%);
    position: relative;
    overflow: hidden;
}

.hero-blobs {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
}

.blob {
    position: absolute;
    border-radius: 50%;
    opacity: 0.25;
    filter: blur(16px);
    animation: blobMove 18s infinite alternate cubic-bezier(.4, 2, .3, 1);
}

.blob1 {
    width: 420px;
    height: 420px;
    background: #4f8cff;
    top: -120px;
    left: -120px;
    animation-delay: 0s;
}

.blob2 {
    width: 340px;
    height: 340px;
    background: #284C2A;
    bottom: -100px;
    right: -80px;
    animation-delay: 2s;
}

.blob3 {
    width: 220px;
    height: 220px;
    background: #848048;
    top: 60%;
    left: 60%;
    animation-delay: 4s;
}

@keyframes blobMove {
    0% {
        transform: scale(1) translateY(0) translateX(0);
    }

    100% {
        transform: scale(1.15) translateY(30px) translateX(40px);
    }
}

.brand-logo {
    width: 64px;
    height: 64px;
    object-fit: contain;
    filter: drop-shadow(0 2px 8px #4f8cff33);
}

.hero-title {
    letter-spacing: -2px;
    background: linear-gradient(90deg, #284C2A 60%, #848048 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
}

.hero-subtitle .first-half {
    color: #284C2A;
}

.hero-subtitle .second-half {
    color: #848048;
}

.stat-card {
    min-width: 130px;
    transition: transform 0.18s, box-shadow 0.18s;
}

.stat-card:hover {
    transform: translateY(-4px) scale(1.04);
    box-shadow: 0 8px 32px rgba(40, 76, 42, 0.13);
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }

    .brand-logo {
        width: 40px;
        height: 40px;
    }
}
</style>