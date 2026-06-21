<script setup>
const steps = [
  {
    icon: 'fas fa-search',
    color: 'text-primary',
    title: 'Discover',
    desc: 'Browse and find reusable materials for your next project with advanced filters and smart search.',
    step: 1,
  },
  {
    icon: 'fas fa-exchange-alt',
    color: 'text-success',
    title: 'Connect',
    desc: 'Easily connect with suppliers and professionals to exchange or acquire materials securely.',
    step: 2,
  },
  {
    icon: 'fas fa-recycle',
    color: 'text-warning',
    title: 'Reuse',
    desc: 'Give materials a second life, contribute to sustainability, and track your impact in real time.',
    step: 3,
  },
]
</script>

<template>
  <!-- Features Section -->
  <section class="steps-section container my-5 py-5">
    <h2 class="text-center fw-bold mb-5 steps-title">How CircuTrade Works</h2>
    <div class="row g-5 justify-content-center align-items-center">
      <div
        v-for="step in steps"
        :key="step.title"
        class="col-12 col-md-4"
      >
        <div
          class="step-card text-center p-4 rounded-4 h-100 position-relative shadow-lg d-flex flex-column align-items-center justify-content-center"
        >
          <div class="step-number position-absolute top-0 start-50 translate-middle badge rounded-pill bg-gradient">
            {{ step.step }}
          </div>
          <div :class="['step-icon', step.color, 'mb-3']">
            <i :class="[step.icon, 'fa-3x']"></i>
          </div>
          <h3 class="fw-bold mb-2">{{ step.title }}</h3>
          <p class="text-secondary mb-0">{{ step.desc }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.steps-section {
  background: linear-gradient(120deg, #f8fafc 60%, #e0e7ef 100%);
  border-radius: 24px;
  box-shadow: 0 4px 24px rgba(40,76,42,0.08);
}
.steps-title {
  font-family: Arial Black, Arial, sans-serif;
  color: #284C2A;
  letter-spacing: -1px;
}
.step-card {
  background: rgba(255,255,255,0.85);
  border: none;
  transition: transform 0.18s, box-shadow 0.18s;
  cursor: pointer;
  min-height: 320px;
  position: relative;
  overflow: hidden;
}
.step-card:hover {
  transform: translateY(-6px) scale(1.04);
  box-shadow: 0 8px 32px rgba(40,76,42,0.13);
  background: rgba(255,255,255,0.97);
}
.step-icon {
  transition: transform 0.2s;
}
.step-card:hover .step-icon {
  transform: scale(1.15) rotate(-6deg);
}
.step-number {
  top: -18px;
  left: 50%;
  font-size: 1.2rem;
  background: linear-gradient(90deg, #284C2A 0%, #848048 100%);
  color: #fff;
  padding: 0.5em 1.2em;
  font-weight: bold;
  box-shadow: 0 2px 8px rgba(40,76,42,0.13);
  z-index: 2;
}
@media (max-width: 768px) {
  .step-card {
    min-height: 220px;
    padding: 1.2rem;
  }
  .steps-title {
    font-size: 1.5rem;
  }
}
</style>