<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Assign Roles to User
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <form @submit.prevent="submit">
                            <div class="flex justify-left p-3">
                                <div class="">
                                    <div class="form-check" v-for="role in roles" :key="role.id">
                                        <input :id="role.id" class="form-check-input h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-indigo-600 focus:ring-transparent transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
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
                            <div class="flex p-3">
                                <div class="pr-1">
                                    <button class="py-1 px-4 bg-green-500 rounded text-white text-md font-bold border border-green-600 hover:bg-green-600">Save</button>
                                </div>
                                <div class="">
                                    <Link :href="route('users')" class="py-1 px-4 bg-gray-400 rounded text-white text-md font-bold border border-gray-500 hover:bg-gray-500" as="button">Cancel</Link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        Head, Link
    },
    props: {
        user_id: String,
        roles: Object,
        user_roles: Object
    },
    created(){
        var selected_roles = this.selected_roles
        Object.keys(this.user_roles).forEach(function(key){
            selected_roles.push(parseInt(key))
        })
    },
    data(){
        return{
            selected_roles: []
        }
    },
    methods: {
        submit(){
            this.$inertia.post(this.route('users.assign_roles.store'), {'user_id': this.user_id, 'selected_roles': this.selected_roles});
        }
    }
}
</script>
