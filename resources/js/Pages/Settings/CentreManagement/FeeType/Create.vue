<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="General Setting" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Fee Period
            </h2>
        </template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="font-semibold text-indigo-800 font-bold">Fee Period Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="fee_type" class="block text-sm font-medium text-gray-700 font-bold">Fee Period<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="fee_type" id="fee_type" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.fee_type ? 'border-red-300' : 'border-gray-300'" v-model="form.fee_type" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-end justify-start space-x-2">
                            <BreezeButton buttonType="gray" :route="route('settings.fee_type_list')">Cancel</BreezeButton>
                            <BreezeButton type="submit">Save </BreezeButton>
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
    data(){
        return{
            form: {
                fee_type: '',
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('settings.fee_type_list.store'), this.form, { preserveState: true})
        },
    }

}
</script>
