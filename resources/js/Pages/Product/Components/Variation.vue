<script setup>
import { ref } from 'vue';
import BreezeButton from '@/Components/Button.vue';
import VariationOption from './VariationOption.vue';
import UploadPreview from '@/Components/UploadPreview.vue';

const variations = ref([
    {
        name: 'variation 1',
        options: [
            {
                name: '',
                image: '',
                url: '',
                row: [
                    { name: '', price: '',  stock: '',  sku: '' }
                ]
            }
        ]
    }
]);

const emit = defineEmits(['update:variation', 'delete:variation']);

const addVariation = () => {
    variations.value.push(
        {
            name: 'variation 2',
            options: [
                { name: '' }
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
    if(variations.value.length == 1){
        variations.value[0].options.push({
            name: '',
            image: '',
            url: '',
            row: [
                { name: '', price: '',  stock: '',  sku: '' }
            ]
        });
    }else{
        variations.value[0].options.forEach(option => {
            option.row.push({ name: '', price: '',  stock: '',  sku: '' })
        });
        variations.value[index].options.push({ name: '' });
    }
    emit('update:variation', variations.value);
};

const updateVariationOption = (value) => {
    if(variations.value.length != 1){
        variations.value[0].options.forEach(option => {
            option.row[value.index].name = value.variationOptions[value.index].name;
        });
    }
    emit('update:variation', variations.value)
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
            updatePreviewUrl(name, reader.result, index, file);
        };
        reader.readAsDataURL(file);
    } else {
        updatePreviewUrl(name, null, index, '');
    }
};

const updatePreviewUrl = (name, value, index, file) => {
    variations.value[index].options.forEach(item => {
        if (item.name === name) {
            item.url = value;
            item.image = file;
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
                        <VariationOption :options="variation.options" :variationIndex="index" @add:option="addVariationOption" @remove:option="removeVariationOption" @add:variation="addVariationOptionVariation" @update:variation="updateVariationOption($event)" />
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
                            <UploadPreview :previewUrl="variation_1.url" @update:value="handleFileChange($event, variation_1.name, variation_1_index)" />
                            <label :for="variation_1.name" class="text-sm text-gray-500 text-center"> {{ variation_1.name }} </label>
                        </div>
                    </td>
                    <td v-if="variations[1]" class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col items-center p-2 m-2" v-for="(variation_2, variation_2_index) in variations[1].options" :key="variation_2_index">
                            <label :for="variation_2.name" class="text-sm text-gray-500 text-center"> {{ variation_2.name }} </label>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div v-for="(row, price) in variation_1.row" :key="price" class="text-sm font-medium text-gray-900 mb-2">
                            <input
                                type="text" placeholder="input"
                                :name="'variation_option_price'+price"
                                :id="'variation_option_price'+price"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm"
                                v-model="row.price"
                                autocomplete="off"
                            />
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div v-for="(row, stock) in variation_1.row" :key="stock" class="text-sm font-medium text-gray-900 mb-2">
                            <input
                                type="text" placeholder="0"
                                :name="'variation_option_stock'+stock"
                                :id="'variation_option_stock'+stock"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm"
                                v-model="row.stock"
                                autocomplete="off"
                            />
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div v-for="(row, sku) in variation_1.row" :key="sku" class="text-sm font-medium text-gray-900 mb-2">
                            <input
                                type="text" placeholder="input"
                                :name="'variation_option_sku'+sku"
                                :id="'variation_option_sku'+sku"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block sm:text-sm"
                                v-model="row.sku"
                                autocomplete="off"
                            />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
