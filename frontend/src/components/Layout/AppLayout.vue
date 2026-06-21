<script setup>

import Header from './Header.vue';
import Footer from './Footer.vue';

import { useRoute } from 'vue-router';
const route = useRoute();

</script>
<template>
    <div class="d-flex flex-column">
        <Header />
        <main class="d-flex flex-column">
            <slot />
        </main>
        <Footer />
    </div>
</template>
<style scoped></style>