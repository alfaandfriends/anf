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
                                        <h1 class="text-indigo-800 font-bold">Menu Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="menu_label" class="block text-sm font-bold text-gray-700"> label <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="menu_label" id="menu_label" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.menu_label ? 'border-red-300' : 'border-gray-300'" v-model="form.menu_label" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="menu_route" class="block text-sm font-bold text-gray-700"> Route <span class="text-red-500">(required if don't have sub menu)</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="menu_route" id="menu_route" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.menu_route ? 'border-red-300' : 'border-gray-300'" v-model="form.menu_route" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="menu_permission" class="block text-sm font-bold text-gray-700"> Permission <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="menu_permission" id="menu_permission" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.menu_permission ? 'border-red-300' : 'border-gray-300'" v-model="form.menu_permission" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="menu_icon" class="block text-sm font-bold text-gray-700"> Permission <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <textarea name="menu_icon" rows="5" id="menu_icon" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.menu_icon ? 'border-red-300' : 'border-gray-300'" v-model="form.menu_icon" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2">
                                            <label for="" class="block font-bold text-gray-700">Active</label>
                                            <Toggle v-model="form.menu_status" 
                                                :classes="{
                                                    container: 'inline-block',
                                                    toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                    toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                                    toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                                }
                                            "/>
                                        </div>
                                        <div class="flex space-x-2">
                                            <BreezeButton buttonType="gray" :route="route('menus')">Cancel</BreezeButton>
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
    data() {
        return {
            form: {
                menu_label: null,
                menu_route: null,
                menu_icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                menu_permission: null,
                menu_status: true,
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('menus.store_menu'), this.form)
        },
    },
}
</script>
