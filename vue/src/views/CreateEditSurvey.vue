<template>
  <div>
    <HeaderComponent title="Create new survey"></HeaderComponent>
    <LoadingElement v-if="store.state.loading"/>
    <ContentComponent v-else>
      <form @submit.prevent="saveSurvey" class="animate-fade-in-down">
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <!-- Survey Fields -->
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <!-- Image -->
          <div>
            <label class="block text-sm font-medium text-gray-700">
              Image
            </label>
            <div class="mt-1 flex items-center">
              <img
                v-if="model.image_url"
                :src="model.image_url"
                :alt="model.title"
                class="w-64 h-48 object-cover"
              />
              <span
                v-else
                class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-[80%] w-[80%] text-gray-300"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                    clip-rule="evenodd"
                  />
                </svg>
              </span>
              <button
                type="button"
                class="relative overflow-hidden ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <input
                  type="file"
                  @change="onImageChoose"
                  class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                />
                Change
              </button>
            </div>
          </div>
          <!--/ Image -->

          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700"
              >Title</label
            >
            <input
              type="text"
              name="title"
              id="title"
              v-model="model.title"
              autocomplete="survey_title"
              class="mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-500 rounded-md"
            />
          </div>
          <!--/ Title -->

          <!-- Description -->
          <div>
            <label for="about" class="block text-sm font-medium text-gray-700">
              Description
            </label>
            <div class="mt-1">
              <textarea
                id="description"
                name="description"
                rows="3"
                v-model="model.description"
                autocomplete="survey_description"
                class="shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                placeholder="Describe your survey"
              />
            </div>
          </div>
          <!-- Description -->

          <!-- Expire Date -->
          <div>
            <label
              for="expire_date"
              class="block text-sm font-medium text-gray-700"
              >Expire Date</label
            >
            <input
              type="date"
              name="expire_date"
              id="expire_date"
              v-model="model.expire_date"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            />
          </div>
          <!--/ Expire Date -->
        </div>
        <!--/ Survey Fields -->

        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
          <h3 class="text-2xl font-semibold flex items-center justify-between">
            Questions

            <!-- Add new question -->
            <button
              type="button"
              @click="addQuestion()"
              class="flex items-center text-sm py-1 px-4 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                  clip-rule="evenodd"
                />
              </svg>
              Add Question
            </button>
            <!--/ Add new question -->
          </h3>
          <div v-if="!model.questions.length" class="text-center text-gray-600">
            You don't have any questions created
          </div>
          <div v-else v-for="(question, index) in model.questions" :key="question.id">
            <QuestionEditorComponent
              :question="question"
              :index="index"
              @change="questionChange"
              @addQuestion="addQuestion"
              @deleteQuestion="deleteQuestion"
            />
          </div>
        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <MyButtonElement title="Save Survey" :submitButton=true />
        </div>
      </div>
    </form>
    </ContentComponent>
  </div>
</template>


<script setup>
import HeaderComponent from '../components/PageLayout/HeaderComponent.vue';
import ContentComponent from '../components/PageLayout/ContentComponent.vue';
import LoadingElement from '../components/Core/LoadingElement.vue';
import QuestionEditorComponent from '../components/Editors/QuestionEditorComponent.vue';
import MyButtonElement from '../components/Core/MyButtonElement.vue';
import { v4 as uuidv4 } from "uuid";
import { ref } from 'vue';
import store from '../store/store.js';
import { useRouter } from 'vue-router';

const router = useRouter();
const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);

// New survey
let model = ref({
  title: "",
  slug: "",
  score: 0,
  user_id: "",
  description: null,
  image: null,
  image_url: null,
  expire_date: null,
  questions: [],
});

// func when image is chosen then show it
const onImageChoose = (ev) => {
  const file = ev.target.files[0];

  const reader = new FileReader();
  reader.onload = () => {
    // for backend
    model.value.image = reader.result;
    // for display
    model.value.image_url = reader.result;
    ev.target.value = "";
  };
  reader.readAsDataURL(file);
}

// form save new survey
const saveSurvey = () => {
  model.value.questions.forEach(question => {
    model.value.score = model.value.score + question.score
  });
  let action = "created";
  if (model.value.id) {
    action = "updated";
  }
  
  store.dispatch("saveSurvey", model.value)
    .then(( response ) => {
      router.push({
        name: "SurveyView",
        params: { slug: response.data.slug },
      });
  });
}

// create new question
const addQuestion = (index) => {
  const newQuestion = {
    id: uuidv4(),
    type: "text",
    title: "",
    score: 0,
    description: null,
    options: [],
  };
  model.value.questions.splice(index, 0, newQuestion);
}

const questionChange = (question) => {
  if (question.options) {
    question.options = [...question.options];
  }
  model.value.questions = model.value.questions.map((q) => {
    if (q.id === question.id) {
      return JSON.parse(JSON.stringify(question));
    }
    return q;
  });
}

// delete question
const deleteQuestion = (question) => {
  model.value.questions = model.value.questions.filter((q) => q !== question);
}
</script>