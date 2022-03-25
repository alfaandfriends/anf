<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Menus" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Sub Menu
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block lg:w-1/3">
                        <div class="p-6 bg-indigo-100 rounded-md border-b border-gray-200">
                            <form @submit.prevent="submit">
                                <input type="hidden" v-model="menu_id">
                                <div>
                                    <label for="role">Sub Menu Label<span class="text-red-500">*</span></label>
                                    <input type="text" class="w-full px-4 py-1 mt-2 border rounded-md" v-model="form.menu_sub_label" 
                                           :class="$page.props.errors.menu_sub_label ? 'border-1 border-rose-500 focus:outline-none focus:ring-0 focus:border-rose-500' : 'focus:ring-0 focus:border-gray-500'"/>
                                </div>
                                <div v-if="$page.props.errors.menu_sub_label"><span class="text-red-500">{{ $page.props.errors.menu_sub_label }}</span></div>
                                <div class="mt-3">
                                    <label for="role_name">Route</label>
                                    <input type="text" class="w-full px-4 py-1 mt-2 border rounded-md" v-model="form.menu_sub_route" 
                                           :class="$page.props.errors.menu_sub_route ? 'border-1 border-rose-500 focus:outline-none focus:ring-0 focus:border-rose-500' : 'focus:ring-0 focus:border-gray-500'"/>
                                </div>
                                <div class="mt-3">
                                    <label for="" class="font-sm pr-3">Status</label>
                                    <Toggle v-model="form.menu_sub_status" 
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
                                        <button :disabled="form.processing" class="px-6 py-1 text-white bg-green-500 hover:bg-green-600 outline outline-1 outline-offset-2 outline-green-500 hover:outline-green-400 rounded">
                                            Save
                                        </button>
                                    </div>
                                    <div class="flex pr-3">
                                        <Link :href="url_redirect" class="px-6 py-1 text-white bg-gray-500 hover:bg-gray-600 outline outline-1 outline-offset-2 outline-gray-400 hover:outline-gray-500 rounded" as="button">
                                            Cancel
                                        </Link>
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
import { Head, Link } from '@inertiajs/inertia-vue3';
import Toggle from '@vueform/toggle'

export default { 
    components: {
        Toggle, Link
    },
    props: {
        sub_menus: Object,
        url_redirect: String
    },
    data() {
        return {
            form: {
                url_redirect: this.url_redirect,
                menu_id: this.sub_menus.id,
                menu_sub_label: this.sub_menus.menu_sub_label,
                menu_sub_route: this.sub_menus.menu_sub_route,
                menu_sub_status: this.sub_menus.menu_sub_status,
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('menus.update_sub_menu'), this.form)
        },
    },
}
</script>
