<template>
  <fieldset class="mb-4">
    <div>
      <legend class="text-base font-medium text-gray-900">
        {{ index + 1 }}. {{ question.title }}
      </legend>
      <p class="text-gray-500 text-sm">
        {{ question.description }}
      </p>
    </div>
    <div class="mt-3">
      <div v-if="question.type === 'select'">
        <select
          :id="'select_' + question.id"
          :value="question.title"
          @change="emitModelValue($event)"
          class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
          <option v-for="option in question.answers" :key="option.id" :value="option.text">
            {{ option.text }}
          </option>
        </select>
      </div>
      <div v-else-if="question.type === 'radio'">
        <div
          v-for="(option, ind) of question.answers"
          :key="option.id"
          class="flex items-center"
        >
          <input
            :id="option.id"
            :name="'question' + question.id"
            :value="option.text"
            @change="emitModelValue($event)"
            type="radio"
            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
          />
          <label
            :for="option.id"
            class="ml-3 block text-sm font-medium text-gray-700"
          >
            {{ option.text }}
          </label>
        </div>
      </div>
      <div v-else-if="question.type === 'checkbox'">
        <div
          v-for="(option, ind) of question.answers"
          :key="option.id"
          class="flex items-center"
        >
          <input
            :id="option.id"
            v-model="model[option.text]"
            @change="onCheckboxChange"
            type="checkbox"
            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
          />
          <label
            :for="option.id"
            class="ml-3 block text-sm font-medium text-gray-700"
          >
            {{ option.text }}
          </label>
        </div>
      </div>
      <div v-else-if="question.type === 'text'">
        <input
          type="text"
          :value="modelValue"
          @input="emitModelValue($event)"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
        />
      </div>
      <div v-else-if="question.type === 'textarea'">
        <textarea
          :value="modelValue"
          @input="emitModelValue($event)"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
        ></textarea>
      </div>
    </div>
  </fieldset>
  <hr class="mb-4" />
</template>

<script setup>
import { ref } from "vue";
const { question, index, modelValue } = defineProps({
  question: Object,
  index: Number,
  modelValue: [String, Array],
});
const emits = defineEmits(["update:modelValue"]);

let model;
if (question.type === "checkbox") {
  model = ref({});
}

function shouldHaveOptions() {
  return ["select", "radio", "checkbox"].includes(question.type);
}

function onCheckboxChange($event) {
  const selectedOptions = [];
  for (let id in model.value) {
    if (model.value[id]) {
      selectedOptions.push(id);
    }
  }
  emits("update:modelValue", selectedOptions);
}

function emitModelValue($event) {
  const newValue = $event.target.value;
  emits('update:modelValue', $event.target.value);
  if($event.target.tagName === 'SELECT') {
    setTimeout(() => { document.getElementById($event.target.id).value = newValue; }, 10);
  }
}
</script>
