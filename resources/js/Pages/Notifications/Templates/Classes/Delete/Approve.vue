<script setup>
    import NotificationLayout from '@/Pages/Notifications/Layout.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <Head title="Notifications" />
    <NotificationLayout>
        <div class="flex-col w-full pt-4 px-4 space-y-2" v-if="show">
            <div class="bg-white rounded-lg shadow-xl px-4 py-10">
                <div class="flex flex-col items-center space-y-2">
                    <div class="flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 w-10 h-10" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                        </svg>
                        <p class="text-lg font-bold">
                            Your request to delete class has been <span class="font-bold text-green-500">approved</span>.</p>
                    </div>
                </div>
            </div>
            <!-- <div class="bg-white rounded-lg shadow-xl p-4">
                <div class="mx-6 mt-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Class Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Class details and related information</p>
                </div>
                <div class="mt-5 border-t border-gray-200 mx-6">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Centre</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ class_info.centre_name }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Programme</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ class_info.programme_name }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Class Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ class_info.class_type }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Class Level</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Level {{ class_info.class_level }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Class Day</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ class_info.class_day }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Class Method</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ class_info.class_method }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Class Capacity</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ class_info.class_capacity }} Person</dd>
                        </div>
                    </dl>
                </div>
            </div> -->
        </div>
    </NotificationLayout>
</template>
<script>
    export default{
        props:{
            request_data: Object,
        },
        data(){
            return {
                show: false,
                class_info: [],
                form: {
                    class_id: this.request_data ? this.request_data.class_id : '',
                    created_by: this.created_by ? this.created_by : '',
                },
            }
        },
        mounted(){
            axios.get(route('get_class_info', this.form.class_id))
            .then((res) => {
                this.class_info = res.data
            })
            .finally(()=>{
                this.show = true
            });
        },
    }
</script>