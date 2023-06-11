<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import ToggleRadio from '@/Components/ToggleRadio.vue';
import UploadPreview from '@/Components/UploadPreview.vue';
import Modal from '@/Components/Modal.vue';
import Variation from './Components/Variation.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    product: {
        type: Object,
    },
    productImages: {
        type: Object,
    },
    categories: {
        type: Object,
    },
});

const currentStep = ref(1);
const productType = ref('diy');
const addCategory = ref(false);
const previewUrl = ref([
    {label: 'Cover Image', name: 'product_cover_image', value: null},
    {label: 'Image 1', name: 'product_image_1', value: null},
    {label: 'Image 2', name: 'product_image_2', value: null},
    {label: 'Image 3', name: 'product_image_3', value: null},
    {label: 'Image 4', name: 'product_image_4', value: null},
    {label: 'Image 5', name: 'product_image_5', value: null},
    {label: 'Image 6', name: 'product_image_6', value: null},
]);

// onMounted(() => {
//     if(props.productImages) {
//         previewUrl.value.forEach((url) => {
//             Object(props.productImages).forEach((item) => {
//                 if(url.name == 'product_'+item.name){
//                     url.value = '../../storage/'+item.path;
//                 }
//             });
//         });
//     }
// });

const variationOptions = [
    { label: 'Enable Variation', value: 'enabled' },
    { label: 'Disable Variation', value: 'disabled' },
];

const productTypeOptions = [
    { label: 'Create Your Own Product', value: 'diy' },
    { label: 'Alfa and Friends Products', value: 'default' },
];

const productForm = useForm({
    product_name: (props.product) ? props.product.name : '',
    product_description: (props.product) ? props.product.description : '',
    product_category: (props.product) ? props.product.product_category_id : '',
    product_price: (props.product) ? props.product.price : '',
    product_stock: (props.product) ? props.product.stock : '',
    product_cover_image: '',
    product_image_1: '',
    product_image_2: '',
    product_image_3: '',
    product_image_4: '',
    product_image_5: '',
    product_image_6: '',
    product_variation: (props.product) ? props.product.name : 'disabled',
    product_variation_items: (props.product) ? props.product.name : [],
});

const productCategoryForm = useForm({
    category_name: '',
});

const formUrl = (props.product) ? route('products.update', props.product.id): route('products.store');
const formMethod = (props.product) ? 'put' : 'post';

const nextStep = () => {
  currentStep.value++;
};

const previousStep = () => {
  currentStep.value--;
};

const setStep = (step) => {
  currentStep.value = step;
};

const handleFileChange = (file, name) => {
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            updatePreviewUrl(name, reader.result);
        };
        reader.readAsDataURL(file);
        productForm[name] = file;
    } else {
        updatePreviewUrl(name, null);
    }
};

const updatePreviewUrl = (name, value) => {
    previewUrl.value.forEach(item => {
        if (item.name === name) {
            item.value = value;
        }
    });
}

const submit = () => {
    productForm[formMethod](formUrl, {
        onSuccess: () => productForm.reset(),
    });
};

const submitProductCategoryForm = () => {
    productCategoryForm.post(route('product-categories.store'), {
        onSuccess: () => {
            form.reset();
            addCategory.value = false;
        },
    });
};
</script>

