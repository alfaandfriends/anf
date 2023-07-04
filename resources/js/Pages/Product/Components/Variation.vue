<script setup>
import { ref } from 'vue';
import BreezeButton from '@/Components/Button.vue';
import VariationOption from './VariationOption.vue';
import UploadPreview from '@/Components/UploadPreview.vue';

const variations = ref([
    {
        name: 'variation 1',
        options: [
            { name: '',  price: '',  stock: '',  sku: '' }
        ]
    }
]);

const variation1 = ref([
    {label: '', name: 'variation_1_image', value: null},
]);

const variation2 = ref([
    {label: '', name: 'variation_2_image', value: null},
]);

const emit = defineEmits(['update:variation', 'delete:variation']);

const addVariation = () => {
    variations.value.push(
        {
            name: 'variation 2',
            options: [
                { name: '',  price: '',  stock: '',  sku: '', image: '' }
            ]
        }
    );
    emit('update:variation', variations.value);
};

const removeVariation = (index) => {
    variations.value.splice(index, 1);
    emit('update:variation', variations.value);
    if(variations.value.length == 0){
        emit('delete:variation');
    }
};

const addVariationOption = (index) => {
    variations.value[index].options.push({ name: '',  price: '',  stock: '',  sku: '', image: '' });
    emit('update:variation', variations.value);
};

const updateVariationOption = (value) => {
    console.log(value);
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

const handleFileChange = (file, name, index) => {
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            updatePreviewUrl(name, reader.result, index);
        };
        reader.readAsDataURL(file);
        // productForm[name] = file;
    } else {
        updatePreviewUrl(name, null, index);
    }
    console.log(variations.value[index]);
};

const updatePreviewUrl = (name, value, index) => {
    variations.value[index].options.forEach(item => {
        if (item.name === name) {
            item.image = value;
        }
    });
}
</script>

<template>
    <div class="w-full">
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
                        <BreezeButton @click.stop="removeVariation(index)" buttonType="danger">Delete</BreezeButton>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center my-10">
            <div v-if="variations.length < 2" @click="addVariation" class="w-full text-center border border-solid border-black hover:bg-gray-100 cursor-pointer px-6 py-4">
                <span class="text-center">Add variation</span>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">{{ variations[0].name }}</th>
                    <th v-if="variations[1]" scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">{{ variations[1].name }}</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Price</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Stock</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">SKU</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-200" v-for="(variation_1, variation_1_index) in variations[0].options" :key="variation_1_index">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col items-center p-2 m-2">
                            <UploadPreview :previewUrl="variation_1.image" @update:value="handleFileChange($event, variation_1.name, variation_1_index)" />
                            <label :for="variation_1.name" class="text-sm text-gray-500 text-center"> {{ variation_1.name }} </label>
                        </div>
                    </td>
                    <td v-if="variations[1]" class="px-6 py-4 whitespace-nowrap">
                        <div v-for="(variation_2, variation_2_index) in variations[1].options" :key="variation_2_index" class="flex flex-col items-center p-2 m-2">
                            <UploadPreview :previewUrl="variation_2.image" @update:value="handleFileChange($event, variation_2.name, variation_1_index)" />
                            <label :for="variation_2.name" class="text-sm text-gray-500 text-center"> {{ variation_2.name }} </label>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div v-if="variations[1]" v-for="(variation_2, variation_2_index) in variations[1].options" :key="variation_2_index" class="text-sm font-medium text-gray-900">
                            <input
                                @input="emit('update:variation', variation_2)"
                                type="text" placeholder="input"
                                :name="'variation_option_price'+variation_2_index"
                                :id="'variation_option_price'+variation_2_index"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm mb-6"
                                v-model="variation_2.price"
                                autocomplete="off"
                            />
                        </div>
                        <div v-else class="text-sm font-medium text-gray-900">
                            <input
                                @input="emit('update:variation', variation_1)"
                                type="text" placeholder="input"
                                :name="'variation_option_price'+variation_1_index"
                                :id="'variation_option_price'+variation_1_index"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm"
                                v-model="variation_1.price"
                                autocomplete="off"
                            />
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div v-if="variations[1]" v-for="(variation_2, variation_2_index) in variations[1].options" :key="variation_2_index" class="text-sm font-medium text-gray-900">
                            <input
                                @input="emit('update:variation', variation_2)"
                                type="text" placeholder="0"
                                :name="'variation_option_stock'+variation_2_index"
                                :id="'variation_option_stock'+variation_2_index"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm mb-6"
                                v-model="variation_2.stock"
                                autocomplete="off"
                            />
                        </div>
                        <div v-else class="text-sm font-medium text-gray-900">
                            <input
                                @input="emit('update:variation', variation_1)"
                                type="text" placeholder="0"
                                :name="'variation_option_stock'+variation_1_index"
                                :id="'variation_option_stock'+variation_1_index"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm"
                                v-model="variation_1.stock"
                                autocomplete="off"
                            />
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div v-if="variations[1]" v-for="(variation_2, variation_2_index) in variations[1].options" :key="variation_2_index" class="text-sm font-medium text-gray-900">
                            <input
                                @input="emit('update:variation', variation_2)"
                                type="text" placeholder="input"
                                :name="'variation_option_sku'+variation_2_index"
                                :id="'variation_option_sku'+variation_2_index"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm mb-6"
                                v-model="variation_2.sku"
                                autocomplete="off"
                            />
                        </div>
                        <div v-else class="text-sm font-medium text-gray-900">
                            <input
                                @input="emit('update:variation', variation_1)"
                                type="text" placeholder="input"
                                :name="'variation_option_sku'+variation_1_index"
                                :id="'variation_option_sku'+variation_1_index"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm"
                                v-model="variation_1.sku"
                                autocomplete="off"
                            />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
