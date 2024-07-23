<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Permissions" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="text-indigo-800 font-bold">Permission Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="permission" class="block text-sm text-gray-700 font-bold">Permission<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="permission" id="permission" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.permission ? 'border-red-300' : 'border-gray-300'" v-model="form.permission" autocomplete="off"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="text-indigo-800 font-bold">Sub Permission Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="flex items-end justify-between space-x-2">
                                        <div class="flex-1 mb-4">
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="sub_permission" id="sub_permission" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.sub_permission ? 'border-red-300' : 'border-gray-300'" v-model="sub_permission" autocomplete="off" placeholder="e.g. view_details_access"/>
                                            </div>
                                        </div>
                                        <div class="flex flex-none mb-4">
                                            <BreezeButton buttonType="info" class="py-2.5 px-4" @click="addSub()">Add</BreezeButton>
                                        </div>
                                    </div>
                                    <div class="overflow-x-auto relative">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-indigo-200">
                                                <tr>
                                                    <th scope="col" class="py-2 px-6">
                                                        Sub Permission
                                                    </th>
                                                    <th scope="col" class="py-2 px-6 text-center">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bg-white border-b" v-if="!form.sub_permission.length < 1" v-for="sub_permission, index in form.sub_permission">
                                                    <th scope="row" class="py-2 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                        {{ sub_permission.name }}
                                                    </th>
                                                    <td class="py-2 px-6 text-center">
                                                        <BreezeButton buttonType="danger" @click="deleteSub(index, sub_permission.id)">Delete</BreezeButton>
                                                    </td>
                                                </tr>
                                                <tr class="bg-white border-b text-center" v-else>
                                                    <td colspan="3" class="py-3">No Sub Permissions.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="my-5 border-b border-dashed border-indigo-900"></div>
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- <div class="flex">
                                        <label for="" class="font-sm pr-3">Status</label>
                                        <Toggle v-model="form.status" 
                                                :classes="{
                                                    container: 'inline-block',
                                                    toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                    toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                                    toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                                }
                                        "/>
                                    </div> -->
                                    <div class="flex space-x-2">
                                        <BreezeButton buttonType="gray" :url="route('permissions')">Cancel</BreezeButton>
                                        <BreezeButton type="submit">Save</BreezeButton>
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
import Toggle from '@vueform/toggle'

export default {
    components: {
        Link, Toggle
    },
    data() {
        return {
            sub_permission: '',
            form: {
                permission_id: this.$page.props.permission_id,
                permission: this.$page.props.permission_info.name,
                sub_permission: this.$page.props.sub_permissions,
                add_sub_permission: [],
                delete_sub_permission: []
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('permissions.update'), this.form)
        },
        addSub(){
            if(this.sub_permission){
                this.form.sub_permission.push({'id':'','name':this.sub_permission})
                this.form.add_sub_permission.push({'id':this.form.permission_id,'name':this.sub_permission})
                this.sub_permission = ''
            }
        },
        deleteSub(index, sub_id){
            if(sub_id){
                this.form.delete_sub_permission.push(sub_id)
            }
            this.form.add_sub_permission.forEach((data, data_index)=>{
                if(data.name == this.form.sub_permission[index].name){
                    this.form.add_sub_permission.splice(data_index, 1)
                }
            })
            this.form.sub_permission.splice(index, 1)
        }
    },
}
</script>
