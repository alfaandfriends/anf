<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Fees" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Fee
            </h2>
        </template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="font-semibold text-indigo-800 font-bold">Fee Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="fee_type" class="block text-sm font-medium text-gray-700 font-bold">Fee Type<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.fee_type ? 'border-red-300' : 'border-gray-300'" name="" id="" v-model="form.fee_type">
                                                <option value="">Please select</option>
                                                <option :value="fee_type.id" v-for="fee_type in fee_types" :key="fee_type.id">{{ fee_type.label }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="period" class="block text-sm font-medium text-gray-700 font-bold">Period<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.period ? 'border-red-300' : 'border-gray-300'" name="" id="" v-model="form.period">
                                                <option value="">Please select</option>
                                                <option :value="fee_period.id" v-for="fee_period in fee_periods" :key="fee_period.id">{{ fee_period.label }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="class_per_week" class="block text-sm font-medium text-gray-700 font-bold">Class Per Week<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="number" name="class_per_week" id="class_per_week" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_per_week ? 'border-red-300' : 'border-gray-300'" v-model="form.class_per_week" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="class_duration" class="block text-sm font-medium text-gray-700 font-bold">Class Duration (Hours / Minutes)<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <div class="pr-2">
                                                <!-- <label for="class_duration_hours" class="text-sm">Hour</label> -->
                                                <input type="number" max="23" name="class_duration_hours" id="class_duration_hours" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_duration_hours ? 'border-red-300' : 'border-gray-300'" v-model="form.class_duration_hours" autocomplete="none" placeholder="Hours"/>
                                            </div>
                                            <div class="pr-2">
                                                <!-- <label for="class_duration_minutes" class="text-sm">Minutes</label> -->
                                                <input type="number" max="59" name="class_duration_minutes" id="class_duration_minutes" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_duration_minutes ? 'border-red-300' : 'border-gray-300'" v-model="form.class_duration_minutes" autocomplete="none" placeholder="Minutes"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="fee_amount" class="block text-sm font-medium text-gray-700 font-bold">Fee Amount<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="number" step="any" name="fee_amount" id="fee_amount" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.fee_amount ? 'border-red-300' : 'border-gray-300'" v-model="form.fee_amount" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-end justify-start">
                            <BreezeButton type="submit">Save</BreezeButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Head, Link, 
    },
    props: {
        fee_types: Object,
        fee_periods: Object
    },
    data(){
        return{
            form: {
                fee_type: '',
                period: '',
                class_per_week: 0,
                class_duration_hours: 0,
                class_duration_minutes: 0,
                fee_amount: 0.0,
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('fees.store'), this.form, { preserveState: true})
        },
    }

}
</script>
