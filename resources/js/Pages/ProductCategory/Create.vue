<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    category: {
        type: Object,
    },
});

const form = useForm({
    category_name: (props.category) ? props.category.name : '',
});

const formUrl = (props.category) ? route('product-categories.update', props.category.id): route('product-categories.store');
const formMethod = (props.category) ? 'put' : 'post';

const submit = () => {
    form[formMethod](formUrl, {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Product Category" />

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
                                        <h1 class="font-bold text-indigo-800">New Product Category</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <BreezeValidationErrors class="mb-4" />
                                        <div class="mb-4">
                                            <label for="category_name" class="block text-sm text-gray-700 font-bold"> Product Category Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="category_name" id="category_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.category_name" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between space-x-2">
                                        <BreezeButton :route="route('product-categories')" buttonType="gray">Back</BreezeButton>
                                        <BreezeButton type="submit">{{ (category) ? 'Update' : 'Create' }}</BreezeButton>
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
