<script setup>
import { cn } from "@/lib/utils";

const props = defineProps({
  class: { type: null, required: false },
});
</script>

<template>
  <th
    :class="
      cn(
        'h-10 px-6 py-2 text-left align-middle font-medium text-slate-600 bg-slate-200 [&:has([role=checkbox])]:pr-0 [&>[role=checkbox]]:translate-y-0.5 dark:text-slate-400 whitespace-nowrap',
        props.class,
      )
    "
  >
    <slot />
  </th>
</template>
