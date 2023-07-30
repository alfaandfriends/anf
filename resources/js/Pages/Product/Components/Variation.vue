<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import BreezeButton from '@/Components/Button.vue';
import VariationOption from './VariationOption.vue';
import UploadPreview from '@/Components/UploadPreview.vue';

const props = defineProps({
    productVariations: {
        type: Array,
        default: []
    },
    hasSecondVariation: {
        type: Boolean,
        default: false
    },
});

const variation1 = ref(
    {
        name: 'variation 1',
        options: [
            {
                name: '',
                image: '',
                url: '',
                rows: [
                    { name: '', price: '',  stock: '',  sku: '' }
                ]
            }
        ]
    }
);

const variation2 = ref(
    {
        show: false,
        name: 'variation 2',
        options: [
            {
                name: '',
            }
        ]
    }
);

const emit = defineEmits(['update:variation', 'delete:variation']);

const addVariation = () => {
    variation2.value.show = true;
    variation1.value.name2 = variation2.value.name;
    variation1.value.options.forEach(option => {
        option.rows[0].name = variation2.value.options[0];
    });

    emit('update:variation', variation1.value);
};

const removeVariation1 = () => {
    variation1.value = {
        name: 'variation 1',
        options: [
            {
                name: '',
                image: '',
                url: '',
                rows: [
                    { name: '', price: '',  stock: '',  sku: '' }
                ]
            }
        ]
    };
    emit('delete:variation');
};

const removeVariation2 = () => {
    variation2.value = {
        show: false,
        name: 'variation 2',
        options: [
            {
                name: '',
            }
        ]
    };
};

const addVariationOption1 = () => {
    variation1.value.options.push(
        {
            name: '',
            image: '',
            url: '',
            rows: [
                { name: '', price: '',  stock: '',  sku: '' }
            ]
        }
    );
    emit('update:variation', variation1.value);
};

const addVariationOption2 = () => {
    variation2.value.options.push(
        {
            name: '',
        }
    );
    variation1.value.options.forEach(option => {
        option.rows.push({ name: '', price: '',  stock: '',  sku: '' })
        option.rows[variation2.value.options.length - 1].name = variation2.value.options[variation2.value.options.length - 1];
    });
    emit('update:variation', variation1.value);
};

const removeVariationOption = (variationIndex, index) => {
    variation1.value[variationIndex].options.splice(index, 1);
    emit('update:variation', variation1.value);
};

const handleFileChange = (file, index) => {
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            updatePreviewUrl(index, reader.result, file);
        };
        reader.readAsDataURL(file);
    } else {
        updatePreviewUrl(index, null, '');
    }
};

const updatePreviewUrl = (option, value, file) => {
    variation1.value.options.forEach((item, index) => {
        if (index === option) {
            item.url = value;
            item.image = file;
        }
    });
}

watch(variation1.value, (newVal, oldVal) => {
    console.log('variation 1 updated:', newVal);
});

watch(variation2.value, (newVal, oldVal) => {
    console.log('variation 2 updated:', newVal);
});

onMounted(() => {
    console.log(props.productVariations);
    console.log(variation1.value);
    console.log(variation2.value);
    if(props.productVariations.length != 0){
        const productVariations = props.productVariations;
        variation1.value = {
            name: 'Variation 1',
            options: []
        };
        if(props.hasSecondVariation){
            variation2.value = {
                show: true,
                name: 'Variation 2',
                options: []
            };
        }
        productVariations.forEach((item) => {
            console.log(item);
            variation1.value.options.push(
                {
                    name: item.name,
                    image: null,
                    url: (item.url) ? '../../storage/'+item.url : '',
                    rows: item.row
                }
            );
            if(props.hasSecondVariation){
                variation2.value.options.push(
                    {
                        name: item.row[0].name,
                    }
                );
            }
        });
        console.log(variation1.value);
        console.log(variation2.value);
    }
});

</script>

<template>
    <div class="w-full">
        <div class="flex">
            <div class="w-full bg-white shadow-md rounded-md overflow-hidden">
                <div class="border-b border-gray-200 px-4 py-6">
                    <div class="mb-4">
                        <label :for="'variation_'+1" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input
                                type="text"
                                :name="'variation_'+1"
                                :id="'variation_'+1"
                                v-model="variation1.name"
                                @input="emit('update:variation', variation1)"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <VariationOption
                            :options="variation1.options"
                            :variationIndex="1"
                            @add:option="addVariationOption1"
                            @remove:option="removeVariationOption"
                        />
                    </div>
                    <hr class="bg-gray-500 mx-auto my-4" />
                    <div class="flex items-center justify-end py-2">
                        <BreezeButton @click.stop="removeVariation1" buttonType="danger">Delete</BreezeButton>
                    </div>
                </div>
                <div v-if="variation2.show" class="border-b border-gray-200 px-4 py-6">
                    <div class="mb-4">
                        <label :for="'variation_'+2" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input
                                type="text"
                                :name="'variation_'+2"
                                :id="'variation_'+2"
                                v-model="variation2.name"
                                @input="emit('update:variation', variation2)"
                                class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <VariationOption
                            :options="variation2.options"
                            :variationIndex="2"
                            @add:option="addVariationOption2"
                            @remove:option="removeVariationOption"
                        />
                    </div>
                    <hr class="bg-gray-500 mx-auto my-4" />
                    <div class="flex items-center justify-end py-2">
                        <BreezeButton @click.stop="removeVariation2" buttonType="danger">Delete</BreezeButton>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center my-10">
            <div v-if="!variation2.show" @click="addVariation" class="w-full text-center border border-solid border-black hover:bg-gray-100 cursor-pointer px-6 py-4">
                <span class="text-center">Add variation</span>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">{{ variation1.name }}</th>
                    <th v-if="variation2.show" scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">{{ variation2.name }}</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Price</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Stock</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">SKU</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-200" v-for="(variation_1, variation_1_index) in variation1.options" :key="variation_1_index">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col items-center p-2 m-2">
                            <UploadPreview :previewUrl="variation_1.url" @update:value="handleFileChange($event, variation_1_index)" />
                            <label :for="variation_1.name" class="text-sm text-gray-500 text-center"> {{ variation_1.name }} </label>
                        </div>
                    </td>
                    <td v-if="variation2.show" class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col items-center p-2 m-2" v-for="(variation_2, variation_2_index) in variation_1.rows" :key="variation_2_index">
                            <label :for="variation_2.name" class="text-sm text-gray-500 text-center"> {{ (productVariations) ? variation_2.name : variation_2.name.name }} </label>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div v-for="(row, price) in variation_1.rows" :key="price" class="text-sm font-medium text-gray-900 mb-2">
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
                        <div v-for="(row, stock) in variation_1.rows" :key="stock" class="text-sm font-medium text-gray-900 mb-2">
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
                        <div v-for="(row, sku) in variation_1.rows" :key="sku" class="text-sm font-medium text-gray-900 mb-2">
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
