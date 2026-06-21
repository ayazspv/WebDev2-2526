<template>
  <div class="container py-5 text-center align-items-center">
    <div class="success-icon mb-4">
      <i class="fas fa-check-circle"></i>
    </div>
    <h1 class="fw-bold text-success mb-3">Order Placed Successfully!</h1>
    <p class="lead mb-4">
      Thank you for your purchase. Your order has been received and is being processed.<br>
      You will receive a confirmation email shortly.
    </p>
    <router-link to="/dashboard/user" class="btn btn-gradient px-4 py-2 me-2">
      <i class="fas fa-box-open me-2"></i>View My Orders
    </router-link>
  </div>
</template>

<script setup>
</script>

<style scoped>
.success-icon {
  font-size: 5rem;
  color: #27ae60;
  animation: pop 0.5s;
}
@keyframes pop {
  0% { transform: scale(0.7); opacity: 0.5; }
  70% { transform: scale(1.1); opacity: 1; }
  100% { transform: scale(1); }
}
.btn-gradient {
  background: linear-gradient(90deg, #4f8cff 0%, #27ae60 100%);
  color: #fff;
  border: none;
  transition: box-shadow 0.2s;
}
.btn-gradient:hover {
  box-shadow: 0 2px 12px rgba(79, 140, 255, 0.15);
}
</style>