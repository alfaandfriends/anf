<script setup>
    import NotificationLayout from '@/Pages/Notifications/Layout.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <Head title="Notifications" />
    <NotificationLayout>
        <div class="flex-col w-full pt-4 px-4 space-y-3">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="mb-5">
                    <h1 class="text-indigo-800 font-bold">Programme Information</h1>
                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                    <div class="mb-4">
                        <label for="programme_name" class="block text-sm text-gray-700 font-bold"> Programme Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="programme_name" id="programme_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.programme_name ? 'border-green-500' : 'border-gray-300'" v-model="form.programme_name" autocomplete="off"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="mb-5">
                    <h1 class="text-indigo-800 font-bold">Current Programme Levels & Fees</h1>
                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                </div>
                <div class="shadow overflow-hidden border-b border-gray-200 rounded-t-sm rounded-b-none mt-3">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-200">
                            <tr>
                                <th class="px-4 py-1 text-center border border-gray-400">Level</th>
                                <th class="px-4 py-1 text-center border border-gray-400">Class Type</th>
                                <th class="px-4 py-1 text-center border border-gray-400">Material Fee</th>
                                <th class="px-4 py-1 text-center border border-gray-400" v-for="class_type_detail in this.request_data.class_type_details">{{ class_type_detail.label }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!form.programme_info.length">
                                <td colspan="8" class="py-4 text-center">No levels added.</td>
                            </tr>
                            <tr else class="hover:bg-gray-200" v-for="info, index in form.programme_info">
                                <td class="px-4 py-2 text-center border border-gray-400">{{ info.level }}</td>
                                <td class="px-4 py-2 text-center border border-gray-400">{{ request_data.class_types[info.class_type_id].name}}</td>
                                <td class="px-4 py-2 text-center border border-gray-400">
                                    <span v-if="info.material_fee != null">RM </span>{{ info.material_fee }}
                                </td>
                                <td class="px-4 py-2 text-center border border-gray-400" v-for="class_type_detail, class_type_detail_index in this.request_data.class_type_details">
                                    <span v-if="form.programme_info[index].fees[class_type_detail.id] != null">RM </span>{{ form.programme_info[index].fees[class_type_detail.id] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="mb-5">
                    <h1 class="text-indigo-800 font-bold">Programme Levels & Fees (<span class="text-[12px] text-red-500"> To Remove </span>)</h1>
                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                </div>
                <div class="shadow overflow-hidden border-b border-gray-200 rounded-t-sm rounded-b-none mt-3">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-200">
                            <tr>
                                <th class="px-4 py-1 text-center border border-gray-400">Level</th>
                                <th class="px-4 py-1 text-center border border-gray-400">Class Type</th>
                                <th class="px-4 py-1 text-center border border-gray-400">Material Fee</th>
                                <th class="px-4 py-1 text-center border border-gray-400" v-for="class_type_detail in this.request_data.class_type_details">{{ class_type_detail.label }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!form.programme_level_to_delete.length">
                                <td colspan="8" class="py-4 text-center">No item to be removed.</td>
                            </tr>
                            <tr else class="hover:bg-gray-200" v-for="info, index in form.programme_level_to_delete">
                                <td class="px-4 py-2 text-center border border-gray-400">{{ info.level }}</td>
                                <td class="px-4 py-2 text-center border border-gray-400">{{ request_data.class_types[info.class_type_id].name}}</td>
                                <td class="px-4 py-2 text-center border border-gray-400">
                                    <span v-if="info.material_fee != null">RM </span>{{ info.material_fee }}
                                </td>
                                <td class="px-4 py-2 text-center border border-gray-400" v-for="class_type_detail, class_type_detail_index in this.request_data.class_type_details">
                                    <span v-if="form.programme_level_to_delete[index].fees[class_type_detail.id] != null">RM </span>{{ form.programme_level_to_delete[index].fees[class_type_detail.id] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="mb-5">
                    <h1 class="text-indigo-800 font-bold">Programme Levels & Fees (<span class="text-[12px] text-green-500"> To Add </span>)</h1>
                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                </div>
                <div class="shadow overflow-hidden border-b border-gray-200 rounded-t-sm rounded-b-none mt-3">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-200">
                            <tr>
                                <th class="px-4 py-1 text-center border border-gray-400">Level</th>
                                <th class="px-4 py-1 text-center border border-gray-400">Class Type</th>
                                <th class="px-4 py-1 text-center border border-gray-400">Material Fee</th>
                                <th class="px-4 py-1 text-center border border-gray-400" v-for="class_type_detail in this.request_data.class_type_details">{{ class_type_detail.label }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!form.programme_level_to_add.length">
                                <td colspan="8" class="py-4 text-center">No levels added.</td>
                            </tr>
                            <tr else class="hover:bg-gray-200" v-for="info, index in form.programme_level_to_add">
                                <td class="px-4 py-2 text-center border border-gray-400">{{ info.level }}</td>
                                <td class="px-4 py-2 text-center border border-gray-400">{{ request_data.class_types[info.class_type].name}}</td>
                                <td class="px-4 py-2 text-center border border-gray-400">
                                    <span v-if="info.material_fee != null">RM </span>{{ info.material_fee }}
                                </td>
                                <td class="px-4 py-2 text-center border border-gray-400" v-for="class_type_detail, class_type_detail_index in this.request_data.class_type_details">
                                    <span v-if="form.programme_level_to_add[index].fees[class_type_detail.id] != null">RM </span>{{ form.programme_level_to_add[index].fees[class_type_detail.id] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-4">
                <div class="flex space-x-5">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:col-start-2 sm:text-sm" @click="approve">Approve</button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:col-start-1 sm:text-sm" @click="reject">Reject</button>
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
                current_programme_info: [],
                class_types_detail: [],
                level: '',
                material_fee: '',
                class_type: '',
                fee: [],
                form: {
                    notification_id: this.notification_data.id,
                    programme_id: this.request_data.programme_id ? this.request_data.programme_id : '',
                    programme_name: this.request_data.programme_name ? this.request_data.programme_name : '',
                    programme_info: this.request_data.current_programme_levels ? this.request_data.current_programme_levels : [],
                    programme_level_to_add: this.request_data.programme_level_to_add ? this.request_data.programme_level_to_add : [],
                    programme_level_to_delete: this.request_data.programme_level_to_delete ? this.request_data.programme_level_to_delete : [],
                    created_by: this.created_by ? this.created_by : '',
                },
                record_matched: {
                    programme_id: this.request_data.programme_id ? this.request_data.programme_id : '',
                    programme_name: this.request_data.programme_name ? this.request_data.programme_name : '',
                }
            }
        },
        mounted(){
            axios.get(route('get_programme_name', this.form.programme_id))
            .then((res) => {
                this.current_programme_info = res.data
                this.record_matched.programme_name = this.request_data.programme_name == this.current_programme_info.programme_name ? true : false
            });
        },
        methods: {
            approve() {
                this.$inertia.post(route('approve_programme_update'), this.form, { preserveScroll: true})
            },
            reject() {
                this.$inertia.post(route('reject_programme_update'), this.form, { preserveScroll: true})
            },
        }
    }
</script>