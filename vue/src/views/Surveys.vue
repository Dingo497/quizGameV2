<template>
  <div>
    <HeaderComponent title="All Surveys">
      <MyButtonElement title="Add new Survey" where="CreateSurvey">
        <template v-slot:svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -mt-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
        </template>
      </MyButtonElement>
    </HeaderComponent>
      <LoadingElement v-if="store.state.loading"/>
    <ContentComponent v-else-if="surveys.length">
       <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">
        <CardComponent v-for="survey in surveys" :key="survey.id" :data="survey" />
      </div>
    </ContentComponent>
  </div>
</template>


<script setup>
import MyButtonElement from '../components/Core/MyButtonElement.vue';
import HeaderComponent from '../components/PageLayout/HeaderComponent.vue';
import ContentComponent from '../components/PageLayout/ContentComponent.vue';
import LoadingElement from '../components/Core/LoadingElement.vue';
import CardComponent from '../components/Core/CardComponent.vue';
import { computed, ref } from 'vue';
import store from '../store';

store.dispatch('getAllSurveys');
const surveys = computed(() => store.state.allSurveys);
</script>


<style scoped>
</style>