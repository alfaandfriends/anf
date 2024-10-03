<script setup>
import { computed, ref, watch } from 'vue';
import { SwitchRoot, SwitchThumb, useForwardPropsEmits } from 'radix-vue';
import { cn } from '@/lib/utils';

// Define props
const props = defineProps({
  modelValue: { type: Boolean, required: false },
  defaultChecked: { type: Boolean, required: false },
  disabled: { type: Boolean, required: false },
  required: { type: Boolean, required: false },
  name: { type: String, required: false },
  id: { type: String, required: false },
  value: { type: String, required: false },
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
});

// Define emits
const emits = defineEmits(['update:modelValue']);

// Internal state to manage the checked status
const checked = ref(props.modelValue ?? props.defaultChecked ?? false);

// Watch for changes in the modelValue prop
watch(() => props.modelValue, (newVal) => {
  checked.value = newVal;
});

// Toggle handler
const handleSwitchChange = () => {
  if (props.disabled) return; // Prevent toggling if disabled
  checked.value = !checked.value;
  emits('update:modelValue', checked.value);
};

// Forward props and emits
const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;
  return delegated;
});

const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
  <SwitchRoot
    v-bind="forwarded"
    :class="cn(
      'peer inline-flex h-5 w-9 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 focus-visible:ring-offset-2 focus-visible:ring-offset-white disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-slate-900 data-[state=unchecked]:bg-slate-200 dark:focus-visible:ring-slate-300 dark:focus-visible:ring-offset-slate-950 dark:data-[state=checked]:bg-slate-50 dark:data-[state=unchecked]:bg-slate-800',
      props.class
    )"
    :checked="checked"
    @click="handleSwitchChange"
  >
    <SwitchThumb
      :class="cn(
        'pointer-events-none block h-4 w-4 rounded-full bg-white shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-4 data-[state=unchecked]:translate-x-0 dark:bg-slate-950'
      )"
    />
  </SwitchRoot>
</template>
