<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Roles" />

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
                                        <h1 class="text-indigo-800 font-bold">Permission Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="display_name" class="block text-sm font-bold text-gray-700">Display Name</label>
                                            <input type="text" class="mt-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.display_name" 
                                                :class="$page.props.errors.display_name ? 'border-red-300' : 'border-gray-300'"/>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="role" class="block text-sm font-bold text-gray-700">Role</label>
                                            <input type="text" class="mt-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.role" 
                                                :class="$page.props.errors.role ? 'border-red-300' : 'border-gray-300'"/>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="display_name" class="block text-sm font-bold text-gray-700">Role Group</label>
                                            <select name="" id="" class="mt-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.role_group ? 'border-red-300' : 'border-gray-300'" v-model="form.role_group">
                                                <option :value="role_group.id" v-for="(role_group, index) in $page.props.role_groups" :key="role_group.id">{{ role_group.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                    <div class="flex justify-between mt-4 items-center">
                                        <div class="">
                                            <label for="" class="font-sm pr-3">Status</label>
                                            <Toggle v-model="form.status" 
                                                    :classes="{
                                                        container: 'inline-block',
                                                        toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                        toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                                        toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                                    }
                                            "/>
                                        </div>
                                        <div class="flex flex-row-reverse items-center">
                                            <div class="flex space-x-2">
                                                <BreezeButton buttonType="gray" :route="route('roles')">
                                                    Cancel
                                                </BreezeButton>
                                                <BreezeButton type="submit" :disabled="form.processing" >
                                                    Save
                                                </BreezeButton>
                                            </div>
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
import { Head, Link } from '@inertiajs/inertia-vue3';
import Toggle from '@vueform/toggle'

export default {
    components: {
        Link, Toggle
    },
    data() {
        return {
            form: {
                status: true,
                role: '',
                display_name: '',
                role_group: 1,
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('roles.store'), this.form)
        },
    },
}
</script>
