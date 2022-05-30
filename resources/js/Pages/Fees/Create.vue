<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Sessions" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Session
            </h2>
        </template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="font-semibold text-indigo-800 font-bold">Session Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="session_name" class="block text-sm font-medium text-gray-700 font-bold"> Session <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="session_name" id="session_name" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.session ? 'border-red-300' : 'border-gray-300'" v-model="form.session" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="class_name" class="block text-sm font-medium text-gray-700 font-bold"> Start Date <span class="text-red-500">*</span></label>
                                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.start_date ? '--dp-border-color: #fa9e9e' : ''" :format="'dd/MM/yyyy'" autoApply :enableTimePicker="false" v-model="form.start_date" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="class_name" class="block text-sm font-medium text-gray-700 font-bold"> End Date <span class="text-red-500">*</span></label>
                                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.end_date ? '--dp-border-color: #fa9e9e' : ''" :format="'dd/MM/yyyy'" autoApply :enableTimePicker="false" v-model="form.end_date" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-end justify-start">
                            <button type="submit" class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 select-none">Add Session</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
    components: {
        Head, Link, Datepicker, 
    },
    data(){
        return{
            form: {
                session: '',
                start_date: '',
                end_date: ''
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('sessions.store'), this.form, { preserveState: true})
        },
    }

}
</script>
