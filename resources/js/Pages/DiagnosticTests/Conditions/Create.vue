

<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <div class="mt-4 bg-white">
                            <div class="flex space-x-2">
                                <div class="overflow-hidden w-1/2">
                                    <form @submit.prevent="submit">
                                        <div class="bg-white px-3 py-2">
                                            <div class="mb-5">
                                                <h1 class="text-indigo-800 font-bold">Conditions</h1>
                                                <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="score" class="block text-sm text-gray-700 font-bold">Score less than<span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text" name="score" id="score" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.score ? 'border-red-300' : 'border-gray-300'" v-model="form.score" autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="message" class="block text-sm text-gray-700 font-bold">Message<span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <textarea type="text" name="message" id="message" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.message ? 'border-red-300' : 'border-gray-300'" v-model="form.message" autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="flex items-end justify-end space-x-2">
                                                <BreezeButton buttonType="gray" :route="route('dt.settings.details', {'dt_id': this.diagnostic_test_id})">Cancel</BreezeButton>
                                                <BreezeButton type="submit">Save</BreezeButton>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
                score: '',
                message: '',
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(route('dt.settings.conditions.store'), this.form, { preserveState: true})
        }
    }

})
</script>
                                