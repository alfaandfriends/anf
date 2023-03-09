<script setup>
    import NotificationLayout from '@/Pages/Notifications/Layout.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <Head title="Notifications" />
    <NotificationLayout>
        <div class="flex-col w-full pt-4 px-4">
            <div class="pb-3 px-2 space-y-2" v-if="show">
                <div class="bg-white rounded-lg shadow-xl p-4">
                    <div class="mx-6 mt-2">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Class Information</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Class details and related information.</p>
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
                </div>
                <div class="bg-white rounded-lg shadow-xl p-4">
                    <div class="flex space-x-5">
                        <button class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md" @click="reject">
                          Reject
                        </button>
                        <button class="flex-1 px-4 py-2 ml-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md" @click="approve">
                          Approve
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </NotificationLayout>
</template>
<script>
    export default{
        props:{
            request_data: Object,
            created_by: String,
            notification_data: Object
        },
        data(){
            return{
                show: false,
                class_info: [],
                form: {
                    notification_id: this.notification_data.id,
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
        methods: {
            approve() {
                this.$inertia.post(route('approve_class_delete'), this.form, { preserveState: true})
            },
            reject() {
                this.$inertia.post(route('reject_class_delete'), this.form, { preserveState: true})
            },
        }
    }
</script>