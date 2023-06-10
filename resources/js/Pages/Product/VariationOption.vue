<script setup>
import { ref } from 'vue';
import BreezeButton from '@/Components/Button.vue';
import Variation from './Variation.vue';

const props = defineProps({
    options: {
        type: Array,
        required: true
    },
    variationIndex: {
        type: Number,
        required: true
    }
});

const variationOptions = ref(props.options);

const emit = defineEmits(['add:option', 'remove:option', 'add:variation', 'update:variation']);
</script>

<template>
    <div>
        <div class="flex items-center justify-between py-2">
            <label class="block text-sm text-gray-700 font-bold"> Options <span class="text-red-500">*</span></label>
            <BreezeButton @click="emit('add:option', variationIndex)" buttonType="success" class="text-sm py-1 px-2">Add option</BreezeButton>
        </div>
        <div v-if="variationOptions.some(item => item.hasOwnProperty('options') && Array.isArray(item.options))">
            <Variation />
        </div>
        <div v-else v-for="(option, index) in variationOptions" :key="index" class="mt-1 flex rounded-md shadow-sm">
            <input @input="emit('update:variation', variationOptions)" type="text" placeholder="option" :name="'variation_option_'+index" :id="'variation_option_'+index" class="focus:ring-0 focus:border-indigo-300 flex-1 block rounded-tl-md rounded-bl-md sm:text-sm" v-model="option.name" autocomplete="off"/>
            <input @input="emit('update:variation', variationOptions)" type="text" placeholder="price" :name="'variation_option_price'+index" :id="'variation_option_price'+index" class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm" v-model="option.price" autocomplete="off"/>
            <input @input="emit('update:variation', variationOptions)" type="number" placeholder="stock" :name="'variation_option_stock'+index" :id="'variation_option_stock'+index" class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm" v-model="option.stock" autocomplete="off"/>
            <input @input="emit('update:variation', variationOptions)" type="text" placeholder="sku" :name="'variation_option_sku'+index" :id="'variation_option_sku'+index" class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm" v-model="option.sku" autocomplete="off"/>
            <!-- <BreezeButton @click="emit('add:variation', variationIndex, index)" buttonType="blue" class="px-4 rounded-none">+</BreezeButton> -->
            <BreezeButton @click="emit('remove:option', variationIndex, index)" buttonType="danger" class="px-4 rounded-none">X</BreezeButton>
        </div>
    </div>
</template>
