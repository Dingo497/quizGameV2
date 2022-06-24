<template>
  <div>
    <LoadingElement v-if="!survey"/>
    <div v-else>
      <HeaderComponent :title="survey.title"></HeaderComponent>
      <ContentComponent>

        <form @submit.prevent="submitSurvey" class="container mx-auto">
          <div class="grid grid-cols-6 items-center">
            <div class="mr-4">
              <img :src="survey.image" alt="" />
            </div>
            <div class="col-span-5">
              <p class="text-gray-500 text-sm" v-html="survey.description"></p>
            </div>
          </div>

          <div v-if="surveyFinished" class="py-8 px-6 bg-emerald-400 text-white w-[600px] mx-auto">
            <div class="text-xl mb-3 font-semibold ">Thank you for participating in this survey.</div>
            <button @click="submitAnotherResponse" type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Submit another response
            </button>
            <MyButtonElement title="Submit another response" @click="submitAnotherResponse" />
          </div>
          <div v-else>
            <hr class="my-3">
            <div v-for="(question, i) of survey.questions" :key="question.id">
              <QuestionSubmission
                v-model="questionAnswers[question.id]"
                :question="question" 
                :index="i"
              >
              </QuestionSubmission>
            </div>
            <MyButtonElement title="Submit" :submitButton=true />
          </div>
        </form>
      </ContentComponent>
    </div>
  </div>
</template>


<script setup>
import HeaderComponent from '../components/PageLayout/HeaderComponent.vue';
import ContentComponent from '../components/PageLayout/ContentComponent.vue';
import LoadingElement from '../components/Core/LoadingElement.vue';
import QuestionSubmission from '../components/Submissions/QuestionSubmissions.vue';
import MyButtonElement from '../components/Core/MyButtonElement.vue';
import { ref, computed } from 'vue';
import store from '../store/store.js';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const questionAnswers = ref({});
let surveyFinished = ref(false);
const survey = computed(() => store.state.newSurvey);

if(!survey.value) {
  store.dispatch('getSurveyBySlug', route.params.slug);
}

const submitAnotherResponse = () => {
  router.push({ name: 'Surveys' });
}

const submitSurvey = () => {
  const keys = Object.keys(questionAnswers.value)
  const values = Object.values(questionAnswers.value)
  let finalQuestionAnswers = [];
  keys.forEach((key, i) => {
    finalQuestionAnswers.push([{id: key, value: values[i]}]);
  });

  const submittedAnswers = {
    survey_id: survey.value.id,
    author_user_id: survey.value.author[0].id,
    total_score: survey.value.score,
    answers: finalQuestionAnswers
  }

  store.dispatch('submitSurvey', submittedAnswers)
    .then((response) => {
      surveyFinished.value = true;
    });
}
</script>