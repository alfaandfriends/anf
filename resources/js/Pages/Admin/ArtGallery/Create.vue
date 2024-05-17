<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Art Gallery" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Upload Artwork</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="centre" class="block text-sm font-bold text-gray-700"> Student Name <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md.shadow-sm">
                                            <Multiselect 
                                                v-debounce="findStudents"
                                                v-model="form.student_id"
                                                @close="clearStudents"
                                                valueProp="id"
                                                :loading="isLoading"
                                                placeholder="Please enter some keywords"
                                                :options="list.students"
                                                :searchable="true"
                                                noOptionsText="Nothing found"
                                                noResultsText="Nothing found"
                                                :clearOnSelect="true"
                                                :canClear="false"
                                                :canDeselect="false"
                                                :internal-search="false"
                                                trackBy="name"
                                                label="name"
                                                :classes="{
                                                    container: 
                                                        $page.props.errors.student_id ? 
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10':
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-indigo-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
                                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                                                    clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                                                    clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                                    dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                                    dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                                    dropdownHidden: 'hidden',
                                                    options: 'flex flex-col p-0 m-0 list-none w-full',
                                                    optionsTop: 'flex-col-reverse',
                                                    group: 'p-0 m-0',
                                                    groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                                    groupLabelPointable: 'cursor-pointer',
                                                    groupLabelPointed: 'bg-gray-300 text-black-700',
                                                    groupLabelSelected: 'bg-gray-100 text-black',
                                                    groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                                    groupOptions: 'p-0 m-0',
                                                    option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                                    optionPointed: 'text-gray-800 bg-gray-100',
                                                    optionSelected: 'text-white bg-indigo-500',
                                                    optionDisabled: 'text-gray-300 cursor-not-allowed',
                                                    optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                                    optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                                    fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                                    spacer: 'h-9 py-px box-content',
                                                }"
                                            />
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="level" class="block text-sm font-bold text-gray-700"> Level <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="level" id="level" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.level_id ? 'border-red-300' : 'border-gray-300'" v-model="form.level_id" autocomplete="off">
                                                <option value="">Please Select</option>
                                                <option :value="level.id" v-for="(level, index) in list.levels" :key="index">{{ level.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="theme_id" class="block text-sm font-bold text-gray-700"> Theme <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="theme_id" id="theme_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.theme_id ? 'border-red-300' : 'border-gray-300'" v-model="form.theme_id" autocomplete="off" :disabled="disable_class_levels">
                                                <option value="">Please Select</option>
                                                <option :value="theme.id" v-for="theme, index in list.themes" :key="theme.id">{{ theme.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="lesson_id" class="block text-sm font-bold text-gray-700"> Lesson <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="lesson_id" id="lesson_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.lesson_id ? 'border-red-300' : 'border-gray-300'" v-model="form.lesson_id" autocomplete="off">
                                                <option value="">Please Select</option>
                                                <option :value="lesson.id" v-for="lesson, index in list.lessons" :key="lesson.id">{{ lesson.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="activity_id" class="block text-sm font-bold text-gray-700"> Activity <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="activity_id" id="activity_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.activity_id ? 'border-red-300' : 'border-gray-300'" v-model="form.activity_id" autocomplete="off">
                                                <option value="">Please Select</option>
                                                <option :value="activity.id" v-for="activity, index in list.activities" :key="activity.id">{{ activity.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4 space-y-2" v-show="form.artwork.image_url == ''">
                                        <label class="block text-sm text-gray-700 font-bold"> Artwork File </label>
                                        <div class="rounded-md bg-red-100 p-4" v-if="$page.props.errors['artwork.file']">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <ExclamationIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                                                </div>
                                                <div class="ml-3">
                                                    <h3 class="text-sm font-medium text-red-500">File is required!</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                            @change="changeArtwork"
                                            @dragover="dragoverArtWork"
                                            @drop="dropArtwork"
                                        >
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label class="browse text-indigo-400 hover:text-indigo-800 cursor-pointer font-bold">Click here
                                                        <input ref="artwork_file" id="file" class="sr-only" type="file" accept="image/*">
                                                    </label>
                                                    <p class="pl-1">or drag and drop an image</p>
                                                </div>
                                                <p class="text-xs text-gray-500">Image Format : PNG, JPG</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4" v-show="form.artwork.image_url != ''">
                                        <label class="block text-sm text-gray-700 font-bold mb-2"> Artwork File </label>
                                        <div class="flex flex-row justify-start space-x-2">
                                            <div class="flex-column text-center">
                                                <img class="object-scale-down w-full" :src="form.artwork.image_url" alt="">
                                            </div>
                                            <div class="flex-column">
                                                <div class="flex flex-col space-y-1">
                                                    <BreezeButton class="py-1 px-2 bg-blue-500 hover:bg-blue-600 rounded text-white shadow" @click="reselect_image()" title="Reselect an image">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                    </BreezeButton>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                    <div class="flex items-center justify-end">
                                        <div class="flex space-x-2">
                                            <BreezeButton buttonType="gray" :route="route('art_gallery')">Cancel</BreezeButton>
                                            <BreezeButton type="submit">Save</BreezeButton>
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
import Multiselect from '@vueform/multiselect'
import { debounce } from 'vue-debounce'

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

export default {
    components: {
        Head, Link, Multiselect
    },
    data(){
        return{
            data:  {
                type: Object,
                default: () => ({}),
            },
            show_upload: true,
            show_image: false,
            isLoading: false,
            list: {
                students: [],
                levels: this.$page.props.levels,
                themes: [],
                lessons: [],
                activities: []
            },
            form: {
                student_id: '',
                level_id: '',
                theme_id: '',
                lesson_id: '',
                activity_id: '',
                artwork: {
                    image_url: '',
                    file: ''
                }
            }
        }
    },
    watch: {
        'form.level_id': {
            handler(){
                if(this.form.level_id != ''){
                    axios.get(route('art_gallery.get_themes', this.form.level_id))
                    .then((response) => {
                        this.list.themes = response.data
                        this.form.theme_id  =   ''
                        this.form.lesson_id  =   ''
                        this.form.activity_id  =   ''
                    })
                }
            },
            deep: true
        },
        'form.theme_id': {
            handler(){
                if(this.form.level_id != '' && this.form.theme_id != ''){
                    axios.get(route('art_gallery.get_lessons', this.form.theme_id))
                    .then((response) => {
                        this.list.lessons = response.data
                        this.form.lesson_id  =   ''
                        this.form.activity_id  =   ''
                    })
                }
            },
            deep: true
        },
        'form.lesson_id': {
            handler(){
                if(this.form.level_id != '' && this.form.theme_id != '' && this.form.lesson_id != ''){
                    axios.get(route('art_gallery.get_activities', this.form.lesson_id))
                    .then((response) => {
                        this.list.activities = response.data
                        this.form.activity_id  =   ''
                    })
                }
            },
            deep: true
        },
    },
    methods: {
        submit() {
            this.$inertia.post(route('art_gallery.store'), this.form, { preserveState: true})
        },
        clearStudents(){
            this.list.students = []
        },
        findStudents(query){
            debounce(val => '400ms')(10)
            if(query){
                this.isLoading = true
                axios.get(route('students.find_digital_art_students'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.students = res.data
                    this.isLoading = false
                });
            }
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
        changeArtwork({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                this.read(files[0], target)
                .then((data) => {
                    this.form.artwork.image_url =   data.url
                    this.form.artwork.file      =   files[0]
                })
                .catch(this.alert);
            }
        },
        dragoverArtWork(e) {
            e.preventDefault();
        },
        dropArtwork(e) {
            const { files } = e.dataTransfer;
            e.preventDefault();
            if (files && files.length > 0) {
                this.read(files[0], e)
                .then((data) => {
                    this.form.artwork.image_url =   data.url
                    this.form.artwork.file      =   files[0]
                })
                .catch(this.alert);
            }
        },
        reselect_image(){
            this.$refs.artwork_file.value = ''
            this.form.artwork.image_url    =   ''
            this.form.artwork.file    =   ''
        }
    }
}
</script>