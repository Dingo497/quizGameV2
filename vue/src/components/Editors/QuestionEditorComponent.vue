<template>
  <!-- Question index -->
  <div class="flex items-center justify-between">
    <h3 class="text-lg font-bold">
      {{ props.index + 1 }}. {{ model.question }}
    </h3>

    <div class="flex items-center">
      <!-- Add new question -->
      <button
        type="button"
        @click="addQuestion()"
        class="flex items-center text-xs py-1 px-3 mr-2 rounded-sm text-white bg-gray-600hover:bg-gray-700"
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
        Add
      </button>
      <!--/ Add new question -->

      <!-- Delete question -->
      <button
        type="button"
        @click="deleteQuestion()"
        class="flex items-center text-xs py-1 px-3 rounded-sm border border-transparent text-red-500 hover:border-red-600"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
            clip-rule="evenodd"
          />
        </svg>
        Delete
      </button>
      <!--/ Delete question -->
    </div>
  </div>
  <!--/ Question index -->
  <div class="grid gap-3 grid-cols-12">
    <!-- Question -->
    <div class="mt-3 col-span-9">
      <label
        :for="'question_text_' + model.data"
        class="block text-sm font-medium text-gray-700"
        >Question Text</label
      >
      <input
        type="text"
        :name="'question_text_' + model.data"
        v-model="model.title"
        @change="dataChange"
        :id="'question_text_' + model.data"
        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      />
    </div>
    <!--/ Question -->

    <!-- Question Type -->
    <div class="mt-3 col-span-3 question_type">
      <label for="question_type" class="block text-sm font-medium text-gray-700"
        >Select Question Type</label
      >
      <select
        :id="`question_type_${props.index}`"
        name="question_type"
        v-model="model.type"
        @change="typeChange"
        class="mt-1 block w-full py-2 px-3 border border-gray-300bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
      >
        <option v-for="type in questionTypes" :key="type" :value="type">
          {{ upperCaseFirst(type) }}
        </option>
      </select>
    </div>
    <!--/ Question Type -->
  </div>

  <!-- SCORE -->
  <div class="col-span-9">
    <label
      :for="'score_' + model.data"
      class="block text-sm font-medium text-gray-700"
      >Question Score</label
    >
    <MyNumberInputElement 
      name="question_score" 
      size="small"
      v-model="model.score" 
      @change="dataChange"
    />
  </div>
  <!--/ SCORE -->

  <!-- Question Description -->
  <div class="mt-3 col-span-9">
    <label
      :for="'question_description_' + model.id"
      class="block text-sm font-medium text-gray-700"
      >Description</label
    >
    <textarea
      :name="'question_description_' + model.id"
      v-model="model.description"
      @change="dataChange"
      :id="'question_description_' + model.id"
      class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
    />
  </div>
  <!--/ Question Description -->

  <!-- Data -->
  <div>
    <div v-if="shouldHaveOptions()" class="mt-2" id="options-list">
      <h4 class="text-sm font-semibold mb-1 flex justify-between items-center">
        Options

        <!-- Add new option -->
        <button
          type="button"
          @click="addOption()"
          class="flex items-center text-xs py-1 px-2 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
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
          Add Option
        </button>
        <!--/ Add new option -->
      </h4>

      <div
        v-if="!model.options.length"
        class="text-xs text-gray-600 text-center py-3"
      >
        You don't have any options defined
      </div>
      <!-- Option list -->
      <div
        v-for="(option, index) in model.options"
        :key="option.uuid"
        class="flex items-center mb-1 option"
      >
        <span class="w-12 text-sm"> {{ index + 1 }}. </span>
        <input
          type="text"
          tabindex="1"
          v-model="option.text"
          @change="dataChange"
          class="w-full rounded-sm py-1 px-2 text-xs border border-gray-300 focus:border-indigo-500"
        />
        <!-- Delete Option -->
        <button
          type="button"
          @click="removeOption(option)"
          class="h-8 w-8 rounded-full flex items-center justify-center border border-transparent transition-colors hover:border-red-200"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-7 w-7 pl-1 pt-1 text-red-500"
            viewBox="0 0 24 24"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
        <!--/ Delete Option -->

        <!-- Delete Option -->
        <button
          type="button"
          @click="selectCorrectAnswer(option, )"
          :id="`submit_button_${option.uuid}`"
          class="h-8 w-8 rounded-full flex items-center justify-center border border-transparent transition-colors hover:border-green-200 correct-answer"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            class="h-6 w-6 text-green-500" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor" 
            stroke-width="2"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </button>
        <!--/ Delete Option -->
      </div>
      <!--/ Option list -->
    </div>
  </div>
  <!--/ Data -->
  <hr class="my-4" />
</template>


<script setup>
import MyNumberInputElement from '../Core/MyNumberInputElement.vue';
import { v4 as uuidv4 } from "uuid";
import { computed, ref } from "@vue/reactivity";
import store from "../../store/store.js";

const props = defineProps({
  question: Object,
  index: Number,
});

const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);

// Re-create the whole question data
const model = ref(JSON.parse(JSON.stringify(props.question)));

// Get question types from vuex
const questionTypes = computed(() => store.state.questionTypes);

const upperCaseFirst = (str) => str.charAt(0).toUpperCase() + str.slice(1);

const getOptions = () => model.value.options;

const setOptions = (options) => model.value.options = options;

// Check if the question should have options
const shouldHaveOptions = () => ["select", "radio", "checkbox"].includes(model.value.type);

const addOption = () => {
  setOptions([
    ...getOptions(),
    { uuid: uuidv4(), text: "", correctAnswer: false },
  ]);
  dataChange();
};

const removeOption = (op) => {
  setOptions(getOptions().filter((opt) => opt !== op));
  dataChange();
};

// change type of question
const typeChange = () => {
  if (shouldHaveOptions()) {
    setOptions(getOptions() || []);
  }
  dataChange();
};

// Emit the data change
const dataChange = () => {
  const data = model.value;
  if (!shouldHaveOptions()) {
    delete data.options;
  }

  emit("change", data);
};

const addQuestion = () => emit("addQuestion", props.index + 1);

const deleteQuestion = () => emit("deleteQuestion", props.question);

// select what answer(option) is correct
const selectCorrectAnswer = (option) => {
  const currentElement = document.getElementById(`submit_button_${option.uuid}`);
  const typeValue = document.getElementById(`question_type_${props.index}`).value;
  if(option.correctAnswer === false) {
    option.correctAnswer = true;
    currentElement.classList.add('bg-green-200');
    disableOtherOptions(currentElement, typeValue, false);
  } else {
    option.correctAnswer = false;
    currentElement.classList.remove('bg-green-200');
    disableOtherOptions(currentElement, typeValue, true);
  }
  dataChange();
};

// INTERN FUNCTION 
// disable other options (correct answer buttons) if type of question is radio|select
const disableOtherOptions = (el, type, reset) => {
  const element = el.parentElement.parentElement
  if(type === 'select' || type === 'radio') {
    let options = element.querySelectorAll('.option .correct-answer:not(.bg-green-200)')
    options.forEach(el => {
      if(reset) el.disabled = false;
      else el.disabled = true;
    });
  }
};
</script>