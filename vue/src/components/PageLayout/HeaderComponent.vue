<template>
  <header class="bg-white shadow">
    <div :class="(title) ? 'flex justify-between' : ''" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold text-gray-900">{{ title }}</h1>
      <slot></slot>
    </div>
  </header>
</template>


<script setup>
const props = defineProps({
  title: String
});
</script>


<style scoped>
</style>