<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/Components/ui/collapsible';
import { ChevronDownIcon, ChevronUpIcon } from '@radix-icons/vue'; // Import Radix Icons

// Define props
const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  }
});

// Define emits
const emit = defineEmits(['update:modelValue']);

// Create a reactive state variable to track if the collapsible is open
const isOpen = ref(props.modelValue);

// Watch for changes in modelValue prop and update isOpen
watch(() => props.modelValue, (newValue) => {
  isOpen.value = newValue;
});

// Watch for changes in isOpen and emit update:modelValue event
watch(isOpen, (newValue) => {
  emit('update:modelValue', newValue);
});

// Function to toggle the open/closed state
const toggleOpen = () => {
  isOpen.value = !isOpen.value;
};
</script>

<template>
  <Collapsible :open="isOpen" class="overflow-x-auto mb-1">
    <CollapsibleTrigger 
      :class="['flex justify-between items-center w-full text-left font-semibold text-sm border border-b-0 rounded-lg px-3 py-2 bg-slate-200 hover:bg-slate-300', isOpen ? 'rounded-b-none' : '']" 
      @click="toggleOpen"
    >
      <!-- Slot for trigger content -->
      <slot name="trigger"></slot>
      <component class="shrink-0 ml-2" :is="isOpen ? ChevronUpIcon : ChevronDownIcon" />
    </CollapsibleTrigger>
    <CollapsibleContent :class="['py-2 rounded-lg border border-t-0 px-3', isOpen ? 'rounded-t-none' : '']">
      <!-- Slot for collapsible content -->
      <slot name="content"></slot>
    </CollapsibleContent>
  </Collapsible>
</template>
