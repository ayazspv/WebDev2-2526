<script setup>
</script>

<template>
  <!-- Mission Section -->
  <section class="container my-5 py-5 px-4 px-md-5 rounded-4 shadow-lg position-relative overflow-hidden bg-light">
    <!-- Decorative SVG background -->
    <svg class="position-absolute top-0 start-0 w-100 h-100" viewBox="0 0 600 300" fill="none" xmlns="http://www.w3.org/2000/svg" style="z-index:1;pointer-events:none;">
      <ellipse cx="500" cy="0" rx="300" ry="100" fill="#4f8cff" fill-opacity="0.08"/>
      <ellipse cx="100" cy="300" rx="200" ry="60" fill="#284C2A" fill-opacity="0.07"/>
    </svg>
    <div class="row align-items-center position-relative" style="z-index:2;">
      <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
        <h2 class="fw-bold mb-3 lh-1">
          <span class="px-3 py-1 rounded-pill text-white head-text">Our Mission</span>
        </h2>
        <p class="lead mb-4 fst-italic fw-semibold">
          <span class="d-inline-block px-4 py-2 rounded-pill subhead-text">“Empowering a circular future, one material at a time.”</span>
        </p>
        <ul class="list-unstyled mb-4">
          <li class="d-flex align-items-start mb-3 fs-6">
            <i class="fas fa-recycle text-success me-2 fs-5"></i>
            <span><b>Reduce Waste:</b> Give new life to valuable materials and minimize environmental impact.</span>
          </li>
          <li class="d-flex align-items-start mb-3 fs-6">
            <i class="fas fa-users text-primary me-2 fs-5"></i>
            <span><b>Connect People:</b> Build a vibrant network of professionals, suppliers, and innovators.</span>
          </li>
          <li class="d-flex align-items-start mb-3 fs-6">
            <i class="fas fa-lightbulb text-warning me-2 fs-5"></i>
            <span><b>Drive Innovation:</b> Use data-driven insights to inspire smarter, sustainable choices.</span>
          </li>
        </ul>
        <div class="mt-3">
          <router-link to="/register" class="btn btn-lg btn-success rounded-pill px-5 py-2 shadow fw-bold">Join the Movement</router-link>
        </div>
      </div>
      <div class="col-md-6 text-center">
        <div class="mx-auto position-relative d-inline-block" style="max-width:340px;">
          <img src="#" alt="Our Mission" class="img-fluid rounded-4 shadow-lg border border-4 border-white" />
          <div class="position-absolute top-50 start-50 translate-middle effect"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.head-text {
  background: linear-gradient(90deg, #4f8cff 0%, #284C2A 100%); 
  font-family: 'Arial Black', Arial, sans-serif; 
  font-size:2.5rem; 
  letter-spacing:-1px; 
  box-shadow:0 2px 12px rgba(79,140,255,0.08);
}
.subhead-text {
  background: #e0e7ef;
  color: #4f8cff;
  font-size: 1.1em;
  box-shadow: 0 2px 8px rgba(40,76,42,0.07);
}
.effect {
  width:110%;
  height:110%;
  background:radial-gradient(circle,#4f8cff33 0%,#fff0 80%);
  border-radius:1.5rem;
  z-index:1;
  pointer-events:none;
}
</style>