<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Role Assigments</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="flex flex-col justify-left">
                                            <div class="form-check" v-for="role in roles" :key="role.id">
                                                <input :id="role.id" class="form-check-input h-5 w-5 border border-gray-300 rounded-sm bg-white hover:bg-white focus:ring-transparent text-indigo-500 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                        type="checkbox" 
                                                        :checked="user_roles[role.id]"
                                                        :value="role.id"
                                                        v-model="selected_roles"
                                                >
                                                <label :for="role.id" class="form-check-label inline-block text-gray-800 select-none text-lg">
                                                    {{ role.display_name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                    <div class="flex flex-row-reverse items-center">
                                        <div class="flex space-x-2">
                                            <BreezeButton :buttonType="'gray'" :route="route('users')">Cancel</BreezeButton>
                                            <BreezeButton type="submit">Save</BreezeButton>
                                        </div>
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
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        Head, Link, Multiselect,
    },
    props: {
        user_id: String,
        roles: Object,
        user_roles: Object,
    },
    created(){
        var selected_roles      = this.selected_roles
        Object.keys(this.user_roles).forEach(function(role_id){
            selected_roles.push(parseInt(role_id))
        })
    },
    data(){
        return{
            selected_roles: []
        }
    },
    methods: {
        submit(){
            this.$inertia.post(this.route('users.manage_roles.store'), {'user_id': this.user_id, 'selected_roles': this.selected_roles});
        },
    }
}
</script>
