<template>
  <div>
    <HeaderComponent title="">
      <LoadingElement v-if="store.state.loading"/>
      <div v-if="!store.state.loading" class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-4">
        <CountCardComponent title="Num of your Surveys" :count="countCardData.numOfSurveys" />
        <CountCardComponent title="Num of completed surveys" :count="countCardData.numOfSubmitted" />
        <CountCardComponent title="Num of your Followers" :count="countCardData.followers" />
        <CountCardComponent title="Num of your Score" :count="countCardData.score" />
      </div>
    </HeaderComponent>
    <ContentComponent>
      <LoadingElement v-if="store.state.loading"/>
      <div v-if="!store.state.loading" class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">
        <CardComponent :data="latestSurvey"></CardComponent>
        <CardComponent :data="latestAnswer"></CardComponent>
        <CardComponent :data="biggestScore"></CardComponent>
      </div>
    </ContentComponent>
  </div>
</template>


<script setup>
import CountCardComponent from '../components/Core/CountCardComponent.vue';
import HeaderComponent from '../components/PageLayout/HeaderComponent.vue';
import ContentComponent from '../components/PageLayout/ContentComponent.vue';
import CardComponent from '../components/Core/CardComponent.vue';
import LoadingElement from '../components/Core/LoadingElement.vue';
import { ref, onMounted } from 'vue';
import store from '../store';

let countCardData = ref({});
let latestSurvey = ref({});
let latestAnswer = ref({});
let biggestScore = ref({});

onMounted(() => {
  store.dispatch('getDashboardNumbers')
    .then((response) => {
      countCardData.value = response;
  }); 
  store.dispatch('getDashboardSurveys')
    .then((response) => {
      latestSurvey.value = response.latestSurvey;
      latestSurvey.value.toEdit = 'Dashboard'; // docasne
      latestSurvey.value.toOpen = 'Dashboard'; // docasne

      latestAnswer.value = response.latestAnswer;
      latestAnswer.value.toOpen = 'Dashboard'; // docasne
      
      biggestScore.value = response.biggestScore;
      biggestScore.value.toOpen = 'Dashboard'; // docasne
  });
})
</script>


<style scoped>
</style>