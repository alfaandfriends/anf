<script setup>
import { ref } from 'vue';
import BreezeButton from '@/Components/Button.vue';
import VariationOption from '@/Components/VariationOption.vue';

const variations = ref([
    {
        name: '',
        options: [
            { name: '',  price: '',  stock: '',  sku: '' }
        ]
    }
]);

const emit = defineEmits(['update:variation']);

const addVariation = () => {
    variations.value.push(
        {
            name: '',
            options: [
                { name: '',  price: '',  stock: '',  sku: '' }
            ]
        }
    );
    emit('update:variation', variations.value);
};

const removeVariation = (index) => {
    variations.value.splice(index, 1);
    emit('update:variation', variations.value);
};

const addVariationOption = (index) => {
    variations.value[index].options.push({ name: '',  price: '',  stock: '',  sku: ''  });
    emit('update:variation', variations.value);
};

const removeVariationOption = (variationIndex, index) => {
    variations.value[variationIndex].options.splice(index, 1);
    emit('update:variation', variations.value);
};

const addVariationOptionVariation = (variationIndex, index) => {
    variations.value[variationIndex].options.splice(index, 1, {
        name: '',
        options: [
            { name: '',  price: '',  stock: '',  sku: '' }
        ]
    });
    emit('update:variation', variations.value);
};
</script>

<template>
    <div>
        <div class="flex">
            <div class="w-full bg-white shadow-md rounded-md overflow-hidden">
                <div v-for="(variation, index) in variations" :key="index" class="border-b border-gray-200 px-4 py-6">
                    <div class="mb-4">
                        <label :for="'variation_'+index" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input @input="emit('update:variation', variations)" type="text" :name="'variation_'+index" :id="'variation_'+index" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="variation.name" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="mb-4">
                        <VariationOption :options="variation.options" :variationIndex="index" @add:option="addVariationOption" @remove:option="removeVariationOption" @add:variation="addVariationOptionVariation" @update:variation="emit('update:variation', variations)" />
                    </div>
                    <hr class="bg-gray-500 mx-auto my-4" />
                    <div class="flex items-center justify-end py-2">
                        <BreezeButton @click="removeVariation(index)" buttonType="danger">Delete</BreezeButton>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center my-10">
            <div @click="addVariation" class="w-full text-center border border-solid border-black hover:bg-gray-100 cursor-pointer px-6 py-4">
                <span class="text-center">Add variation</span>
            </div>
        </div>
    </div>
</template>
