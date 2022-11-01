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
                            <div class="flex justify-left p-3">
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
                            </div>
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
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
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
            selected_permissions: []
        }
    },
    methods: {
        submit(){
            this.$inertia.post(this.route('roles.assign_permissions.store'), {'role_id': this.role_id, 'selected_permissions': this.selected_permissions});
        }
    }
}
</script>
