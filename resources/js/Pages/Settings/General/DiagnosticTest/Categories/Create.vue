

<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="General Setting" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                General Setting
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <TabPage/>
                        <div class="mt-4 bg-white">
                            <div class="overflow-hidden w-1/2">
                                <form @submit.prevent="submit">
                                    <div class="bg-white px-4 py-4">
                                        <div class="mb-5">
                                            <h1 class="text-indigo-800 font-bold">Categories</h1>
                                            <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category_name" class="block text-sm text-gray-700 font-bold">Category name<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="category_name" id="category_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.category_name ? 'border-red-300' : 'border-gray-300'" v-model="form.category_name" autocomplete="none"/>
                                            </div>
                                        </div>
                                        <div class="flex items-end justify-end space-x-2">
                                            <button type="submit" class="py-2 px-6 border border-transparent shadow-sm text-sm rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 select-none">Save </button>
                                            <Link :href="route('settings.diagnostic_test.details', {'dt_id': this.diagnostic_test_id})" class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 select-none">Cancel</Link>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { TrashIcon } from '@heroicons/vue/solid'
import { VueDraggableNext } from 'vue-draggable-next'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import TabPage from '@/Pages/Settings/General/Tab.vue'

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

export default defineComponent({
    components: {
        Head, Link, TabGroup, TabList, Tab, TabPanels, TabPanel, ConfirmationModal, TrashIcon, draggable: VueDraggableNext
    },
    props: {
        diagnostic_test_id: String
    },
    data() {
        return {
            data:  {
                type: Object,
                default: () => ({}),
            },
            enabled: true,
            isOpen: false,
            showUpload: true,
            showImage: false,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
            dragging: true,
            dtList: this.$page.props.diagnostic_test_list  ? this.$page.props.diagnostic_test_list  : [],
            form: {
                dt_id: this.diagnostic_test_id ? this.diagnostic_test_id : '',
                category_name: '',
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(route('settings.diagnostic_test.categories.store'), this.form, { preserveState: true})
        }
    }

})
</script>
                                