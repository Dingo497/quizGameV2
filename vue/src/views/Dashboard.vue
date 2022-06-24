<template>
  <div>
    <HeaderComponent title="">
      <LoadingElement v-if="store.state.loading"/>
      <div v-if="countCardData" class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-4">
        <CountCardComponent title="Num of your Surveys" :count="countCardData.numOfSurveys" />
        <CountCardComponent title="Num of completed surveys" :count="countCardData.numOfSubmitted" />
        <CountCardComponent title="Num of your Followers" :count="countCardData.followers" />
        <CountCardComponent title="Num of your Score" :count="countCardData.score" />
      </div>
    </HeaderComponent>
    <ContentComponent>
      <LoadingElement v-if="store.state.loading"/>
      <div v-if="cardData" class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">
        <CardComponent v-for="card in cardData" :key="card.id" :data="card"></CardComponent>
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
import { computed } from 'vue';
import store from '../store/store.js';

store.dispatch('getDashboardSurveys');
const cardData = computed(() => store.state.dashboardSurveys);

store.dispatch('getDashboardNumbers');
const countCardData = computed(() => store.state.dashboardNumbers);
</script>