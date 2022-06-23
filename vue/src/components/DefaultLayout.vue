<template>
  <div class="min-h-full">
    <NavigationComponent />
    <router-view />
  </div>
</template>

<script setup>
import NavigationComponent from './NavigationComponent.vue';
</script>