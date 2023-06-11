<script setup>
import Modal from '@/Components/Modal.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { watch } from 'vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    open: {
        type: Boolean,
        required: true
    },
});

const form = useForm({
    id: '',
    name: '',
    price: '',
    stock: '',
    sales: '',
});

watch(() => props.item, (newValue) => {
    form.name = newValue.name;
    form.price = newValue.price;
    form.stock = newValue.stock;
    form.sales = newValue.sales;
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
        <Modal :showModal="open" modalType="sm" @hideModal="emit('toggle:show', false)">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">
                    Edit Product
                </h3>
            </template>
            <template v-slot:content>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                    <BreezeValidationErrors class="mb-4" />
                    <div class="mb-4">
                        <label for="name" class="block text-sm text-gray-700 font-bold"> name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="name" id="name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.name" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="mb-4">
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
                    </div>
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
