<script setup>
import { useRouter } from 'vue-router'
const router = useRouter()

function browseMaterials() {
  router.push('/materials')
}
function postItem() {
  router.push('/post')
}
</script>

<template>
  <section class="cta-final-section text-center py-5 px-3 text-white mt-5">
    <h2 class="fw-bold mb-3 cta-title">Start building or clearing out today.</h2>
    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
      <button class="btn btn-lg btn-primary rounded-pill px-5 shadow bg-white fw-bold" @click="browseMaterials">
        Browse Materials
      </button>
      <button class="btn btn-lg btn-outline-success text-white bg-transparent fw-bold rounded-pill px-5 shadow"
        @click="postItem">
        Post an Item
      </button>
    </div>
  </section>
</template>

<style scoped>
.cta-final-section {
  border-radius: 2rem 2rem 0 0;
  background: linear-gradient(90deg, #4f8cff 0%, #284C2A 100%);
  box-shadow: 0 8px 32px rgba(40, 76, 42, 0.10);
}

.cta-title {
  font-family: 'Arial Black', Arial, sans-serif;
  font-size: 2rem;
  letter-spacing: -1px;
}

.btn-primary {
  color: #284C2A;
  border: none;
  transition: background 0.2s, color 0.2s;
}

.btn-primary:hover {
  background: #284C2A;
  color: #fff;
}

.btn-outline-success {
  border: 2px solid #fff;
  transition: background 0.2s, color 0.2s, border 0.2s;
}

.btn-outline-success:hover {
  background: #fff;
  color: #284C2A;
  border: 2px solid #fff;
}

@media (max-width: 768px) {
  .cta-title {
    font-size: 1.2rem;
  }

  .cta-final-section {
    padding: 2rem 0.5rem !important;
  }
}
</style>