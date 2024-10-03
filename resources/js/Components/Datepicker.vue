<script setup>
import { ref, watch } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
// import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
  modelValue: {
    type: [String, Date, Object],
    default: new Date,
  },
  mode: {
    type: String,
    default: 'date'
  },
  format: {
    type: String,
    default: 'YYYY-MM-DD'
  },
  teleport: {
    type: [Boolean, String],
    default: 'body'
  },
  teleportCenter: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  },
  error: {
    type: [Boolean, String],
    default: false
  },
});

const emit = defineEmits(['update:modelValue', 'select']);

const internalValue = ref(props.modelValue);

watch(internalValue, (newValue) => {
  emit('update:modelValue', newValue);
  emit('select', newValue);
});

</script>

<template>
  <VueDatePicker
    v-model="internalValue" 
    :auto-apply="mode == 'time' ? false : true" 
    :clearable="false" 
    :enable-time-picker="mode == 'time' ? true : false" 
    :format="format" 
    :time-picker="mode == 'time' ? true : false"
    :month-picker="mode == 'month' ? true : false"
    :teleport="teleport"
    :teleport-center="teleportCenter"
    :is24="false"
    :disabled="disabled"
  />
  <p v-if="props.error" class="mt-0.5 text-xs text-red-500 font-semibold">
    This field is required.
  </p>
</template>

<style>
.dp__theme_light{
  @apply rounded-lg
}
.dp__overlay{
  @apply rounded-lg z-50
}
.dp__input_wrap{
  @apply relative border border-gray-200 hover:border-gray-200 rounded-md h-[34px] shadow-sm
}
.dp__input{
  @apply text-base text-[14px] h-[34px] border border-transparent font-medium font-sans rounded-md disabled:bg-gray-50 disabled:cursor-not-allowed hover:border-transparent;
}
.dp__active_date{
  @apply bg-primary border-primary;
}
.dp__overlay_cell_active{
  @apply bg-primary border-primary;
}
.dp__instance_calendar{
  @apply py-3 px-4 w-full text-sm;
}
.dp__today {
  @apply border-primary;
}
.dp__month_year_row{
  @apply py-6 px-4
}
.dp__month_year_col_nav{
  @apply border border-primary rounded-md px-1 py-0.5 hover:bg-gray-50
}
.dp__inner_nav{
  @apply hover:bg-transparent  
}
.dp__icon{
  @apply text-primary 
}
.dp__month_year_wrap{
  @apply space-x-2 px-2
}

.dp__selection_preview{
  @apply hidden
}
.dp__action_row{
  @apply justify-end
}
.dp__action_buttons{
  @apply space-x-1
}
.dp__cancel{
  @apply text-sm text-primary bg-secondary px-2 py-1.5
}
.dp__select{
  @apply text-sm text-secondary bg-primary px-2 py-1.5
}

.dp__selection_grid_header{
  @apply px-3 py-2
}
</style>