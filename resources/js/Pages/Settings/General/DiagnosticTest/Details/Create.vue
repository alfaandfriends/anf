

<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="General Setting" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <TabPage/>
                        <div class="mt-4 bg-white">
                            <div class="flex space-x-2">
                                <div class="overflow-hidden w-1/2">
                                    <form @submit.prevent="submit">
                                        <div class="bg-white px-3 py-2">
                                            <div class="mb-5">
                                                <h1 class="text-indigo-800 font-bold">Diagnostic Test Information</h1>
                                                <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="block text-sm text-gray-700 font-bold">Label<span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text" name="name" id="name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" v-model="form.name" autocomplete="none"/>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="remarks" class="block text-sm text-gray-700 font-bold">Remarks</label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text" name="remarks" id="remarks" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.remarks ? 'border-red-300' : 'border-gray-300'" v-model="form.remarks" autocomplete="none"/>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="category_id" class="block text-sm text-gray-700 font-bold">Category<span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <select name="category_id" id="category_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.category_id ? 'border-red-300' : 'border-gray-300'" v-model="form.category_id" autocomplete="none">
                                                        <option value="" hidden selected>Please select question's category</option>
                                                        <option :value="category.id" v-for="(category, index) in $page.props.diagnostic_test_categories" :key="index">{{ category.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="block text-sm text-gray-700 font-bold">Answer Redirection (Default: No Redirection)</label>
                                                <div class="mt-1 flex rounded-md shadow-sm space-x-2">
                                                    <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.redirect_yes" :class="$page.props.errors.redirect_yes ? 'border-red-300' : 'border-gray-300'" name="" id="">
                                                        <option value="">If Yes, redirect to</option>
                                                        <option :value="dt.id" v-for="dt in $page.props.diagnostic_test_list" :key="dt.id">{{ dt.name }}</option>
                                                    </select>
                                                    <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.redirect_no" :class="$page.props.errors.redirect_no ? 'border-red-300' : 'border-gray-300'" name="" id="">
                                                        <option value="">If No, redirect to</option>
                                                        <option :value="dt.id" v-for="dt in $page.props.diagnostic_test_list" :key="dt.id">{{ dt.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="block text-sm text-gray-700 font-bold">Image<span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                                    @change="change"
                                                    @dragover="dragover"
                                                    @drop="drop"
                                                    v-if="showUpload"
                                                >
                                                    <div class="space-y-1 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <div class="flex text-sm text-gray-600">
                                                            <label class="browse text-indigo-400 hover:text-indigo-800 cursor-pointer font-bold">Click here
                                                                <input ref="inside_image" id="file" class="sr-only" type="file" accept="image/*">
                                                            </label>
                                                            <p class="pl-1">or drag and drop an image</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">Image Format : PNG, JPG</p>
                                                    </div>
                                                </div>
                                                <div class="mt-2 relative group" v-if="showImage">
                                                    <div class="absolute w-full h-full hover:bg-black hover:opacity-75">
                                                        <div class="absolute cursor-pointer top-1/2 left-1/2 -translate-y-2/4 -translate-x-2/4 h-16 w-16 hover:text-red-500 text-red-600 transition ease-in-out hidden hover:-translate-1 hover:scale-110 duration-100 group-hover:block" alt="Remove Image" @click="removeImage">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            <span class="text-white">Remove</span>
                                                        </div>
                                                    </div>
                                                    <img class="rounded w-full" :src="form.image_url" alt="">
                                                </div>
                                            </div>
                                            <div class="flex items-end justify-end space-x-2">
                                                <BreezeButton buttonType="gray" :route="redirect_url">Cancel</BreezeButton>
                                                <BreezeButton type="submit">Save </BreezeButton>
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
        Head, Link, TabGroup, TabList, Tab, TabPanels, TabPanel, ConfirmationModal, TrashIcon, draggable: VueDraggableNext,
    },
    props: {
        redirect_url: String,
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
                name: '',
                remarks: '',
                category_id: '',
                image_url: '',
                image_file: '',
                redirect_yes: '',
                redirect_no: '',
                redirect_url: this.redirect_url ? this.redirect_url : '',
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(route('settings.diagnostic_test.details.store'), this.form, { preserveState: true})
        },
        read(file, event) {
            return new Promise((resolve, reject) => {
                if (!file) {
                    resolve();
                    return;
                }
                if (REGEXP_MIME_TYPE_IMAGES.test(file.type)) {
                    if (URL) {
                        resolve({
                            loaded: true,
                            name: file.name,
                            type: file.type,
                            url: URL.createObjectURL(file),
                        });
                    } else {
                        reject(new Error('Your browser is not supported.'));
                    }
                } else {
                    reject(new Error(`Please select a valid image file.`));
                    // reject(new Error(`Please ${event ? event.type : 'choose'} an image file.`));
                }
            });
        },
        change({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                this.read(files[0], target)
                .then((data) => {
                    this.form.image_url     =   data.url
                    this.form.image_file     =   files
                    this.showUpload     =   false;
                    this.showImage      =   true;
                    this.update(data);
                })
                .catch(this.alert);
            }
        },
        dragover(e) {
            e.preventDefault();
        },
        drop(e) {
            const { files } = e.dataTransfer;
            e.preventDefault();
            if (files && files.length > 0) {
                this.read(files[0], e)
                .then((data) => {
                    this.form.image_url     =   data.url
                    this.form.image_file     =   files
                    this.showUpload     =   false;
                    this.showImage      =   true;
                    this.update(data);
                })
                .catch(this.alert);
            }
        },
        alert(e) {
            window.alert(e && e.message ? e.message : e);
        },
        update(data) {
            Object.assign(this.data, data);
        },
        removeImage(){
            this.form.image_url = ''
            this.showImage      =   false;
            this.showUpload     =   true;
        }
    }

})
</script>
                                