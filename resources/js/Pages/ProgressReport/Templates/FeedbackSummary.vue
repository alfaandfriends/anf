<script setup>
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
        <div class="sm:row-span-3">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="mb-5">
                    <h1 class="font-bold text-indigo-800 self-end">Summary</h1>
                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">What's Next</label>
                        <textarea class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" rows="3" cols="" v-model="form.upcoming_feedback"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Need Improvement On</label>
                        <textarea class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" rows="3" cols="" v-model="form.improvement_feedback"></textarea>
                    </div>
                </div>
                <div class="flex justify-end">
                    <BreezeButton @click="saveFeedback()">Save</BreezeButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            form: {
                id: this.$page.props.report_details.id,
                upcoming_feedback: this.$page.props.report_details.upcoming_feedback ? this.$page.props.report_details.upcoming_feedback : '',
                improvement_feedback: this.$page.props.report_details.improvement_feedback ? this.$page.props.report_details.improvement_feedback : '',
            }
        }
    },
    methods: {
        saveFeedback(){
            this.$inertia.post(route('progress_report.store_summary'), this.form)
        }
    }
}
</script>