<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import UploadPreview from '@/Components/UploadPreview.vue';
import Modal from '@/Components/Modal.vue';
import Variation from './Components/Variation.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref, onMounted, watch } from 'vue';

const currentStep = ref(1);

const setStep = (step) => {
    currentStep.value = step;
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
                                        <h1 class="font-bold text-indigo-800">Add New Product</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div>
                                        <ol class="grid grid-cols-1 divide-x divide-gray-300 overflow-hidden rounded-lg border border-gray-300 text-sm text-gray-500 sm:grid-cols-2" :class="{'text-white': currentStep === 1}">
                                            <li class="flex items-center justify-center gap-2 p-4 cursor-pointer" @click="setStep(1)" :class="{'bg-indigo-500': currentStep === 1}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-600" :class="{'text-white': currentStep === 1}" fill="currentColor" viewBox="0 0 448 512">
                                                    <path d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                                                </svg>
                                                <p class="leading-none">
                                                    <strong class="block font-medium text-gray-600" :class="{'text-white': currentStep === 1}"> Basic Information </strong>
                                                    <small class="mt-1 text-gray-500" :class="{'text-white': currentStep === 1}"> Some basic info about this product. </small>
                                                </p>
                                            </li>
                                            <li class="flex items-center justify-center gap-2 p-4 cursor-pointer" @click="setStep(2)" :class="{'bg-indigo-500': currentStep === 2}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-600" :class="{'text-white': currentStep === 2}" fill="currentColor" viewBox="0 0 576 512">
                                                    <path d="M64 80c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H512c8.8 0 16-7.2 16-16V96c0-8.8-7.2-16-16-16H64zM0 96C0 60.7 28.7 32 64 32H512c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm96 64a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm104 0c0-13.3 10.7-24 24-24H448c13.3 0 24 10.7 24 24s-10.7 24-24 24H224c-13.3 0-24-10.7-24-24zm0 96c0-13.3 10.7-24 24-24H448c13.3 0 24 10.7 24 24s-10.7 24-24 24H224c-13.3 0-24-10.7-24-24zm0 96c0-13.3 10.7-24 24-24H448c13.3 0 24 10.7 24 24s-10.7 24-24 24H224c-13.3 0-24-10.7-24-24zm-72-64a32 32 0 1 1 0-64 32 32 0 1 1 0 64zM96 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/>
                                                </svg>
                                                <p class="leading-none">
                                                    <strong class="block font-medium text-gray-600" :class="{'text-white': currentStep === 2}"> Detailed Information </strong>
                                                    <small class="mt-1 text-gray-500" :class="{'text-white': currentStep === 2}"> Detailed info like variations, prices and more...   </small>
                                                </p>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="p-10">
                                        <div :class="{'hidden': currentStep === 2}">
                                            <div class="mb-4">
                                                <label for="category_name" class="block text-sm text-gray-700 font-bold mb-2"> Product Images <span class="text-red-500">*</span></label>
                                                <div class="flex flex-wrap justify-center">
                                                    <div v-for="image, index in form.basic_info.product_images" class="flex flex-col items-center p-2 m-2">
                                                        <label :for="image.label" class="mb-3 text-sm text-gray-500 text-center"> {{ image.label }} <span class="text-red-600" v-if="image.required">*</span></label>
                                                        <UploadPreview :previewUrl="image.value" @update:value="handleFileChange($event, index)" />
                                                        <span class="mt-3 text-sm text-red-500 hover:underline cursor-pointer font-semibold" v-if="image.value" @click="deleteImage(index)">Delete</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="product_name" class="block text-sm text-gray-700 font-bold mb-2"> Product Name <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text" name="product_name" id="product_name" class="focus:ring-0 focus:border-gray-400 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors['basic_info.product_name'] ? 'border-red-300' : 'border-gray-300'" v-model="form.basic_info.product_name" autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="product_description" class="block text-sm text-gray-700 font-bold mb-2"> Product Description <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <textarea name="product_description" id="product_description" class="focus:ring-0 focus:border-gray-400 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors['basic_info.product_description'] ? 'border-red-300' : 'border-gray-300'" v-model="form.basic_info.product_description" cols="30" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div :class="{'hidden': currentStep === 1}">
                                            <div class="mb-10">
                                                <div class="mb-3">
                                                    <label class="block text-sm text-gray-700 font-bold"> Variation Setting </label>
                                                </div>
                                                <div class="flex space-x-4">
                                                    <div class="mt-1 flex rounded-md">
                                                        <BreezeButton v-if="!form.detailed_info.has_variation" @click="form.detailed_info.has_variation = true" buttonType="info">Enable Variation</BreezeButton>
                                                        <BreezeButton v-if="form.detailed_info.has_variation" @click="form.detailed_info.has_variation = false, form.detailed_info.has_sub_variation = false" buttonType="gray">Disable Variation</BreezeButton>
                                                    </div>
                                                    <div class="mt-1 flex rounded-md">
                                                        <BreezeButton v-if="form.detailed_info.has_variation && !form.detailed_info.has_sub_variation" @click="form.detailed_info.has_sub_variation = true" buttonType="info">Enable Sub Variation</BreezeButton>
                                                        <BreezeButton v-if="form.detailed_info.has_variation && form.detailed_info.has_sub_variation" @click="form.detailed_info.has_sub_variation = false" buttonType="gray">Disable Sub Variation</BreezeButton>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="" v-if="!form.detailed_info.has_variation">
                                                <div class="mb-4">
                                                    <label for="product_price" class="block text-sm text-gray-700 font-bold"> Price <span class="text-red-500">*</span></label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <input type="number" name="product_price" id="product_price" class="focus:ring-0 focus:border-gray-400 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors['basic_info.product_price'] ? 'border-red-300' : 'border-gray-300'" v-model="form.basic_info.product_price" autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="product_stock" class="block text-sm text-gray-700 font-bold"> Stock <span class="text-red-500">*</span></label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <input type="number" name="product_stock" id="product_stock" class="focus:ring-0 focus:border-gray-400 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors['basic_info.product_stock'] ? 'border-red-300' : 'border-gray-300'" v-model="form.basic_info.product_stock" autocomplete="off"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div :class="{'hidden': !form.detailed_info.has_variation}">
                                                <Variation :detailed_info="form.detailed_info" :sub_variation_prop="sub_variation_prop"/>
                                            </div>
                                        </div>
                                        <hr class="mt-10">
                                    </div>
                                    <div class="flex items-center justify-between space-x-2 px-10">
                                        <BreezeButton v-if="currentStep === 1" :route="route('products')" buttonType="gray">Cancel</BreezeButton>
                                        <BreezeButton v-if="currentStep === 1" @click="setStep(2)">Next</BreezeButton>
                                        <BreezeButton v-if="currentStep === 2" @click="setStep(1)" buttonType="gray">Back</BreezeButton>
                                        <BreezeButton v-if="currentStep === 2" type="submit">Save</BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import Compressor from 'compressorjs';

function blobToFile(blob, filename) {
  const file = new File([blob], filename, { type: blob.type });
  return file;
}

export default {
    mounted(){
        /* Set variations data */
        if(this.$page.props.product_variations.length){
            this.$page.props.product_variations.forEach(variation => {
                this.form.detailed_info.variations.options.push({
                    id: variation.id,
                    name: variation.option_name,
                    images: {
                        file: null, 
                        value: '/storage'+variation.image
                    },
                    price: variation.price,
                    stock: variation.stock,
                    sub_variations: {
                        options: []
                    }
                })
            });
        }
        else{
            this.form.detailed_info.variations.options.push({
                id: '',
                name: '',
                images: {
                    file: null, 
                    value: null
                },
                price: 0,
                stock: 0,
                sub_variations: {
                    options: [{
                        id: '',
                        name: '',
                        price: 0,
                        stock: 0,
                    }]
                }
            })
        }

        /* Set sub variations list */
        if(this.$page.props.product_sub_variations.length){
            const variationIdsAdded = new Set();
            for (const obj of this.$page.props.product_sub_variations) {
                if (!variationIdsAdded.has(obj.option_name)) {
                    this.sub_variation_prop.options.push({
                        name: obj.option_name
                    });
                    variationIdsAdded.add(obj.option_name);
                }
            }
            this.form.detailed_info.variations.options.forEach(variation=>{
                this.$page.props.product_sub_variations.forEach(sub_variation_item=>{
                    if(variation.id == sub_variation_item.product_variation_id){
                        variation.sub_variations.options.push({
                            id: sub_variation_item.id,
                            name: sub_variation_item.option_name,
                            price: sub_variation_item.price,
                            stock: sub_variation_item.stock,
                        })
                    }
                })
            })
        }
        else{
            this.sub_variation_prop.options.push({
                name: ''
            });
        }

    },
    data(){
        return{
            sub_variation_prop: {
                options: [],
            },
            form: {
                basic_info: {
                    product_id: this.$page.props.product.id,
                    product_name: this.$page.props.product.name ?? '',
                    product_description: this.$page.props.product.description ?? '', 
                    product_price: this.$page.props.product.price ?? '',
                    product_stock: this.$page.props.product.stock ?? '',
                    product_images: {
                        cover: {label: 'Cover Image', required: true, file: null, value: this.$page.props.product.cover_image ? '/storage'+this.$page.props.product.cover_image : ''},
                        image_1: {label: 'Image 1', required: false, file: null, value: this.$page.props.product.image_1 ? '/storage'+this.$page.props.product.image_1 : ''},
                        image_2: {label: 'Image 2', required: false, file: null, value: this.$page.props.product.image_2 ? '/storage'+this.$page.props.product.image_2 : ''},
                        image_3: {label: 'Image 3', required: false, file: null, value: this.$page.props.product.image_3 ? '/storage'+this.$page.props.product.image_3 : ''},
                        image_4: {label: 'Image 4', required: false, file: null, value: this.$page.props.product.image_4 ? '/storage'+this.$page.props.product.image_4 : ''},
                        image_5: {label: 'Image 5', required: false, file: null, value: this.$page.props.product.image_5 ? '/storage'+this.$page.props.product.image_5 : ''},
                        image_6: {label: 'Image 6', required: false, file: null, value: this.$page.props.product.image_6 ? '/storage'+this.$page.props.product.image_6 : ''}
                    }
                },
                detailed_info:{
                    has_variation: this.$page.props.product.has_variation,
                    has_sub_variation: this.$page.props.product.has_sub_variation,
                    main_variation_name: this.$page.props.product.variation_name ?? '',
                    sub_variation_name: this.$page.props.product.sub_variation_name ?? '',
                    variations: {
                        options: []
                    },
                }
            }
        }
    },
    methods: {
        submit(){
            this.$inertia.post(route('products.update'), this.form)
        },
        handleFileChange(file, index){
            if (file) {
                const product_images    =   this.form.basic_info.product_images
                this.compress(file, index, product_images)
            }
        },
        compress(file, index, product_images){
            new Compressor(file, {
                quality: 0.2,
                maxWidth: 400,
                maxHeight: 400,
                success(result) {
                    const blobUrl = URL.createObjectURL(result);
                    const new_file   =   blobToFile(result, Date.now()+'.jpg')
                    product_images[index].file = new_file
                    product_images[index].value = blobUrl
                },
            });
        },
        deleteImage(index){
            this.form.basic_info.product_images[index].file = null
            this.form.basic_info.product_images[index].value = null
        }, 
        blobToFile(blob, filename) {
            const file = new File([blob], filename, { type: blob.type });
            return file;
        }
    }
}
</script>
