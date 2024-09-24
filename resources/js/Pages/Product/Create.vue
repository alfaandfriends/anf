<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import UploadPreview from '@/Components/UploadPreview.vue';
import Variation from './Components/Variation.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref, onMounted, watch } from 'vue';

const currentStep = ref(1);

const setStep = (step) => {
    currentStep.value = step;
};
</script>

<template>
    <Head title="Products" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Tabs default-value="basic">
            <TabsList>
                <TabsTrigger value="basic">
                    Basic Information
                </TabsTrigger>
                <TabsTrigger value="detailed">
                    Detailed Information
                </TabsTrigger>
            </TabsList>
            <TabsContent value="basic" class="p-0.5">
                <Card>
                    <template #content>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="">
                                <Label>Product Images<span class="text-red-500">*</span></Label>
                                <div class="w-full mt-2">
                                    <div class="flex xl:justify-center overflow-x-auto whitespace-nowrap space-x-4">
                                        <div v-for="image, index in form.basic_info.product_images" class="flex flex-col items-center py-2">
                                            <Label class="text-center mb-1 text-xs" :for="image.label">{{ image.label }}<span class="text-red-600" v-if="image.required">*</span></Label>
                                            <UploadPreview :previewUrl="image.value" @update:value="handleFileChange($event, index)" />
                                            <Label class="mt-1 text-xs text-red-500 hover:underline cursor-pointer" v-if="image.value" @click="deleteImage(index)">Delete</Label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <Label>Product Name<span class="text-red-500">*</span></Label>
                                <Input type="text" :error="$page.props.errors['basic_info.product_name']" v-model="form.basic_info.product_name"></Input>
                            </div>
                            <div class="">
                                <Label>Product Description<span class="text-red-500">*</span></Label>
                                <Textarea :error="$page.props.errors['basic_info.product_description']" v-model="form.basic_info.product_description" rows="3"></Textarea>
                            </div>
                        </div>
                    </template>
                </Card>
              </TabsContent>
              <TabsContent value="detailed">
                <div class="flex flex-col gap-4">
                    <Card>
                        <template #content>
                            <div class="grid grid-cols-1 gap-4">
                                <div class="flex space-x-6 my-3">
                                    <div class="flex space-x-2 items-center">
                                        <Label>Variation</Label>
                                        <Switch v-model="form.detailed_info.has_variation" @click="form.detailed_info.has_variation ? form.detailed_info.has_sub_variation = false : ''"></Switch>
                                    </div>
                                    <div class="flex space-x-2 items-center" v-if="form.detailed_info.has_variation">
                                        <Label>Sub Variation</Label>
                                        <Switch v-model="form.detailed_info.has_sub_variation"></Switch>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </Card>
                    <Card v-if="!form.detailed_info.has_variation">
                        <template #content>
                            <div>
                                <Label>Product Price<span class="text-red-500">*</span></Label>
                                <Input type="text" :error="$page.props.errors['basic_info.product_price']" v-model="form.basic_info.product_price"></Input>
                            </div>
                            <div>
                                <Label>Product Stock<span class="text-red-500">*</span></Label>
                                <Input type="text" :error="$page.props.errors['basic_info.product_stock']" v-model="form.basic_info.product_stock"></Input>
                            </div>
                        </template>
                    </Card>
                    <div :class="{'hidden': !form.detailed_info.has_variation}">
                        <Variation :detailed_info="form.detailed_info"/>
                    </div>
                    <Card class="p-0.5">
                        <template #content>
                            <div class="flex items-center justify-end space-x-2">
                                <Button @click="$inertia.get(route('products'))" variant="outline">Cancel</Button>
                                <Button @click="submit">Save</Button>
                            </div>
                        </template>
                    </Card>
                </div>
            </TabsContent>
        </Tabs>
    </BreezeAuthenticatedLayout>
</template>

<script>
import Compressor from 'compressorjs';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs'
import Card from '@/Components/Card.vue'

function blobToFile(blob, filename) {
  const file = new File([blob], filename, { type: blob.type });
  return file;
}

export default {
    components: {
        Card
    },
    data(){
        return{
            form: {
                basic_info: {
                    product_name: '',
                    product_description: '',
                    product_price: '',
                    product_stock: '',
                    product_images: {
                        cover: {label: 'Cover Image', required: true, file: null, value: null},
                        image_1: {label: 'Image 1', required: false, file: null, value: null},
                        image_2: {label: 'Image 2', required: false, file: null, value: null},
                        image_3: {label: 'Image 3', required: false, file: null, value: null},
                        image_4: {label: 'Image 4', required: false, file: null, value: null},
                        image_5: {label: 'Image 5', required: false, file: null, value: null },
                        image_6: {label: 'Image 6', required: false, file: null, value: null}
                    },
                },
                detailed_info:{
                    has_variation: false,
                    has_sub_variation: false,
                    main_variation_name: '',
                    sub_variation_name: '',
                    variations: {
                        options: [{
                            name: '',
                            images: {
                                file: null, 
                                value: null
                            },
                            price: 0,
                            stock: 0,
                            sub_variations: {
                                options: [{
                                    name: '',
                                    price: 0,
                                    stock: 0,
                                }]
                            }
                        }]
                    },
                }
            }
        }
    },
    methods: {
        submit(){
            this.$inertia.post(route('products.store'), this.form)
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
