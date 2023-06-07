<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <!-- <input type="hidden" v-model="menu_id"> -->
                    <div class="px-4 py-5 bg-indigo-50 space-y-2 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Diagnostic Test Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="name" class="block text-sm text-gray-700 font-bold">Name<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="name" id="name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" v-model="form.name" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="age" class="block text-sm text-gray-700 font-bold">Age<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select type="text" name="age" id="age" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.age ? 'border-red-300' : 'border-gray-300'" v-model="form.age" autocomplete="off">
                                                    <option value="">Please select a age</option>
                                                    <option :value="age.id" v-for="age in $page.props.ages">{{ age.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="language" class="block text-sm text-gray-700 font-bold">Language<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select type="text" name="language" id="language" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.language ? 'border-red-300' : 'border-gray-300'" v-model="form.language" autocomplete="off">
                                                    <option value="">Please select a language</option>
                                                    <option :value="language.id" v-for="language in $page.props.languages">{{ language.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Conditions</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="lower_score" class="block text-sm text-gray-700 font-bold">If score less than</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="lower_score" id="lower_score" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.lower_score ? 'border-red-300' : 'border-gray-300'" v-model="form.lower_score" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="lower_score_direction" class="block text-sm text-gray-700 font-bold">Go to</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="lower_score_direction" id="lower_score_direction" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.lower_score_direction ? 'border-red-300' : 'border-gray-300'" v-model="form.lower_score_direction" autocomplete="off">
                                                    <option value="">Default</option>
                                                    <option :value="dt_info.id" v-for="dt_info in $page.props.dt_list">{{ dt_info.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="higher_score" class="block text-sm text-gray-700 font-bold">If score more than</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="higher_score" id="higher_score" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.higher_score ? 'border-red-300' : 'border-gray-300'" v-model="form.higher_score" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="higher_score_direction" class="block text-sm text-gray-700 font-bold">Go to</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="higher_score_direction" id="higher_score_direction" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.higher_score_direction ? 'border-red-300' : 'border-gray-300'" v-model="form.higher_score_direction" autocomplete="off">
                                                    <option value="">Default</option>
                                                    <option :value="dt_info.id" v-for="dt_info in $page.props.dt_list">{{ dt_info.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="final_message" class="block text-sm text-gray-700 font-bold">Final Message   </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <textarea type="text" name="final_message" id="final_message" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.final_message ? 'border-red-300' : 'border-gray-300'" v-model="form.final_message" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Chart Settings</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="chart_type" class="block text-sm text-gray-700 font-bold">Chart Type</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="chart_type" id="chart_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.chart_type ? 'border-red-300' : 'border-gray-300'" v-model="form.chart_type" autocomplete="off">
                                                    <option :value="chart.id" v-for="chart in $page.props.chart_types">{{ chart.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="flex items-end justify-end space-x-2">
                                        <BreezeButton buttonType="gray" :route="route('dt.settings')">Cancel</BreezeButton>
                                        <BreezeButton type="submit">Save </BreezeButton>
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
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Head, Link, 
    },
    data(){
        return{
            form: {
                name: '',
                age: '',
                language: '',
                chart_type: this.$page.props.chart_types[0].id,
                lower_score: '',
                lower_score_direction: '',
                higher_score: '',
                higher_score_direction: '',
                final_message: '',
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('dt.settings.store'), this.form, { preserveState: true})
        },
    }

}
</script>
