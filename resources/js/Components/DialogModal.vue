<script setup lang="ts">
import { defineProps, defineEmits, ref, watch } from 'vue'

// Props for controlling the dialog open state
const props = defineProps({
  modelValue: Boolean
})

// Emits to notify parent about state changes
const emit = defineEmits(['update:modelValue'])

const isOpen = ref(props.modelValue)

// Watch for changes in modelValue prop to update internal state
watch(() => props.modelValue, (newValue) => {
  isOpen.value = newValue
})

// Function to close the dialog
const closeDialog = () => {
  emit('update:modelValue', false)
}

// Function to open the dialog
const openDialog = () => {
  emit('update:modelValue', true)
}
</script>

<template>
  <!-- Replace `Dialog` with the actual dialog implementation that supports open/close states -->
  <DialogComponent :open="isOpen" @close="closeDialog" @open="openDialog">
    <slot></slot>
  </DialogComponent>
</template>
