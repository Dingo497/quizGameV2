<template>
  <div>
    <h3 class="text-base flex justify-center">{{ title }}</h3>
    <div class="flex mt-2 justify-center">
      <div class="p-1 bg-gradient-to-tr from-amber-500 to-fuchsia-700 rounded-full">
        <div class="p-1 bg-white rounded-full">
          <h4 class="flex items-center p-4 text-7xl">{{ count }}</h4>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
const props = defineProps({
  title: String,
  count: Number
});
</script>