<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-indigo-100 space-y-6 sm:p-6 h-full">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3 space-y-2">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <!-- <div class="mb-3">
                                        <label for="name" class="block text-sm text-gray-700 font-bold">Label<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="name" id="name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" v-model="form.name" autocomplete="off"/>
                                        </div>
                                    </div> -->
                                    <div class="mb-3">
                                        <label for="category_id" class="block text-sm text-gray-700 font-bold">Category<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="category_id" id="category_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.category_id ? 'border-red-300' : 'border-gray-300'" v-model="form.category_id" autocomplete="off">
                                                <option value="" selected>Please select question's category</option>
                                                <option :value="category.id" v-for="(category, index) in $page.props.diagnostic_test_categories" :key="index">{{ category.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="block text-sm text-gray-700 font-bold">Redirection (Correct)</label>
                                        <div class="mt-1 flex rounded-md shadow-sm space-x-2">
                                            <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.redirect_yes" :class="$page.props.errors.redirect_yes ? 'border-red-300' : 'border-gray-300'" name="" id="">
                                                <option value="">No redirection</option>
                                                <option :value="dt.id" v-for="dt in $page.props.diagnostic_test_list" :key="dt.id">{{ dt.question }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="block text-sm text-gray-700 font-bold">Redirection (Wrong)</label>
                                        <div class="mt-1 flex rounded-md shadow-sm space-x-2">
                                            <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.redirect_no" :class="$page.props.errors.redirect_no ? 'border-red-300' : 'border-gray-300'" name="" id="">
                                                <option value="">No redirection</option>
                                                <option :value="dt.id" v-for="dt in $page.props.diagnostic_test_list" :key="dt.id">{{ dt.question }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Questions</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="mb-5">
                                        <div class="bg-indigo-100 border-t-4 border-indigo-500 rounded-b text-indigo-900 px-4 py-3 shadow-md" role="alert" v-if="form.question_type == 4">
                                            <div class="flex">
                                                <div class="py-1">
                                                    <svg class="fill-current h-6 w-6 text-indigo-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold">In the question's input field, please wrap the answer keyword with [ ] for system to automatically replace the answer to blank spaces. </p>
                                                    <p class="text-indigo-600 font-semibold">ALFA like to [play] football.</p>
                                                    <br>
                                                    <p class="font-bold">Use | to set multiple correct answers.</p>
                                                    <p class="text-indigo-600 font-semibold">ALFA like to [eat|drink|sleep].</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="question_type" class="block text-sm text-gray-700 font-bold">Question Type<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="question_type" id="question_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.question_type ? 'border-red-300' : 'border-gray-300'" v-model="form.question_type" autocomplete="off">
                                                <option value="" selected>Please select question's type</option>
                                                <option :value="type.id" v-for="(type, index) in question_types" :key="index">{{ type.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="question" class="block text-sm text-gray-700 font-bold">Question<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <textarea id="question" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.question ? 'border-red-300' : 'border-gray-300'" v-model="form.question" autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="remarks" class="block text-sm text-gray-700 font-bold">Remarks / Additional notes</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="remarks" id="remarks" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.remarks ? 'border-red-300' : 'border-gray-300'" v-model="form.remarks" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="block text-sm text-gray-700 font-bold">Question Image</label>
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
                                        <div class="w-1/4 relative group mt-2" v-if="showImage">
                                            <div class="absolute w-full h-full hover:bg-black hover:opacity-75 hidden group-hover:block">
                                                <div class="absolute cursor-pointer top-1/2 left-1/2 -translate-y-2/4 -translate-x-2/4 h-16 w-16 hover:text-red-500 text-red-600 transition ease-in-out hover:-translate-1 hover:scale-110 duration-100" alt="Remove Image" @click="removeImage">
                                                    <div class="pl-[0.65rem]">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </div>
                                                    <span class="text-white">Remove</span>
                                                </div>
                                            </div>
                                            <img class="rounded w-full" :src="form.image_url" alt="">
                                        </div>
                                    </div>
                                </div>
                                <SingleChoice v-if="form.question_type == 1" @receivedData="appendToForm" :prop_answers="[]" action="create"></SingleChoice>
                                <MultipleChoices v-if="form.question_type == 2" @receivedData="appendToForm" :prop_answers="[]" action="create"></MultipleChoices>
                                <MatrixSorting v-if="form.question_type == 3" @receivedData="appendToForm" :prop_answers="[]" action="create"></MatrixSorting>
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="flex items-end justify-end space-x-2">
                                        <BreezeButton buttonType="gray" :route="redirect_url">Cancel</BreezeButton>
                                        <BreezeButton @click="submit">Save </BreezeButton>
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
import SingleChoice from '@/Pages/DiagnosticTests/AnswerTemplates/SingleChoice.vue'
import MultipleChoices from '@/Pages/DiagnosticTests/AnswerTemplates/MultipleChoices.vue'
import MatrixSorting from '@/Pages/DiagnosticTests/AnswerTemplates/MatrixSorting.vue'

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

export default defineComponent({
    components: {
        Head, Link, TabGroup, TabList, Tab, TabPanels, TabPanel, ConfirmationModal, TrashIcon, draggable: VueDraggableNext, SingleChoice, MultipleChoices, MatrixSorting
    },
    props: {
        redirect_url: String,
        diagnostic_test_id: String,
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
            question_types: [{
                id: 1,
                name: 'Single Choice'
            },{
                id: 2,
                name: 'Multiple Choices'
            },
            // {
            //     id: 3,
            //     name: 'Matrix Sorting'
            // },
            {
                id: 4,
                name: 'Fill in the Blank'
            }],
            form: {
                dt_id: this.diagnostic_test_id ? this.diagnostic_test_id : '',
                redirect_url: this.redirect_url ? this.redirect_url : '',
                category_id: '',
                redirect_yes: '',
                redirect_no: '',
                question_type: '',
                question: '',
                remarks: '',
                image_url: '',
                image_file: '',
                question_answer_data: []
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(route('dt.settings.details.store'), this.form, { preserveState: true})
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
        appendToForm(data){
            this.form.question_answer_data = data
        }
    }

})
</script>
                                