<template>
    <Head title="Product" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">New Product</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="p-10">
                                        <BreezeValidationErrors class="mb-4" />
                                        <div class="md:flex items-center justify-center border-b pb-6 border-gray-200 mb-4">
                                            <div class="flex items-center md:mt-0 mt-4" @click="setStep(1)" :class="{'cursor-pointer': currentStep != 1}">
                                                <div class="w-full h-full p-4 rounded flex items-center justify-center" :class="{'bg-indigo-700': currentStep === 1}">
                                                    <p class="text-base font-medium leading-4 text-gray-800" :class="{'text-white': currentStep === 1}">
                                                        Product Type
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center md:mt-0 mt-4 md:ml-12" @click="setStep(2)" :class="{'cursor-pointer': currentStep != 2}">
                                                <div class="w-full h-full p-4 rounded flex items-center justify-center" :class="{'bg-indigo-700': currentStep === 2}">
                                                    <p class="text-base ml-3 font-medium leading-4 text-gray-800" :class="{'text-white': currentStep === 2}">
                                                        Basic Information
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center md:mt-0 mt-4 md:ml-12" @click="setStep(3)" :class="{'cursor-pointer': currentStep != 3}">
                                                <div class="w-full h-full p-4 rounded flex items-center justify-center" :class="{'bg-indigo-700': currentStep === 3}">
                                                    <p class="text-base ml-3 font-medium leading-4 text-gray-800" :class="{'text-white': currentStep === 3}">
                                                        Sales Information
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-10">
                                            <div v-if="currentStep === 1">
                                                <h1
                                                    tabindex="0"
                                                    role="heading"
                                                    aria-label="profile information"
                                                    class="focus:outline-none text-3xl font-bold text-gray-800 mb-9"
                                                >
                                                    Choose Product Type
                                                </h1>
                                                <div class="my-4">
                                                    <ToggleRadio :options="productTypeOptions" :value="productType" @update:value="productType = $event;" />
                                                </div>
                                            </div>
                                            <div v-if="currentStep === 2">
                                                <div class="mb-4">
                                                    <label for="category_name" class="block text-sm text-gray-700 font-bold mb-2"> Product Images <span class="text-red-500">*</span></label>
                                                    <div class="flex flex-wrap justify-center">
                                                        <div v-for="item in previewUrl" :key="item.name" class="flex flex-col items-center p-2 m-2">
                                                            <UploadPreview :previewUrl="item.value" @update:value="handleFileChange($event, item.name)" />
                                                            <label :for="item.label" class="text-sm text-gray-500 text-center"> {{ item.label }} </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="product_name" class="block text-sm text-gray-700 font-bold mb-2"> Product Name <span class="text-red-500">*</span></label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <input type="text" name="product_name" id="product_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="productForm.product_name" autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="product_description" class="block text-sm text-gray-700 font-bold mb-2"> Product Description <span class="text-red-500">*</span></label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <textarea name="product_description" id="product_description" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="productForm.product_description" cols="30" rows="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Product Category <span class="text-red-500">*</span></label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <select name="product_category" id="product_category" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="productForm.product_category">
                                                            <option value="">Please Select</option>
                                                            <option v-for="(category, index) in categories" :key="index" :value="category.id"> {{ category.name }} </option>
                                                        </select>
                                                        <BreezeButton @click="addCategory = true" buttonType="warning">Add New Category</BreezeButton>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="currentStep === 3">
                                                <div class="mb-6">
                                                    <ToggleRadio :options="variationOptions" :value="productForm.product_variation" @update:value="productForm.product_variation = $event;" />
                                                </div>
                                                <div v-if="productForm.product_variation === 'disabled'">
                                                    <div class="mb-4">
                                                        <label for="product_price" class="block text-sm text-gray-700 font-bold"> Price <span class="text-red-500">*</span></label>
                                                        <div class="mt-1 flex rounded-md shadow-sm">
                                                            <input type="text" name="product_price" id="product_price" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="productForm.product_price" autocomplete="off"/>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="product_stock" class="block text-sm text-gray-700 font-bold"> Stock <span class="text-red-500">*</span></label>
                                                        <div class="mt-1 flex rounded-md shadow-sm">
                                                            <input type="number" step="1" name="product_stock" id="product_stock" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="productForm.product_stock" autocomplete="off"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="productForm.product_variation === 'enabled'">
                                                    <Variation @update:variation="productForm.product_variation_items = $event" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between space-x-2">
                                        <BreezeButton v-if="currentStep != 1" @click="previousStep" buttonType="gray">Back</BreezeButton>
                                        <BreezeButton v-if="currentStep === 1" :route="route('products')" buttonType="gray">Back</BreezeButton>
                                        <BreezeButton v-if="currentStep != 3" @click="nextStep">
                                            Next Step
                                            <svg
                                                class="ml-3"
                                                width="12"
                                                height="8"
                                                viewBox="0 0 12 8"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path d="M8.01 3H0V5H8.01V8L12 4L8.01 0V3Z" fill="currentColor" />
                                            </svg>
                                        </BreezeButton>
                                        <BreezeButton v-if="currentStep === 3" type="submit">{{ (product) ? 'Update' : 'Create' }}</BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <Modal :showModal="addCategory" modalType="sm" @hideModal="addCategory = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">
                    Add New Product Category
                </h3>
            </template>
            <template v-slot:content>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                    <BreezeValidationErrors class="mb-4" />
                    <div class="mb-4">
                        <label for="category_name" class="block text-sm text-gray-700 font-bold"> Product Category Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="category_name" id="category_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="productCategoryForm.category_name" autocomplete="off"/>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="addCategory = false">Cancel</BreezeButton>
                    <BreezeButton @click="submitProductCategoryForm">Create</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>
