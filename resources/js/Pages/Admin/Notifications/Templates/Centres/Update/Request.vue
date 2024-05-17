<script setup>
    import NotificationLayout from '@/Pages/Admin/Notifications/Layout.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <Head title="Notifications" />
    <NotificationLayout>
        <div class="flex-col w-full pt-4 px-4">
            <div class="pb-3 px-2 space-y-2">
                <div class="bg-white rounded-lg shadow-xl p-4">
                    <div class="text-center">
                        <div class="pt-2">
                            <a target="_blank" :href="route('centres.edit', {'centre_id': request_data.centre_id})" class="rounded shadow-md px-2 py-1 bg-indigo-500 text-white">View this centre</a>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-xl p-4">
                    <div class="md:grid md:grid-cols-2">
                        <div class="md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                <div class="sm:row-span-3">
                                    <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                        <h2 class="font-display font-bold text-indigo-600">Centre Details</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="centre_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="centre_name" id="centre_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.centre_name ? 'border-green-500' : 'border-gray-300'" v-model="form.centre_name" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="centre_contact_number" class="block text-sm text-gray-700 font-bold"> Contact Number <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="centre_contact_number" id="centre_contact_number" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.centre_contact_number ? 'border-green-500' : 'border-gray-300'" v-model="form.centre_contact_number" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="centre_email" class="block text-sm text-gray-700 font-bold"> Email <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="centre_email" id="centre_email" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.centre_email ? 'border-green-500' : 'border-gray-300'" v-model="form.centre_email" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="centre_address" class="block text-sm text-gray-700 font-bold"> Address <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <textarea name="centre_address" id="centre_address" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.centre_address ? 'border-green-500' : 'border-gray-300'" v-model="form.centre_address" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-xl p-4">
                    <div class="md:grid md:grid-cols-2">
                        <div class="md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                <div class="sm:row-span-3">
                                    <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                        <h2 class="font-display font-bold text-indigo-600">Principal Details</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="principal_email" class="block text-sm text-gray-700 font-bold"> Email <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="principal_email" id="principal_email" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm bg-gray-200" :class="!record_matched.principal_email ? 'border-green-500' : 'border-gray-300'" v-model="form.principal_email" readonly autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="principal_contact" class="block text-sm text-gray-700 font-bold"> Contact Number <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="principal_contact" id="principal_contact" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.principal_contact ? 'border-green-500' : 'border-gray-300'" v-model="form.principal_contact" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="principal_first_name" class="block text-sm text-gray-700 font-bold"> First Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="principal_first_name" id="principal_first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm bg-gray-200" :class="!record_matched.principal_first_name ? 'border-green-500' : 'border-gray-300'" v-model="form.principal_first_name" readonly autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="principal_last_name" class="block text-sm text-gray-700 font-bold"> Last Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="principal_last_name" id="principal_last_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm bg-gray-200" :class="!record_matched.principal_last_name ? 'border-green-500' : 'border-gray-300'" v-model="form.principal_last_name" readonly autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-xl p-4" v-if="request_data.images_to_add && request_data.images_to_add.length">
                    <div class="md:grid md:grid-cols-2">
                        <div class="md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                <div class="sm:row-span-3">
                                    <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                        <h2 class="font-display font-bold text-indigo-600">Centre Images <span class="text-[12px] text-green-500">(To Add)</span></h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="flex flex-wrap space-x-2">
                                            <div class="w-2/12 h-2/12 text-center" v-for="image in request_data.images_to_add">
                                                <img :src="image.image_path" alt="..." class="shadow-lg rounded max-w-full h-auto align-middle border-none" />
                                                <span class="text-sm capitalize font-semibold">{{ image.image_type }} View</span>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-xl p-4" v-if="request_data.images_to_delete && request_data.images_to_delete.length">
                    <div class="md:grid md:grid-cols-2">
                        <div class="md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                <div class="sm:row-span-3">
                                    <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                        <h2 class="font-display font-bold text-indigo-600">Centre Images <span class="text-[11px] text-red-500">(To Delete)</span></h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="flex flex-wrap space-x-2">
                                            <div class="w-2/12 h-2/12 text-center" v-for="image in request_data.images_to_delete">
                                                <img :src="image.image_path" alt="..." class="shadow-lg rounded max-w-full h-auto align-middle border-none" />
                                                <span class="text-sm capitalize font-semibold">{{ image.image_type }} View</span>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-xl p-4">
                    <div class="flex space-x-5">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:col-start-2 sm:text-sm" @click="approve">Approve</button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:col-start-1 sm:text-sm" @click="reject">Reject</button>
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
                centre_info: [],
                record_matched: {
                    centre_id: '',
                    centre_name: '',
                    centre_contact_number: '',
                    centre_email: '',
                    centre_address: '',
                    centre_active: '',
                    principal_first_name: '',
                    principal_last_name: '',
                    principal_email: '',
                    principal_contact: '',
                },
                form: {
                    notification_id: this.notification_data.id,
                    centre_id: this.request_data ? this.request_data.centre_id : '',
                    centre_name: this.request_data ? this.request_data.centre_name : '',
                    centre_contact_number: this.request_data ? this.request_data.centre_contact_number : '',
                    centre_email: this.request_data ? this.request_data.centre_email : '',
                    centre_address: this.request_data ? this.request_data.centre_address : '',
                    centre_active: this.request_data ? this.request_data.centre_active : '',
                    principal_first_name: this.request_data ? this.request_data.principal_first_name : '',
                    principal_last_name: this.request_data ? this.request_data.principal_last_name : '',
                    principal_email: this.request_data ? this.request_data.principal_email : '',
                    principal_contact: this.request_data ? this.request_data.principal_contact : '',
                    created_by: this.created_by ? this.created_by : '',
                    images_to_add: this.request_data ? this.request_data.images_to_add : '',
                    images_to_delete: this.request_data ? this.request_data.images_to_delete : '',
                },
            }
        },
        created(){
            axios.get(route('get_approval_centre_info', this.form.centre_id))
            .then((res) => {
                this.centre_info = res.data
                this.record_matched.centre_id = this.request_data.centre_id == this.centre_info.centre_id ? true : false
                this.record_matched.centre_name = this.request_data.centre_name == this.centre_info.centre_name ? true : false
                this.record_matched.centre_contact_number = this.request_data.centre_contact_number == this.centre_info.centre_contact_number ? true : false
                this.record_matched.centre_email = this.request_data.centre_email == this.centre_info.centre_email ? true : false
                this.record_matched.centre_address = this.request_data.centre_address == this.centre_info.centre_address ? true : false
                this.record_matched.centre_active = this.request_data.centre_active == this.centre_info.centre_active ? true : false
                this.record_matched.principal_first_name = this.request_data.principal_first_name == this.centre_info.principal_firstname ? true : false
                this.record_matched.principal_last_name = this.request_data.principal_last_name == this.centre_info.principal_lastname ? true : false
                this.record_matched.principal_email = this.request_data.principal_email == this.centre_info.principal_email ? true : false
                this.record_matched.principal_contact = this.request_data.principal_contact == this.centre_info.principal_contact ? true : false
            });
        },
        methods: {
            approve() {
                this.$inertia.post(route('approve_centre_update'), this.form, { preserveScroll: true})
            },
            reject() {
                this.$inertia.post(route('reject_centre_update'), this.form, { preserveScroll: true})
            },
        }
    }
</script>