<script setup>
import {
  NumberField,
  NumberFieldContent,
  NumberFieldDecrement,
  NumberFieldIncrement,
  NumberFieldInput,
} from '@/Components/ui/number-field'
import { Label } from '@/Components/ui/label'
import { defineProps, useAttrs, defineEmits, ref, watch } from 'vue'

// Define props with default values
const props = defineProps({
  modelValue: { type: [Number, String], default: 0 },
  min: { type: Number, default: 0 },
  label: { type: String, default: '' },
})

// Define emits to handle custom events
const emit = defineEmits(['update:modelValue'])

// Get attributes passed to this component
const attrs = useAttrs()

// Create a reactive reference for the internal value
const internalValue = ref(props.modelValue)

// Watch for changes to the internal value and emit to the parent
watch(internalValue, (newValue) => {
  emit('update:modelValue', newValue)
})

// Watch for changes to the modelValue prop and update internalValue
watch(() => props.modelValue, (newValue) => {
  internalValue.value = newValue
})

// Methods to handle increment and decrement
const decrement = () => {
  internalValue.value = Math.max(props.min, internalValue.value - 1)
}

const increment = () => {
  internalValue.value = Number(internalValue.value) + 1
}
</script>

<template>
  <NumberField
    :value="internalValue"
    :min="props.min"
    v-bind="attrs"
  >
    <Label v-if="props.label">{{ props.label }}</Label>
    <NumberFieldContent>
      <NumberFieldDecrement @click="decrement" />
      <NumberFieldInput :value="internalValue" @input="e => internalValue.value = e.target.value" />
      <NumberFieldIncrement @click="increment" />
    </NumberFieldContent>
  </NumberField>
</template>
