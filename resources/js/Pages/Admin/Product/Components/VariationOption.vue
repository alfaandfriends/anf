<script setup>
import { ref, computed } from 'vue';
import BreezeButton from '@/Components/Button.vue';

const props = defineProps({
    options: {
        type: Array,
    },
    variationIndex: {
        type: Number,
    }
});

const variationOptions = computed(() => [...props.options]);

const emit = defineEmits(['add:option', 'remove:option', 'update:variation']);

</script>

<template>
    <div>
        <div class="flex items-center justify-between py-2">
            <label class="block text-sm text-gray-700 font-bold"> Options <span class="text-red-500">*</span></label>
            <BreezeButton @click.stop="emit('add:option', variationIndex)" buttonType="success" class="text-sm py-1 px-2">Add option</BreezeButton>
        </div>
        <div v-for="(option, index) in variationOptions" :key="index" class="mt-1 flex rounded-md shadow-sm">
            <input
                @input="emit('update:variation', {variationOptions,index})"
                type="text"
                placeholder="option"
                :name="'variation_option_'+index"
                :id="'variation_option_'+index"
                class="focus:ring-0 focus:border-indigo-300 flex-1 block rounded-tl-md rounded-bl-md sm:text-sm"
                v-model="option.name" autocomplete="off"
            />
            <BreezeButton @click="emit('remove:option', variationIndex, index)" buttonType="danger" class="h-full px-4 rounded-none">X</BreezeButton>
        </div>
    </div>
</template>
