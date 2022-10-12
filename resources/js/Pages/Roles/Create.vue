<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import BreezeButton from '@/Components/Button.vue';
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
                        <div class="p-6 bg-indigo-100 rounded-md border-b border-gray-200">
                            <form @submit.prevent="submit">
                                <div>
                                    <label for="role">Role</label>
                                    <input type="text" class="w-full px-4 py-1 mt-2 border rounded-md" v-model="form.role" 
                                           :class="$page.props.errors.role ? 'border-1 border-rose-500 focus:outline-none focus:ring-0 focus:border-rose-500' : 'focus:ring-0 focus:border-gray-500'"/>
                                </div>
                                <div v-if="$page.props.errors.role"><span class="text-red-500">{{ $page.props.errors.role }}</span></div>
                                <div class="mt-4">
                                    <label for="display_name">Display Name</label>
                                    <input type="text" class="w-full px-4 py-1 mt-2 border rounded-md" v-model="form.display_name" 
                                           :class="$page.props.errors.display_name ? 'border-1 border-rose-500 focus:outline-none focus:ring-0 focus:border-rose-500' : 'focus:ring-0 focus:border-gray-500'"/>
                                </div>
                                <div v-if="$page.props.errors.display_name"><span class="text-red-500">{{ $page.props.errors.display_name }}</span></div>

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
                                <!-- submit -->
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
                role: null,
                display_name: null,
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
