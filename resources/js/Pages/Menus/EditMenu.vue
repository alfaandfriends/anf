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
                                            <label for="menu_label" class="block text-sm font-bold text-gray-700"> Label <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="menu_label" id="menu_label" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.menu_label ? 'border-red-300' : 'border-gray-300'" v-model="form.menu_label" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="have_sub_menu" class="block text-sm font-bold text-gray-700"> Sub Menu </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select class="border-gray-300 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" name="" id="have_sub_menu" v-model="have_sub_menu" @change="resetRoute">
                                                    <option :value="true">Yes</option>
                                                    <option :value="false">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4" v-if="!have_sub_menu">
                                        <div class="mb-4">
                                            <label for="menu_route" class="block text-sm font-bold text-gray-700"> Route </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="menu_route" id="menu_route" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="menu_route_error ? 'border-red-300' : 'border-gray-300'" v-model="form.menu_route" autocomplete="off"/>
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
    props: {
        menus: Object
    },
    data() {
        return {
            have_sub_menu: this.menus.menu_route ? false : true,
            menu_route_error: false,
            form: {
                menu_id: this.menus.id,
                menu_label: this.menus.menu_label,
                menu_route: this.menus.menu_route,
                menu_icon: this.menus.menu_icon,
                menu_permission: this.menus.permission_name,
                menu_status: this.menus.menu_status,
            },
        }
    },
    watch:{
        'form.menu_route': {
            handler(){
                if(this.form.menu_route != ''){
                    this.menu_route_error = false
                }
            }
        }
    },
    methods: {
        submit() {
            if(this.have_sub_menu || !this.have_sub_menu && this.form.menu_route != ''){
                this.$inertia.post(route('menus.update_menu'), this.form)
            }
            else{
                this.menu_route_error = true
            }
        },
        resetRoute(){
            this.form.menu_route = ''
        }
    },
}
</script>
