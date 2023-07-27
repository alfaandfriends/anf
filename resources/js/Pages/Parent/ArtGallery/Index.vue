
<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import ListBox from '@/Components/ListBox.vue';
import SimpleModal from '@/Components/SimpleModal.vue';
import BreezeButton from '@/Components/Button.vue';
import { ref } from 'vue';

const showUploadForm = ref(false);

const images = ref([
    { url: 'https://placehold.co/200x200' },
    { url: 'https://placehold.co/200x200' },
    { url: 'https://placehold.co/200x200' },
    { url: 'https://placehold.co/200x200' },
    { url: 'https://placehold.co/200x200' },
    { url: 'https://placehold.co/200x200' },
    { url: 'https://placehold.co/200x200' },
    { url: 'https://placehold.co/200x200' },
]);
</script>

<template>
    <Authenticated>
        <div class="flex flex-col relative overflow-y-auto overflow-x-hidden md:w-3/6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row lg:flex-row justify-start md:justify-between lg:justify-between items-start md:items-center">
                    <div class="p-3 mt-auto">
                        <h1 class="text-2xl">Art Gallery</h1>
                    </div>
                    <div class="hidden md:block lg:block">
                        <button type="button" class="flex bg-indigo-500 hover:bg-indigo-600 shadow-sm shadow-slate-400 hover:shadow-slate-600 rounded-lg border-indigo-600 py-2 px-4 items-center justify-center w-full font-semibold text-white" @click="showUpload">
                            Upload Artwork
                        </button>
                    </div>
                </div>
                <hr class="my-3 border-gray-400">
                <div class="flex flex-col md:flex-row  md:space-x-2 justify-between items-end">
                    <Multiselect 
                        v-model="filter.level_id" 
                        :options="$page.props.levels"
                        valueProp="id"
                        placeholder="Select Level"
                        label="name"
                        :closeOnSelect="true"
                        :canDeselect="false"
                        :classes="{
                            container: 'relative mx-auto w-full flex items-center justify-end box-border rounded-lg border-gray-200 shadow-sm shadow-gray-400 cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerOpenTop: 'rounded-t-none',
                            containerActive: 'ring-0 ring-opacity-30',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                            search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 rtl:pl-0 rtl:pr-3.5',
                            tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2 rtl:pl-0 rtl:pr-2',
                            tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',
                            tagDisabled: 'pr-2 opacity-50 rtl:pl-2',
                            tagRemove: 'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                            tagRemoveIcon: 'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
                            tagsSearchWrapper: 'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                            tagsSearch: 'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full',
                            tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                            caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none rtl:mr-0 rtl:ml-3.5',
                            caretOpen: 'rotate-180 pointer-events-auto',
                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 rtl:pr-0 rtl:pl-3.5',
                            clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0 rtl:mr-0 rtl:ml-3.5',
                            inifite: 'flex items-center justify-center w-full',
                            inifiteSpinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 animate-spin flex-shrink-0 flex-grow-0 m-3.5',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                            dropdownTop: '-translate-y-full top-px bottom-auto rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none',
                            optionsTop: '',
                            group: 'p-0 m-0',
                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                            groupLabelPointable: 'cursor-pointer',
                            groupLabelPointed: 'bg-gray-300 text-gray-700',
                            groupLabelSelected: 'bg-indigo-600 text-white',
                            groupLabelDisabled: 'bg-gray-100 text-gray-300 cursor-not-allowed',
                            groupLabelSelectedPointed: 'bg-indigo-600 text-white opacity-90',
                            groupLabelSelectedDisabled: 'text-indigo-100 bg-indigo-600 bg-opacity-50 cursor-not-allowed',
                            groupOptions: 'p-0 m-0',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                            optionPointed: 'text-gray-800 bg-gray-100',
                            optionSelected: 'text-white bg-indigo-500',
                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                            optionSelectedDisabled: 'text-indigo-100 bg-indigo-500 bg-opacity-50 cursor-not-allowed',
                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            spacer: 'h-9 py-px box-content',
                        }" 
                    /> 
                    <Multiselect 
                    v-model="filter.theme_id" 
                        :options="option.themes"
                        valueProp="id"
                        placeholder="Select Theme"
                        label="name"
                        :closeOnSelect="true"
                        :canDeselect="false"
                        :loading="searching.themes"
                        :classes="{
                            container: 'relative mx-auto w-full flex items-center justify-end box-border rounded-lg border-gray-200 shadow-sm shadow-gray-400 cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerOpenTop: 'rounded-t-none',
                            containerActive: 'ring-0 ring-opacity-30',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                            search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 rtl:pl-0 rtl:pr-3.5',
                            tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2 rtl:pl-0 rtl:pr-2',
                            tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',
                            tagDisabled: 'pr-2 opacity-50 rtl:pl-2',
                            tagRemove: 'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                            tagRemoveIcon: 'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
                            tagsSearchWrapper: 'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                            tagsSearch: 'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full',
                            tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                            caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none rtl:mr-0 rtl:ml-3.5',
                            caretOpen: 'rotate-180 pointer-events-auto',
                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 rtl:pr-0 rtl:pl-3.5',
                            clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0 rtl:mr-0 rtl:ml-3.5',
                            inifite: 'flex items-center justify-center w-full',
                            inifiteSpinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 animate-spin flex-shrink-0 flex-grow-0 m-3.5',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                            dropdownTop: '-translate-y-full top-px bottom-auto rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none',
                            optionsTop: '',
                            group: 'p-0 m-0',
                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                            groupLabelPointable: 'cursor-pointer',
                            groupLabelPointed: 'bg-gray-300 text-gray-700',
                            groupLabelSelected: 'bg-indigo-600 text-white',
                            groupLabelDisabled: 'bg-gray-100 text-gray-300 cursor-not-allowed',
                            groupLabelSelectedPointed: 'bg-indigo-600 text-white opacity-90',
                            groupLabelSelectedDisabled: 'text-indigo-100 bg-indigo-600 bg-opacity-50 cursor-not-allowed',
                            groupOptions: 'p-0 m-0',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                            optionPointed: 'text-gray-800 bg-gray-100',
                            optionSelected: 'text-white bg-indigo-500',
                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                            optionSelectedDisabled: 'text-indigo-100 bg-indigo-500 bg-opacity-50 cursor-not-allowed',
                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            spacer: 'h-9 py-px box-content',
                        }" 
                    />
                    <div class="w-full mt-1 md:w-14 md:flex md:items-center border rounded-lg bg-indigo-500 text-white p-2.5 cursor-pointer">
                        <div class="flex items-center space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                            <span class="md:hidden">Search</span>
                        </div>
                    </div>
                </div>
                <p class="mt-10">Lesson 1: Painting the Beach Scenery</p>
                <hr class="my-4 border-gray-600">
                <div class="overflow-x-auto no-scrollbar">
                    <div class="flex space-x-2 py-3">
                        <div v-for="(image, index) in images" :key="index" class="relative min-w-[150px] min-h-[150px] md:min-w-[200px] md:min-h-[200px]">
                            <img :src="image.url" alt="Image" class="object-cover rounded-lg" />
                            <button @click="deleteImage(index)" class="absolute bottom-0 w-full bg-red-600 py-2 text-white">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-end fixed bottom-20 right-4 md:hidden lg:hidden">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold p-3 rounded-full shadow-lg" @click="showUpload">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                          </svg>
                    </button>
                </div>
            </div>
        </div>
    </Authenticated>
    <SimpleModal :open="show_upload" @close:modal="show_upload = false" width="md:w-2/6">
        <form class="p-4">
            <h1>Upload Artwork</h1>
            <hr class="my-4 border-gray-600">
            <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm mb-4">
                <option value="">Level 1</option>
            </select>
            <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm mb-4">
                <option value="">ArtVenture to the beach</option>
            </select>
            <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm mb-4">
                <option value="">Lesson 2: Painting the Boat and Lighthouse</option>
            </select>
            <select class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm mb-4">
                <option value="">Activity 1: Boat</option>
            </select>
            <input type="file" name="" id="" class="mb-4">
            <div class="flex items-center space-x-2">
                <BreezeButton type="submit" buttonType="blue" class="px-4 py-2">Upload</BreezeButton>
                <BreezeButton type="button" buttonType="gray" @click="show_upload = false">Cancel</BreezeButton>
            </div>
        </form>
    </SimpleModal>
</template>
<script>
import axios from 'axios'
import Multiselect from '@vueform/multiselect'

export default {
    components: { Multiselect },
    data(){
        return{
            show_upload: false,
            form: {
                level_id: '',
                theme_id: '',
                lesson_id: '',
                activity_id: '',
                artwork: {
                    name: '',
                    file: ''
                }
            },
            filter: {
                level_id: '',
                theme_id: '',
            },
            option: {
                themes: []
            },
            searching: {
                themes: false
            }
        }
    },
    watch: {
        'filter.level_id': {
            handler(){
                this.searching.themes = true
                axios.get(route('parent.art_gallery.get_themes', this.filter.level_id))
                .then(response => {
                    this.filter.theme_id = ''
                    this.option.themes = response.data;
                    this.searching.themes = false
                })
            }
        },
        deep: true
    },
    methods: {
        showUpload(){
            this.form.level_id  = ''
            this.form.theme_id  = ''
            this.form.lesson_id  = ''
            this.form.activity_id  = ''
            this.form.artwork.name  = ''
            this.form.artwork.file  = ''
            this.show_upload = true
        },
    }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>