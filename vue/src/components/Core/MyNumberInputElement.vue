<template>
  <div class="inline-flex">
    <div 
      class="select-none border cursor-pointer bg-gray-100 hover:bg-gray-200 rounded-l" 
      :class="(size === 'small') ? ('py-0.5 px-2') : ('py-2 px-4')"
      @click="decrease"
    >
      -
    </div>

    <input 
      class="border p-0.5 text-center outline-none" 
      type="text" 
      v-model="number" 
      :name="name" 
      @change="updateNumber" 
    />

    <div 
      class="select-none border cursor-pointer bg-gray-100 hover:bg-gray-200 rounded-r" 
      :class="(size === 'small') ? ('py-0.5 px-2') : ('py-2 px-4')"
      @click="increase"
    >
      +
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  name: String, // name of input element
  modelValue: Number, // parent v-model 
  size: String // size of component small or big
});

const emits = defineEmits(["update:modelValue"]);

const number = ref(0);

const increase = () => {
  number.value++;
  emits("update:modelValue", number.value);
};

const decrease = () => {
  if (number.value > 1) {
    number.value--;
    emits("update:modelValue", number.value);
  }
};

const updateNumber = (ev) => {
  emits("update:modelValue", parseInt(ev.target.value));
}
</script>
