<script setup>
import { computed } from "vue";
import { AccordionHeader, AccordionTrigger } from "radix-vue";
import { ChevronDownIcon } from "@radix-icons/vue";
import { cn } from "@/lib/utils";

const props = defineProps({
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
});

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;

  return delegated;
});
</script>

<template>
  <AccordionHeader class="flex">
    <AccordionTrigger
      v-bind="delegatedProps"
      :class="
cn(
  'flex flex-1 items-center justify-between py-4 text-sm font-medium transition-all [&[data-state=open]>svg]:rotate-180 text-slate-900 hover:text-white mb-1',
  props.class
)"
    >
      <slot />
      <slot name="icon">
        <ChevronDownIcon
          class="h-4 w-4 shrink-0 transition-transform duration-200 dark:text-slate-400"
        />
      </slot>
    </AccordionTrigger>
  </AccordionHeader>
</template>
