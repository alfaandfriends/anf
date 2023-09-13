
<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
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
    <Head title="Art Gallery" />
    <Authenticated>
        <div class="bg-white overflow-hidden shadow rounded-lg border p-6 min-h-[600px]">
            <div class="flex flex-col md:flex-row lg:flex-row justify-start md:justify-between lg:justify-between items-start md:items-center">
                <div class="p-3 mt-auto">
                    <h1 class="text-2xl">Art Gallery</h1>
                </div>
                <div class="hidden md:block lg:block" v-if="$page.props.current_active_child.student_id">
                    <button type="button" class="flex bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-slate-400 hover:shadow-slate-600 rounded-lg border-indigo-600 py-2 px-4 items-center justify-center w-full font-semibold text-white" @click="showUpload">
                        Upload Artwork
                    </button>
                </div>
            </div>
            <hr class="my-3 border-gray-400">
            <div class="mb-3 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 justify-between items-end">
                <Multiselect 
                    v-model="filter.level_id" 
                    :options="$page.props.levels"
                    valueProp="id"
                    placeholder="Select Level"
                    label="name"
                    :closeOnSelect="true"
                    :canDeselect="false"
                    :classes="{
                        container: 'relative mx-auto w-full flex items-center justify-end box-border rounded-lg border-gray-200 shadow-sm shadow-gray-500 cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
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
                    noOptionsText="No options available"
                    :classes="{
                        container: 'relative mx-auto w-full flex items-center justify-end box-border rounded-lg border-gray-200 shadow-sm shadow-gray-500 cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
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
                        spinner: 'animate-spin rounded-full border-t-2 border-indigo-600 h-5 w-5',
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
                <div @click="getArtwork" class="w-full md:w-14 md:flex md:items-center rounded-lg bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-slate-400 hover:shadow-slate-600 text-white p-2.5 cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <svg v-if="searching.artworks" class="inline w-5 h-5 text-gray-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <!-- <svg v-if="searching.artworks" class="w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        </svg> -->
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        <span class="md:hidden" v-if="!searching.artworks">Search</span>
                        <span class="md:hidden" v-else>Searching...</span>
                    </div>
                </div>
            </div>
            <div v-if="init" class="p-4 text-sm text-gray-800 rounded-lg bg-gray-200 text-center" role="alert">
                <span class="font-medium">Use filters above to find student artwork.</span>
            </div>
            <div v-if="!init && artworks.length < 1" class="p-4 text-sm text-gray-800 rounded-lg bg-gray-50 text-center" role="alert">
                <span class="font-medium">Uh oh! Nothing found.</span>
            </div>
            <template v-else v-for="artwork, lesson in artworks">
                <p class="mt-10">{{ lesson }}</p>
                <hr class="my-4 border-gray-600">
                <div class="flex overflow-x-scroll py-4 no-scrollbar w-full">
                    <div class="flex space-x-4">
                        <div v-for="(image, index) in artwork" :key="index" class="relative w-52 h-52 flex flex-col justify-center">
                            <img :src="'/storage/art_gallery/'+image.filename" class="object-fill w-52 h-52 rounded-lg cursor-pointer" alt="Click to view larger image" @click="showImage(image.filename, image.activity)"/>
                            <button @click="promptDelete(image.id)" class="absolute bottom-0 w-full bg-red-600 py-2 text-white">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <div class="flex space-x-2 py-3 ">
                    </div>
                </div>
            </template>
            <div class="flex items-end justify-end fixed bottom-24 right-4 md:hidden lg:hidden">
                <button class="bg-indigo-600 hover:bg-indigo-600 text-white font-semibold p-3 rounded-full shadow-lg" @click="showUpload">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                    </svg>
                </button>
            </div>
        </div>
    </Authenticated>
    <SimpleModal v-if="show_upload" :open="show_upload" @close:modal="show_upload = false" class="h-screen w-full sm:w-4/6 md:h-auto md:w-2/6 p-4 overflow-y-auto" :disable_overlay="disable_overlay">
        <form class="p-4">
            <h1 class="md:font-semibold md:text-xl">Upload Artwork</h1>
            <hr class="my-4 border-gray-600">
            <label class="font-medium text-gray-900 text-sm md:text-md">Level</label>
            <select class="mt-1 focus:ring-0 focus:border-gray-500 flex-1 block w-full rounded-md mb-4 cursor-pointer text-sm md:text-md" :class="!errors.level_id ? 'border-gray-300' : 'border-red-300'" v-model="form.level_id">
                <option value="">Please Select</option>
                <option :value="level.id" v-for="(level, index) in list.levels" :key="index">{{ level.name }}</option>
            </select>
            <label class="font-medium text-gray-900 text-sm md:text-md">Theme</label>
            <select class="mt-1 focus:ring-0 focus:border-gray-500 flex-1 block w-full rounded-md mb-4 cursor-pointer text-sm md:text-md" :class="!errors.theme_id ? 'border-gray-300' : 'border-red-300'" v-model="form.theme_id">
                <option value="">Please Select</option>
                <option :value="theme.id" v-for="theme, index in list.themes" :key="theme.id">{{ theme.name }}</option>
            </select>
            <label class="font-medium text-gray-900 text-sm md:text-md">Lesson</label>
            <select class="mt-1 focus:ring-0 focus:border-gray-500 flex-1 block w-full rounded-md mb-4 cursor-pointer text-sm md:text-md" :class="!errors.lesson_id ? 'border-gray-300' : 'border-red-300'" v-model="form.lesson_id">
                <option value="">Please Select</option>
                <option :value="lesson.id" v-for="lesson, index in list.lessons" :key="lesson.id">{{ lesson.name }}</option>
            </select>
            <label class="font-medium text-gray-900 text-sm md:text-md">Activity</label>
            <select class="mt-1 focus:ring-0 focus:border-gray-500 flex-1 block w-full rounded-md mb-4 cursor-pointer text-sm md:text-md" :class="!errors.activity_id ? 'border-gray-300' : 'border-red-300'" v-model="form.activity_id">
                <option value="">Please Select</option>
                <option :value="activity.id" v-for="activity, index in list.activities" :key="activity.id">{{ activity.name }}</option>
            </select>
            <label class="font-medium text-gray-900 text-sm md:text-md">File</label>
            <div class="mb-3">
                <input class="w-full flex-auto rounded border px-3 py-[0.32rem] text-base font-normal text-neutral-700 cursor-pointer transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none"
                :class="!errors.artwork_file ? 'border-gray-300' : 'border-red-300'"
                type="file" accept="image/png, image/jpeg" ref="artwork_file" @change="handleArtwork"/>
              </div>
            <hr class="my-5">
            <div class="flex items-center space-x-2">
                <BreezeButton @click="upload" buttonType="info" class="px-4 py-2">
                    <div v-if="uploading" class="flex space-x-2">
                        <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span>Uploading</span>
                    </div>
                    <span v-else>Upload</span>
                </BreezeButton>
                <BreezeButton type="button" buttonType="gray" @click="show_upload = false" v-if="!uploading">Cancel</BreezeButton>
            </div>
        </form>
    </SimpleModal>
    <SimpleModal v-if="image.show" :open="image.show" @close:modal="image.show = false" class="md:w-2/6 p-4">
        <div class="flex flex-col justify-center items-center w-full space-y-4">
            <span class="md:text-xl">{{image.activity}}</span>
            <img :src="image.file" class="object-scale-down rounded-lg" alt="">
        </div>
    </SimpleModal>
    <SimpleModal v-if="show_confirmation" :open="show_confirmation" @close:modal="show_confirmation = false" class="md:w-3/12">
        <div class="relative text-center p-6">
            <button @click="show_confirmation = false" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <svg class="text-gray-400 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <p class="mb-4 text-gray-500">Are you sure you want to delete this artwork?</p>
            <div class="flex justify-center items-center space-x-4">
                <button @click="deleteImage" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10">
                    Confirm
                </button>
                <button @click="show_confirmation = false" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300">
                    Cancel
                </button>
            </div>
        </div>
    </SimpleModal>
