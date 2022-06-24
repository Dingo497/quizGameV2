<template>
  <div class="flex justify-center m-2">
    <div class="rounded-lg shadow-lg bg-white max-w-sm">
      <router-link v-if="data.image" :to="data.toOpen || ''">
        <img v-if="data.image" class="rounded-t-lg" :src="data.image" alt=""/>
      </router-link>
      <div class="p-6">
        <h5 class="text-gray-900 text-xl font-medium mb-2">{{ data.title }}</h5>
        <p class="text-gray-700 text-base mb-4">
          {{ data.description }}
        </p>
        <div v-if="data.created_at" class="flex justify-between">
          <h5 class="text-gray-900 text-base">Created At:</h5>
          <p class="text-gray-900 text-base">{{ data.created_at }}</p>
        </div>
        <div v-if="data.author" class="flex justify-between">
          <h5 class="text-gray-900 text-base">Author:</h5>
          <p class="text-gray-900 text-base">{{ data.author[0].name }}</p>
        </div>
        <div class="flex justify-between">
          <h5 class="text-gray-900 text-base">Subbmitted:</h5>
          <p class="text-gray-900 text-base">{{ data.submitted || 0 }}</p>
        </div>
        <div v-if="data.yourScore" class="flex justify-between">
          <h5 class="text-gray-900 text-base">Your Score:</h5>
          <p class="text-gray-900 text-base">{{ data.yourScore }}</p>
        </div>
        <div class="flex justify-between">
          <h5 class="text-gray-900 text-base">Score for this survey:</h5>
          <p class="text-gray-900 text-base">{{ data.score || 0 }}</p>
        </div>
        <div class="flex justify-between">
          <MyButtonElement v-if="data.toOpen" title="Open" :where="data.toOpen" />
          <MyButtonElement v-if="data.toEdit" title="Edit" :where="data.toEdit" />
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import MyButtonElement from './MyButtonElement.vue';

const props = defineProps({
  data: Object
});
</script>