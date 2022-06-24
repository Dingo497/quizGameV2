<template>
  <router-link v-if="where" :to="where" class=" mt-2 inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"> 
    <slot name="svg"></slot>
    {{ title }}
  </router-link>
  <button v-else-if="submitButton" type="submit" class=" mt-2 inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
    <slot name="svg"></slot>
    {{ title }}
  </button>
</template>


<script setup>
const props = defineProps({
  where: Object,
  title: String,
  submitButton: Boolean
});
</script>