</template>
<script>
import axios from 'axios'
import Multiselect from '@vueform/multiselect'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: { Multiselect },
    data(){
        return{
            show_upload: false,
            image:{
                show: false,
                file: '',
                activity: ''
            },
            init: true,
            artworks: [],
            list: {
                students: [],
                levels: this.$page.props.levels,
                themes: [],
                lessons: [],
                activities: []
            },
            form: {
                level_id: '',
                theme_id: '',
                lesson_id: '',
                activity_id: '',
                artwork_file: ''
            },
            filter: {
                level_id: '',
                theme_id: '',
            },
            option: {
                themes: []
            },
            searching: {
                themes: false,
                artworks: false
            },
            errors: {

            },
            uploading: false,
            disable_overlay: false,
            show_confirmation: false,
            deleting_image: false,
            artwork_to_delete: ''
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
            },
            deep: true
        },
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
            immediate: true
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
            immediate: true
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
            immediate: true
        },
    },
    methods: {
        showUpload(){
            for (let key in this.form) {
                if (this.form.hasOwnProperty(key)) {
                    this.form[key] = '';
                }
            }
            this.errors = {}
            this.show_upload = true
        },
        getArtwork(){
            if(this.filter.level_id && this.filter.theme_id){
                if(this.searching.artworks){
                    return
                }
                this.searching.artworks = true
                axios.get(route('parent.art_gallery.get_artworks', this.filter))
                .then(response => {
                    this.init       = false
                    this.artworks   =   response.data
                    this.searching.artworks  = false
                })
            }
        },
        showImage(filename, activity){
            this.image.file = '/storage/art_gallery/' +  filename
            this.image.activity = activity
            this.image.show = true
        },
        handleArtwork(){
            this.form.artwork_file  =   this.$refs.artwork_file.files[0]
        },
        upload(){
            if(this.uploading){
                return
            }
            for (let key in this.form) {
                if (this.form[key] == '') {
                    this.errors[key] = true
                }
                else{
                    this.errors[key] = false
                }
            }
            const proceed = Object.values(this.errors).every(value => value === false);
            if (proceed) {
                this.$inertia.post(route('parent.art_gallery.store'), this.form, {
                    preserveState: false,
                    preserveScroll: true,
                    onBefore: (visit) => {
                        this.uploading = true
                        this.disable_overlay = true
                    },
                    onFinish: (visit) => {
                        this.uploading = false
                        this.disable_overlay = false
                        this.show_upload = false
                    },
                })
            }
        },
        promptDelete(artwork_id){
            this.artwork_to_delete = artwork_id
            this.show_confirmation = true
        },
        deleteImage(){
            if(this.deleting_image){
                return
            }
            this.$inertia.delete(route('parent.art_gallery.destroy', this.artwork_to_delete), {
                preserveState: false,
                preserveScroll: true,
                onBefore: (visit) => {
                    this.deleting_image = true
                },
                onFinish: (visit) => {
                    this.uploading = false
                    this.show_confirmation = false
                },
            })
        }
    }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>