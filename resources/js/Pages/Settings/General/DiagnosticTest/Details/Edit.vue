

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
                        <div class="flex mt-4 bg-white px-1 rounded">
                            <div class="overflow-hidden w-1/2 p-4">
                                <div class="flex justify-between border-b border-dashed border-indigo-900 mt-1 items-center mb-4">
                                    <h1 class="text-indigo-800 font-bold">Questions</h1>
                                    <div class="flex justify-start mb-2">
                                        <BreezeButton :route="route('settings.diagnostic_test.details.create', {'dt_id': diagnostic_test_info.dt_id})">
                                            New Question
                                        </BreezeButton>
                                    </div>
                                </div>
                                <draggable class="w-full" v-model="dtList" v-if="dtList.length > 0" @change="updateSorting">
                                    <div class="mb-1" v-for="(element, index) in dtList" :key="index">
                                        <div class="flex">
                                            <div class="cursor-pointer w-full flex justify-between list-group-item bg-indigo-200 py-1 px-5 text-left" :class="showdtDetails ? 'rounded-tl' : 'rounded-l'" @click="dtEdit(element.id)">
                                                {{ (index+1) + '. ' + element.name }}
                                            </div>
                                            <div class="cursor-pointer p-1 bg-red-500 hover:bg-red-700" :class="showdtDetails ? 'rounded-tr' : 'rounded-r'" @click="dtDelete(element.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 px-2 py-2" v-if="element.id == test_id && showdtDetails">
                                            <form @submit.prevent="submit">
                                                <div class="bg-gry-100 px-3 py-2">
                                                    <div class="mb-5">
                                                        <h1 class="text-indigo-800 font-bold">Diagnostic Test Information</h1>
                                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="block text-sm text-gray-700 font-bold">Title<span class="text-red-500">*</span></label>
                                                        <div class="mt-1 flex rounded-md shadow-sm">
                                                            <input type="text" name="name" id="name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" v-model="form.name" autocomplete="off"/>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="remarks" class="block text-sm text-gray-700 font-bold">Remarks</label>
                                                        <div class="mt-1 flex rounded-md shadow-sm">
                                                            <input type="text" name="remarks" id="remarks" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.remarks ? 'border-red-300' : 'border-gray-300'" v-model="form.remarks" autocomplete="off"/>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="category_id" class="block text-sm text-gray-700 font-bold">Category<span class="text-red-500">*</span></label>
                                                        <div class="mt-1 flex rounded-md shadow-sm">
                                                            <select name="category_id" id="category_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.category_id ? 'border-red-300' : 'border-gray-300'" v-model="form.category_id" autocomplete="off">
                                                                <option value="" hidden selected>Please select question's category</option>
                                                                <option :value="category.id" v-for="(category, index) in $page.props.diagnostic_test_categories" :key="index">{{ category.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="block text-sm text-gray-700 font-bold">Answer Redirection (Default: No Redirection)</label>
                                                        <div class="mt-1 flex rounded-md shadow-sm space-x-2">
                                                            <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.redirect_yes" :class="$page.props.errors.redirect_yes ? 'border-red-300' : 'border-gray-300'" name="" id="">
                                                                <option :value="null">If Yes, redirect to</option>
                                                                <option :value="dt.id" v-for="dt in $page.props.diagnostic_test_list" :key="dt.id">{{ dt.name }}</option>
                                                            </select>
                                                            <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.redirect_no" :class="$page.props.errors.redirect_no ? 'border-red-300' : 'border-gray-300'" name="" id="">
                                                                <option :value="null">If No, redirect to</option>
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
                                                            <img class="rounded w-full" :src="form.image_url != '' ? form.image_url : '/storage/'+diagnostic_test_info.image_location" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="flex items-end justify-end space-x-2">
                                                        <button type="submit" class="py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 select-none">Save </button>
                                                        <!-- <Link :href="route('settings.diagnostic_test')" class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 select-none">Cancel</Link> -->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </draggable>
                                <div v-else class="flex text-center p-6 border-2 rounded text-red-500 border-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="pl-2">No record found for diagnostic test.</span>
                                </div>
                            </div>
                            <div class="overflow-hidden w-1/2 p-4">
                                <div class="flex justify-between border-b border-dashed border-indigo-900 mt-1 items-center mb-4">
                                    <h1 class="text-indigo-800 font-bold">Categories</h1>
                                    <div class="flex justify-start mb-2">
                                        <BreezeButton :route="route('settings.diagnostic_test.categories.create', {'dt_id': $page.props.dt_id})">
                                            <!-- <div class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="pl-2">Add</span> 
                                            </div> -->
                                            New Category
                                        </BreezeButton>
                                    </div>
                                </div>
                                <div class="space-y-6 pb-8">
                                    <template v-if="$page.props.diagnostic_test_categories.length > 0">
                                        <div class="flex flex-col">
                                            <ul class="bg-white rounded-lg text-gray-900 w-full">
                                                <li class="flex justify-between py-2 border-b border-gray-200 w-full rounded-t-lg items-center" v-for="(category, index) in $page.props.diagnostic_test_categories" :key="category.id">
                                                    <span>{{ index + 1 }}. {{ category.name }}</span>
                                                    <div class="flex space-x-1">
                                                        <div class="rounded bg-yellow-500 hover:bg-yellow-700 p-1 text-white cursor-pointer shadow-md">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" @click="categoriesEdit(category.id)">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                            </svg>
                                                        </div>
                                                        <div class="rounded bg-red-500 hover:bg-red-700 p-1 text-white cursor-pointer shadow-md" @click="categoriesDelete(category.id)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex text-center p-6 border-2 rounded text-red-500 border-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="pl-2">No categories found for diagnostic test.</span>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-indigo-900 mt-1 items-center mb-4">
                                    <h1 class="text-indigo-800 font-bold">Conditions</h1>
                                    <div class="flex justify-start mb-2">
                                        <BreezeButton :href="route('settings.diagnostic_test.conditions.create', {'dt_id': $page.props.dt_id})">
                                            New Condition
                                        </BreezeButton>
                                    </div>
                                </div>
                                <div class="space-y-6 pb-6">
                                    <template v-if="$page.props.diagnostic_test_conditions.length > 0">
                                        <div class="flex items-center" v-for="(condition, index) in $page.props.diagnostic_test_conditions" :key="condition.id">
                                            <span>{{ index + 1 }}. </span>
                                            <div class="flex flex-row justify-between pl-3">
                                                <div class="flex flex-col">
                                                    <span class="underline font-bold">Final score lower than {{ condition.score_capped }}</span>
                                                    <span class="text-sm italic text-blue-900">{{ condition.message }}</span>
                                                </div>
                                                <div class="flex flex-col space-y-1 mx-2">
                                                    <div class="rounded bg-yellow-500 hover:bg-yellow-700 p-1 text-white cursor-pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" @click="conditionEdit(condition.id)">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </div>
                                                    <div class="rounded bg-red-500 hover:bg-red-700 p-1 text-white cursor-pointer" @click="conditionDelete(condition.id)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex text-center p-6 border-2 rounded text-red-500 border-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="pl-2">No condition found for diagnostic test.</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ConfirmationModal 
            :show="isOpen" 
            @close="isOpen = false"
            confirmationAlert="danger"
            :confirmationTitle="confirmationTitle"
            :confirmationText="confirmationText"
            :confirmationButton="confirmationButton"
            :confirmationMethod="confirmationMethod"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        >
        </ConfirmationModal>
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
    props:{
        dt_id: String,
        test_id: String,
        diagnostic_test_info: Object,
        redirect_url: String
    },
    data() {
        return {
            data:  {
                type: Object,
                default: () => ({}),
            },
            enabled: true,
            isOpen: false,
            showdtDetails: true,
            showUpload: false,
            showImage: true,
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
                dt_id: this.dt_id ? this.dt_id : '',
                id: this.diagnostic_test_info ? this.diagnostic_test_info.id : '',
                name: this.diagnostic_test_info ? this.diagnostic_test_info.name : '',
                remarks: this.diagnostic_test_info ? this.diagnostic_test_info.remarks : '',
                category_id: this.diagnostic_test_info ? this.diagnostic_test_info.category_id : '',
                image_url: '',
                image_file: '',
                redirect_yes: this.diagnostic_test_info ? this.diagnostic_test_info.redirect_yes_id : '',
                redirect_no: this.diagnostic_test_info ? this.diagnostic_test_info.redirect_no_id : '',
                redirect_url: this.redirect_url ? this.redirect_url : '',
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(route('settings.diagnostic_test.details.update'), this.form, { preserveState: true})
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
        },
        blobToFile(blob, fileName){
            blob.lastModifiedDate = new Date();
            blob.name = fileName;
            return blob;
        },
        dtEdit(test_id){
            if(this.showdtDetails && this.test_id == test_id){
                this.showdtDetails = false
            }
            else if(!this.showdtDetails && this.test_id != '' && this.test_id == test_id){
                this.showdtDetails = true
            }
            else{
                this.$inertia.get(route('settings.diagnostic_test.details.edit'), {'test_id': test_id, 'dt_id': this.diagnostic_test_info.dt_id, 'redirect_url': this.redirect_url}, {preserveScroll: true,})
            }
        },
        dtDelete(test_id){
            this.confirmationTitle="Delete Diagnostic Test Item"
            this.confirmationText="Are you sure want to delete this item?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.diagnostic_test.details.destroy'
            this.confirmationData = test_id
            this.isOpen = true
        },
        updateSorting(){
            this.$inertia.post(route('settings.diagnostic_test.details.sort'), {'sorted_list': this.dtList}, {preserveScroll: true})
        },
        conditionEdit(condition_id){
            this.$inertia.get(route('settings.diagnostic_test.conditions.edit'), {'condition_id': condition_id}, {preserveScroll: true})
        },
        conditionDelete(condition_id){
            this.confirmationTitle="Delete Diagnostic Test Condition"
            this.confirmationText="Are you sure want to delete this condition?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.diagnostic_test.conditions.destroy'
            this.confirmationData = condition_id
            this.isOpen = true
        },
        categoriesEdit(category_id){
            this.$inertia.get(route('settings.diagnostic_test.categories.edit'), {'category_id': category_id}, {preserveScroll: true})
        },
        categoriesDelete(category_id){
            this.confirmationTitle="Delete Diagnostic Test Category"
            this.confirmationText="Are you sure want to delete this category?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.diagnostic_test.categories.destroy'
            this.confirmationData = category_id
            this.isOpen = true
        }
    }

})
</script>
                                