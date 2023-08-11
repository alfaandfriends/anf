<script setup>
import Modal from '@/Components/Modal.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import UploadPreview from '@/Components/UploadPreview.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
    open: {
        type: Boolean,
        required: true
    },
});

const previewUrl = ref([
    {label: 'Cover Image', name: 'product_cover_image', value: null},
    {label: 'Image 1', name: 'product_image_1', value: null},
    {label: 'Image 2', name: 'product_image_2', value: null},
    {label: 'Image 3', name: 'product_image_3', value: null},
    {label: 'Image 4', name: 'product_image_4', value: null},
    {label: 'Image 5', name: 'product_image_5', value: null},
    {label: 'Image 6', name: 'product_image_6', value: null},
]);

const form = useForm({
    id: '',
    name: '',
    images: [
        {label: 'Cover Image', name: 'product_cover_image', value: null},
        {label: 'Image 1', name: 'product_image_1', value: null},
        {label: 'Image 2', name: 'product_image_2', value: null},
        {label: 'Image 3', name: 'product_image_3', value: null},
        {label: 'Image 4', name: 'product_image_4', value: null},
        {label: 'Image 5', name: 'product_image_5', value: null},
        {label: 'Image 6', name: 'product_image_6', value: null}
    ],
    description: '',
    category: '',
});

watch(() => props.item, (newValue) => {
    form.name = newValue.name;
    form.description = newValue.description;
    form.category = newValue.product_category_id;
    const updatedImages = form.images.map((image) => {
        const matchedImage = newValue.images.find((newImage) => newImage.name === image.name.replace(/^product_/, ''));
        if (matchedImage) {
            return {
                ...image,
                value: 'storage/' + matchedImage.path,
            };
        }
        return image;
    });
    form.images = updatedImages;
});

const emit = defineEmits(['toggle:show']);

const submit = () => {
    form.put(route('product-variation-item.destroy', props.item.variation_item_id), {
        onSuccess: () => {
            form.reset();
            emit('toggle:show', false);
        },
    });
};
</script>
<template>
    <div>
        <Modal :showModal="open" modalType="lg" @hideModal="emit('toggle:show', false)">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">
                    Edit Product
                </h3>
            </template>
            <template v-slot:content>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                    <BreezeValidationErrors class="mb-4" />
                    <div class="mb-4">
                        <label for="category_name" class="block text-sm text-gray-700 font-bold mb-2"> Product Images <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap justify-center">
                            <div v-for="(item, index) in form.images" :key="index" class="flex flex-col items-center p-2 m-2">
                                <UploadPreview :previewUrl="item.value" @update:value="handleFileChange($event, item.name)" />
                                <label :for="item.label" class="text-sm text-gray-500 text-center"> {{ item.label }} </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="name" id="name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.name" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="product_description" class="block text-sm text-gray-700 font-bold mb-2"> Product Description <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <textarea name="product_description" id="product_description" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.description" cols="10" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Product Category <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <select name="product_category" id="product_category" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.category">
                                <option value="">Please Select</option>
                                <option v-for="(category, index) in categories" :key="index" :value="category.id"> {{ category.name }} </option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="mb-4">
                        <label for="price" class="block text-sm text-gray-700 font-bold"> Price <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="price" id="price" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.price" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="stock" class="block text-sm text-gray-700 font-bold"> Stock <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="stock" id="stock" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.stock" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="sales" class="block text-sm text-gray-700 font-bold"> Sales <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="sales" id="sales" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.sales" autocomplete="off"/>
                        </div>
                    </div> -->
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="emit('toggle:show', false)">Cancel</BreezeButton>
                    <BreezeButton @click="submit">Update</BreezeButton>
                </div>
            </template>
        </Modal>
    </div>
</template>
