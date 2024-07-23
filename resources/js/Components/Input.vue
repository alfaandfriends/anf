<script setup lang="ts">
import { ref, onMounted, nextTick, defineProps, defineEmits, useAttrs } from 'vue';
import { Input } from '@/Components/ui/input';

// Define props and emits
const props = defineProps({
  modelValue: String // Adjust type according to your needs
});

const emit = defineEmits(['update:modelValue']);

// Create a ref for the input element
const input = ref<HTMLInputElement | null>(null);

// Get non-props attributes
const attrs = useAttrs();

onMounted(async () => {
  // Ensure the DOM is updated before performing operations
  await nextTick();
  
  // Check if input.value is defined and is an HTMLInputElement
  if (input.value instanceof HTMLInputElement) {
    // Check for the autofocus attribute and focus the element
    if (input.value.hasAttribute('autofocus')) {
      input.value.focus();
    }
  }
});
</script>

<template>
  <Input
    v-bind="attrs"
    :value="modelValue"
    @input="event => emit('update:modelValue', event.target.value)"
    ref="input"
  />
</template>
