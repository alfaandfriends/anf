<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Menus" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <input type="hidden" v-model="menu_id">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Sub Menu Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="menu_sub_label" class="block text-sm font-bold text-gray-700"> Label <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="menu_sub_label" id="menu_sub_label" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.menu_sub_label ? 'border-red-300' : 'border-gray-300'" v-model="form.menu_sub_label" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="menu_sub_route" class="block text-sm font-bold text-gray-700"> Route <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="menu_sub_route" id="menu_sub_route" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.menu_sub_route ? 'border-red-300' : 'border-gray-300'" v-model="form.menu_sub_route" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="menu_sub_permission_name" class="block text-sm font-bold text-gray-700"> Permission <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="menu_sub_permission_name" id="menu_sub_permission_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.menu_sub_permission_name ? 'border-red-300' : 'border-gray-300'" v-model="form.menu_sub_permission_name" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2">
                                            <label for="" class="block font-bold text-gray-700">Active</label>
                                            <Toggle v-model="form.menu_sub_status" 
                                                :classes="{
                                                    container: 'inline-block',
                                                    toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                    toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                                    toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                                }
                                            "/>
                                        </div>
                                        <div class="flex space-x-2">
                                            <BreezeButton buttonType="gray" :route="url_redirect">Cancel</BreezeButton>
                                            <BreezeButton type="submit" :disabled="form.processing">Save</BreezeButton>
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
        Toggle, Link
    },
    props: {
        menu_id: String,
        url_redirect: String
    },
    data() {
        return {
            form: {
                url_redirect: this.url_redirect,
                menu_id: this.menu_id,
                menu_sub_label: null,
                menu_sub_route: null,
                menu_sub_status: true,
                menu_sub_permission_name: '',
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('menus.store_sub_menu'), this.form)
        },
    },
}
</script>
