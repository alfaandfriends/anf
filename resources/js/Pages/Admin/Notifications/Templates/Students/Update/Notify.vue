<script setup>
    import NotificationLayout from '@/Pages/Admin/Notifications/Layout.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <Head title="Notifications" />
    <NotificationLayout>
        <div class="flex-col w-full pt-4 px-4 space-y-4">
            <div class="bg-white rounded-lg shadow-xl p-4">
                <div class="mx-6 mt-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Student details and related information</p>
                </div>
                <div class="mt-5 border-t border-gray-200 mx-6">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ request_data.basic_info.name }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Gender</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ request_data.basic_info.gender }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ request_data.basic_info.dob }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-4">
                <div class="mx-6 mt-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Parent Information</h3>
                </div>
                <div class="mt-5 border-t border-gray-200 mx-6">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ request_data.parent_info.name }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">phone</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ request_data.parent_info.phone }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ request_data.parent_info.email }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 capitalize">{{ request_data.parent_info.address }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
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

            }
        },
    }
</script>