<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Roles" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <form @submit.prevent="submit">
                            <nav class="text-sm font-medium text-gray-700">
                                <div class="flex items-center border border-red-500 py-3 px-4" v-if="!$page.props.permissions">
                                    <span class="mr-2">No permission added.</span>
                                </div>
                                <div v-else v-for="permission, index in $page.props.permissions">
                                    <div class="flex" :class="expandAccordion && index === selected ? 'bg-indigo-400 text-gray-200' : 'bg-indigo-300 hover:bg-indigo-400 text-gray-800 hover:text-gray-200'">
                                        <div class="flex flex-1 space-x-2 items-center px-4 py-1 transition cursor-pointer group border border-indigo-200 border-r-0 relative" role="button">
                                            <input :id="permission.id" class="h-4 w-4 border border-gray-300 rounded-sm bg-white focus:ring-offset-0 focus:ring-0 checked:bg-gray focus:bg-white transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                    type="checkbox" 
                                                    :value="permission.id"
                                                    @click="selectAll(index, permission.id, $event)"
                                                    v-model="selected_permissions"
                                            >
                                            <div class="flex items-center justify-start grow" @click="toggleMenu(index)">
                                                <span class="select-none">{{ permission.name }}</span> 
                                                <ChevronRightIcon :class="{ 'rotate-90': expandAccordion && index === selected }" class="shrink-0 w-4 h-4 ml-2 transition transform"></ChevronRightIcon>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col py-3 px-3 border-x border-indigo-200" v-if="expandAccordion && index === selected">
                                        <div v-if="permission.permission_sub.length < 1">
                                            <span>No sub permissions.</span>
                                        </div>
                                        <div v-else class="flex flex-col">
                                            <ul class="list-none items-center translate-x-4">
                                                <li class="mb-1" v-for="sub_permission, index in permission.permission_sub">
                                                    <div class="flex">
                                                        <input :id="sub_permission.id" class="h-4 w-4 border border-gray-300 rounded-sm bg-white focus:ring-offset-0 focus:ring-0 checked:bg-gray focus:bg-white transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                            type="checkbox" 
                                                            :value="sub_permission.id"
                                                            v-model="selected_permissions"
                                                        >
                                                        <label :for="sub_permission.id">{{ sub_permission.name }}</label>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="flex space-x-6">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                            <!-- <div class="flex justify-left p-3">
                                <div class="">
                                    <div class="form-check" v-for="permission in permissions" :key="permission.id">
                                        <input :id="permission.id" class="h-4 w-4 border border-gray-300 rounded-sm bg-white focus:ring-offset-0 focus:ring-0 checked:bg-gray focus:bg-white transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                type="checkbox" 
                                                :value="permission.id"
                                                v-model="selected_permissions"
                                        >
                                        <label :for="permission.id" class="form-check-label inline-block text-gray-800 select-none text-lg">
                                            {{ permission.name }}
                                        </label>
                                    </div>
                                </div>
                            </div> -->
                            <div class="flex space-x-2 p-3">
                                <BreezeButton buttonType="gray" :route="route('roles')">Cancel</BreezeButton>
                                <BreezeButton type="submit">Save</BreezeButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, ChevronRightIcon,
        Head, Link
    },
    props: {
        role_id: String,
        permissions: Object,
        role_permissions: Object
    },
    created(){
        var selected_permissions = this.selected_permissions
        Object.keys(this.role_permissions).forEach(function(key){
            selected_permissions.push(parseInt(key))
        })
    },
    data(){
        return{
            expandAccordion: false,
            selected_permissions: [],
            selected: '',
        }
    },
    methods: {
        toggleMenu (item) {
            item == this.selected ? this.expandAccordion = !this.expandAccordion : this.expandAccordion = true
            this.selected = item
        },
        submit(){
            this.$inertia.post(this.route('roles.assign_permissions.store'), {
                'role_id': this.role_id, 
                'selected_permissions': this.selected_permissions
            });
        },
        selectAll(index, permission_id, event){
            this.expandAccordion = true
            this.selected = index
            if (event.target.checked) {
                this.selected_permissions.push(this.$page.props.permissions[index].id)
                this.$page.props.permissions[index].permission_sub.forEach((permission_sub) => {
                    this.selected_permissions.push(permission_sub.id)
                })
            }
            else{
                this.selected_permissions.forEach((selected_permission, index)=>{
                    if(selected_permission == permission_id){
                        this.selected_permissions.splice(index, 1)
                    }
                })
                
                this.$page.props.permissions[index].permission_sub.forEach((permission_sub)=>{
                    this.selected_permissions.forEach((selected_permissions, index)=>{
                        if(selected_permissions == permission_sub.id){
                            this.selected_permissions.splice(index, 1)
                        }
                    })
                })
            }
        }
    }
}
</script>
