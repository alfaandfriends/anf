<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    order: {
        type: Object,
    },
    statuses: {
        type: Object,
    },
    providers: {
        type: Object,
    },
    users: {
        type: Object,
    },
});

const form = useForm({
    order_customer: (props.order) ? props.order.customer_id : '',
    order_product: (props.order) ? props.order.product_id : '',
    order_status: (props.order) ? props.order.status : '',
    order_shipping_no: (props.order) ? props.order.tracking_no : '',
    order_shipping_provider: (props.order) ? props.order.shipping_provider : '',
});

const formUrl = (props.order) ? route('orders.update', props.order.id): route('orders.store');
const formMethod = (props.order) ? 'put' : 'post';

const submit = () => {
    form[formMethod](formUrl, {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Order" />

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
                                        <h1 class="font-bold text-indigo-800">{{ (order) ? 'Update' : 'New' }} Order </h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <BreezeValidationErrors class="mb-4" />
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Customer <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="product_category" id="product_category" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.order_customer">
                                                    <option value="">Please Select</option>
                                                    <option v-for="(user, index) in users" :key="index" :value="user.id"> {{ user.display_name }} </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Product <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="product_category" id="product_category" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.order_product">
                                                    <option value="">Please Select</option>
                                                    <option value="1">Dummy</option>
                                                    <!-- <option v-for="(category, index) in categories" :key="index" :value="category.id"> {{ category.name }} </option> -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Status <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="product_category" id="product_category" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.order_status">
                                                    <option value="">Please Select</option>
                                                    <option v-for="(status, index) in statuses" :key="index" :value="status"> {{ status }} </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="order_name" class="block text-sm text-gray-700 font-bold mb-2"> Tracking No <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="order_name" id="order_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.order_shipping_no" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Shipping Provider <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="product_category" id="product_category" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.order_shipping_provider">
                                                    <option value="">Please Select</option>
                                                    <option v-for="(provider, index) in providers" :key="index" :value="provider.id"> {{ provider.name }} </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between space-x-2">
                                        <BreezeButton :route="route('orders')" buttonType="gray">Back</BreezeButton>
                                        <BreezeButton type="submit">{{ (order) ? 'Update' : 'Create' }}</BreezeButton>
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
