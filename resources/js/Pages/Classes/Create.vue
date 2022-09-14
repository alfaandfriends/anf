<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Classes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Class
            </h2>
        </template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Class Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="class_name" class="block text-sm font-bold text-gray-700"> Class Name <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="class_name" id="class_name" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_name ? 'border-red-300' : 'border-gray-300'" v-model="form.class_name" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="programme" class="block text-sm font-bold text-gray-700"> Programme <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="programme" id="programme" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme ? 'border-red-300' : 'border-gray-300'" v-model="form.programme" autocomplete="none">
                                                <option :value="programme.id" v-for="(programme, index) in programme_list" :key="index">{{ programme.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="class_level" class="block text-sm font-bold text-gray-700"> Class Level <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="class_level" id="class_level" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_level ? 'border-red-300' : 'border-gray-300'" v-model="form.class_level" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="class_day" class="block text-sm font-bold text-gray-700"> Class Day <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="class_day" id="class_day" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_day ? 'border-red-300' : 'border-gray-300'" v-model="form.class_day" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="start_date" class="block text-sm font-bold text-gray-700"> Start Date <span class="text-red-500">*</span></label>
                                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.start_date ? '--dp-border-color: #fa9e9e' : ''" :format="'dd/MM/yyyy'" autoApply :enableTimePicker="false" v-model="form.start_date" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="end_date" class="block text-sm font-bold text-gray-700"> End Date <span class="text-red-500">*</span></label>
                                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.end_date ? '--dp-border-color: #fa9e9e' : ''" :format="'dd/MM/yyyy'" autoApply :enableTimePicker="false" v-model="form.end_date" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="class_capacity" class="block text-sm font-bold text-gray-700"> Class Capacity <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="class_capacity" id="class_capacity" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_capacity ? 'border-red-300' : 'border-gray-300'" v-model="form.class_capacity" autocomplete="none"/>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="class_type" class="block text-sm font-bold text-gray-700"> Class Type <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="class_type" id="class_type" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_type ? 'border-red-300' : 'border-gray-300'" v-model="form.class_type" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-end justify-between">
                                    <div class="pr-3">
                                        <label for="" class="block font-bold text-gray-700">Active</label>
                                        <Toggle v-model="form.class_status" 
                                            :classes="{
                                                container: 'inline-block',
                                                toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                                toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                            }
                                        "/>
                                    </div>
                                    <button type="submit" class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 select-none">Add Class</button>
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
import { Head, Link } from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import Toggle from '@vueform/toggle';

export default {
    components: {
        Head, Link, Datepicker, Toggle
    },
    props: {
        programme_list: Object,
    },
    data(){
        return{
            levels: [],
            form: {
                class_name: '',
                programme: '',
                class_level: '',
                class_day: '',
                start_date: '',
                end_date: '',
                class_capacity: '',
                class_type: '',
                class_status: '',
            }
        }
    },
    watch: {
        form: {
            handler(){
                if(this.form.programme){
                    console.log(this.form.programme)
                }
            },
            deep: true
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('sessions.store'), this.form, { preserveState: true})
        },
    }

}
</script>
