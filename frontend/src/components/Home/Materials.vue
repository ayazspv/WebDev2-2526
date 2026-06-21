<script setup>
import { onMounted, computed } from 'vue'
import { useMaterialStore } from '@/stores/materialStore'
import MaterialCard from '../Materials/MaterialCard.vue'

const materialStore = useMaterialStore()

onMounted(async () => {
  if (!materialStore.materials.length) {
    await materialStore.fetchMaterials()
  }
})

const materials = computed(() => materialStore.materials)
</script>

<template>
  <div class="container d-flex gap-4 align-items-top mb-5">
    <section class="materials-section container my-5 py-4 rounded-4 shadow-sm">
      <h2 class="fw-bold mb-4 featured-title text-center">Featured Listings</h2>
      <div class="row g-4">
        <div
          v-for="item in materials"
          :key="item.id"
          class="col-12 col-sm-6 col-lg-3"
        >
          <MaterialCard :item="item" />
        </div>
      </div>
    </section>
    <router-view />
  </div>
</template>

<style scoped>
.materials-section {
  background: linear-gradient(120deg, #f8fafc 60%, #e0e7ef 100%);
}
.featured-title {
  font-family: Arial Black, Arial, sans-serif;
  color: #284C2A;
  letter-spacing: -1px;
}
</style>