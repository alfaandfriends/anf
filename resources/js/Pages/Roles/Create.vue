<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Roles" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Role
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block lg:w-1/3">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <form @submit.prevent="submit">
                                <div>
                                    <label for="role">Role</label>
                                    <input type="text" class="w-full px-4 py-2 mt-2 border rounded-md" v-model="form.role" 
                                           :class="$page.props.errors.role ? 'border-1 border-rose-500 focus:outline-none focus:ring-0 focus:border-rose-500' : 'focus:ring-0 focus:border-gray-500'"/>
                                </div>
                                <div v-if="$page.props.errors.role"><span class="text-red-500">{{ $page.props.errors.role }}</span></div>
                                <div class="mt-4">
                                    <label for="role_name">Display Name</label>
                                    <input type="text" class="w-full px-4 py-2 mt-2 border rounded-md" v-model="form.role_name" 
                                           :class="$page.props.errors.role_name ? 'border-1 border-rose-500 focus:outline-none focus:ring-0 focus:border-rose-500' : 'focus:ring-0 focus:border-gray-500'"/>
                                </div>
                                <div v-if="$page.props.errors.role_name"><span class="text-red-500">{{ $page.props.errors.role_name }}</span></div>

                                <!-- submit -->
                                <div class="flex items-center mt-4">
                                    <div class="flex pr-3">
                                        <a :href="route('roles')" class="px-6 py-2 text-white bg-gray-500 hover:bg-gray-600 outline outline-1 outline-offset-2 outline-gray-400 hover:outline-gray-500 rounded" as="button">
                                            Cancel
                                        </a>
                                    </div>
                                    <div class="flex">
                                        <button :disabled="form.processing" class="px-6 py-2 text-white bg-green-500 hover:bg-green-600 outline outline-1 outline-offset-2 outline-green-500 hover:outline-green-400 rounded">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';

export default {
    data() {
        return {
            form: {
                role: null,
                role_name: null,
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post('/roles/store', this.form)
        },
    },
}
</script>
