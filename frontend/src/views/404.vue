<script setup>

</script>

<template>
    <div class="not-found-container d-flex flex-column align-items-center justify-content-center min-vh-80 vh-100 text-center p-4">
        <div class="error-animation mb-4">
            <svg width="180" height="180" viewBox="0 0 180 180">
                <circle class="circle" cx="90" cy="90" r="80" />
                <text x="50%" y="50%" text-anchor="middle" dy=".3em" class="error-text">404</text>
            </svg>
        </div>
        <h1>Oops! Page Not Found</h1>
        <p>
            The page you are looking for doesn’t exist or has been moved.<br>
            Let’s get you back on track!
        </p>
        <router-link to="/" class="home-btn d-inline-block px-4 py-3 text-white text-decoration-none fw-semibold rounded-pill">Go Home</router-link>
    </div>
</template>



<style scoped>
.not-found-container {
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%);
}

.circle {
    fill: none;
    stroke: #4f8cff;
    stroke-width: 8;
    stroke-dasharray: 502;
    stroke-dashoffset: 502;
    animation: dash 1.2s ease-out forwards;
}

@keyframes dash {
    to {
        stroke-dashoffset: 0;
    }
}

.error-text {
    font-size: 3.5rem;
    fill: #4f8cff;
    font-weight: bold;
    font-family: 'Segoe UI', 'Arial', sans-serif;
    user-select: none;
}

h1 {
    font-size: 2.2rem;
    color: #22223b;
    margin-bottom: 12px;
}

p {
    color: #4a4e69;
    margin-bottom: 28px;
    font-size: 1.1rem;
}

.home-btn {
    background: #4f8cff;
  font-size: 1.1rem;
  box-shadow: 0 2px 12px rgba(79, 140, 255, 0.15);
  transition: background 0.2s;
}

.home-btn:hover {
    background: #2563eb;
}
</style>