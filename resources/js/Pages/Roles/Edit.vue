<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Roles" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Role
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block lg:w-1/3">
                        <div class="p-6 bg-indigo-100 rounded-md border-b border-gray-200">
                            <form @submit.prevent="submit">
                                <div>
                                    <label for="role">Role</label>
                                    <input type="text" class="w-full px-4 py-1 mt-2 border rounded-md bg-gray-200 cursor-not-allowed" v-model="roles.name" :disabled="true"/>
                                </div>
                                <div v-if="$page.props.errors.name"><span class="text-red-500">{{ $page.props.errors.name }}</span></div>

                                <div class="mt-4">
                                    <label for="role_name">Display Name</label>
                                    <input type="text" class="w-full px-4 py-1 mt-2 border rounded-md" v-model="roles.display_name"
                                           :class="$page.props.errors.display_name ? 'border-1 border-rose-500 focus:outline-none focus:ring-0 focus:border-rose-500' : 'focus:ring-0 focus:border-gray-500'"/>
                                </div>
                                <div v-if="$page.props.errors.display_name"><span class="text-red-500">{{ $page.props.errors.display_name }}</span></div>
                                
                                <div class="flex mt-4">
                                    <label for="" class="font-sm pr-3">Status</label>
                                    <Toggle v-model="roles.status" 
                                            :classes="{
                                                container: 'inline-block',
                                                toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                                toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                            }
                                    "/>
                                </div>
                                <!-- submit -->
                                <div class="flex flex-row-reverse items-center mt-4">
                                    <div class="flex">
                                        <button class="px-6 py-1 text-white bg-green-500 hover:bg-green-600 outline outline-1 outline-offset-2 outline-green-500 hover:outline-green-400 rounded">
                                            Save
                                        </button>
                                    </div>
                                    <div class="flex pr-3">
                                        <Link :href="route('roles')" class="px-6 py-1 text-white bg-gray-500 hover:bg-gray-600 outline outline-1 outline-offset-2 outline-gray-400 hover:outline-gray-500 rounded" as="button">
                                            Cancel
                                        </Link>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
    props: {
        roles: Object
    },
    methods: {
        submit() {
            this.$inertia.post(route('roles.update'), this.roles)
        },
    },
}
</script>
