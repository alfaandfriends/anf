<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="General Setting" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <div class="px-4 py-5 bg-indigo-100 space-y-6 sm:p-6 h-full">
                    <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                        <form @submit.prevent="submit">
                            <div class="sm:row-span-3 space-y-2">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Categories</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category_name" class="block text-sm text-gray-700 font-bold">Category name<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="category_name" id="category_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.category_name ? 'border-red-300' : 'border-gray-300'" v-model="form.category_name" autocomplete="off"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="flex items-end justify-end space-x-2">
                                        <BreezeButton buttonType="gray" :route="route('dt.settings.details', {'dt_id': $page.props.category_info.dt_id})">Cancel</BreezeButton>
                                        <BreezeButton type="submit">Save </BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        category_info: Object
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
                category_id: this.category_info ? this.category_info.id : '',
                dt_id: this.category_info ? this.category_info.dt_id : '',
                category_name: this.category_info ? this.category_info.name : '',
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(route('dt.settings.categories.update'), this.form, { preserveState: true})
        }
    }

})
</script>
                                