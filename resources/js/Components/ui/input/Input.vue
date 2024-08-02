<script setup>
import { useVModel } from "@vueuse/core";
import { cn } from "@/lib/utils";
import { defineProps, defineEmits, useAttrs } from 'vue';

const props = defineProps({
  defaultValue: { type: [String, Number], required: false },
  modelValue: { type: [String, Number], required: false },
  class: { type: null, required: false },
  error: { type: [String, Boolean] },
  disabled: { type: Boolean, required: false, default: false } // Add disabled prop
});

const emits = defineEmits(["update:modelValue"]);

const modelValue = useVModel(props, "modelValue", emits, {
  passive: true,
  defaultValue: props.defaultValue,
});

const attrs = useAttrs();
</script>

<template>
  <div>
    <input
      v-model="modelValue"
      :class="
        cn(
          'flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed',
          {
            'bg-gray-50 text-slate-900 cursor-not-allowed': props.disabled, // Add class if disabled
          },
          props.class
        )
      "
      v-bind="attrs"
    />
    <p class="text-sm text-red-500 font-semibold" v-if="typeof error === 'string'">
      {{ error }}
    </p>
    <p class="text-sm text-red-500 font-semibold" v-if="typeof error === 'boolean' && error === true">
      This field is required.
    </p>
  </div>
</template>
