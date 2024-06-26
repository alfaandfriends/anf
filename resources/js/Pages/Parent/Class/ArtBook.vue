<template>
    <Head title="Home" />
    <div class="fixed w-full flex justify-center top-[4rem] md:top-[10rem] font-extrabold bg-white border border-gray-300 py-3 z-20">
        <span>{{ $page.props.session_data.current_active_programme.name }}</span>
    </div>
    <Authenticated>
        <div class="max-w-xl mx-auto border shadow bg-white rounded-lg px-4 mt-14">
            <simplebar data-simplebar-auto-hide="true">
                <div class="flex justify-evenly sm:justify-center space-x-8 md:space-x-10 pt-3 pb-4 font-medium">
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.stories') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.stories', $page.props.session_data.current_active_programme.encrypted_id))">
                        <img src="/images/parents/stories.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Stories</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.progress_reports') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.progress_reports'))">
                        <img src="/images/parents/progress_report.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Progress Report</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.invoices') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.invoices'))">
                        <img src="/images/parents/fee_invoice.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Invoices</span>
                    </div>
                    <!-- <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" v-if="$page.props.programme_info.id == 3 || $page.props.programme_info.id == 5"> -->
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_gallery') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_gallery'))">
                        <img src="/images/parents/art_gallery.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Gallery</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_book') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_book'))">
                        <img src="/images/parents/art_book.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Book</span>
                    </div>
                </div>
            </simplebar>
        </div>
        <div class="max-w-xl mx-auto mt-10"> 
            <div class="flex items-center space-y-3" v-if="$page.props.art_books">
                <h2 class="text-lg md:text-xl mx-1 font-extrabold">Art Books</h2>
            </div>
            <div class="mb-3 flex flex-col space-y-2 justify-between items-end mt-3">
                <Multiselect 
                    v-model="filter.level_id" 
                    :options="$page.props.levels"
                    valueProp="id"
                    placeholder="Select Level"
                    label="name"
                    :closeOnSelect="true"
                    :canDeselect="false"
                    :classes="{
                        container: 'relative mx-auto w-full flex items-center justify-end box-border rounded-lg shadow cursor-pointer border border-gray-200 rounded bg-white text-base leading-snug outline-none',
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
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg border p-6 min-h-[600px]" v-if="!searching.art_book_themes && this.$page.props.art_books.length">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-2">
                    <div class="w-full space-y-4 p-4 bg-white border border-gray-200 rounded-lg shadow-sm shadow-gray-400" v-for="artbook in this.$page.props.art_books">
                        <img :src="'/images/' + artbook.art_book_assets + 'thumbnail.jpg'" alt="">
                        <button type="button" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="openDownloadModal(artbook.id)">Select</button>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mx-1 mt-10" v-if="!searching.art_book_themes && !this.$page.props.art_books.length">
                <span class="text-slate-500">No Art Books Found</span>
            </div>
            <div class="flex justify-center mx-1 mt-10" v-if="searching.art_book_themes">
                <span class="text-slate-500">Searching for art books...</span>
            </div>
        </div>
        <SimpleModal :show="show_download_modal" @close:modal="show_download_modal = false" class="flex flex-col space-y-4 w-5/6 md:w-3/6 xl:w-2/6 2xl:w-3/12 px-6 py-8">
            <div class="flex flex-col justify-center items-center space-y-4" v-if="!generating">
                <h2 class="block mb-2 font-semibold text-gray-900 dark:text-white">What's the fun name you want to be called?</h2>
                <input type="text" :class="error_student_nickname ? 'border-red-300' : 'border-gray-300'" class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 capitalize" maxlength="10" placeholder="Max : 10 Characters" v-model="student_nickname" required>
                <button type="button" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="generateArtBook()">Generate</button>
                <a href="#" class="text-sm underline" @click="show_download_modal = false">Cancel</a>
            </div>
            <div class="p-4 text-indigo-800 border border-indigo-300 rounded-lg bg-indigo-50" v-else>
                <div class="flex items-center text-xl">
                    <svg class="flex-shrink-0 w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-xl font-medium">Do not close the browser</h3>
                </div>
                <div class="flex items-center my-4 text-sm" >
                    <div role="status">
                        <svg aria-hidden="true" class="w-6 h-6 me-2 text-indigo-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    Kindly wait as the system is in the process of creating your art book, this might take a minute...
                </div>
            </div>
        </SimpleModal>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeButton from '@/Components/Button.vue'
</script>

<script>
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';
import axios from 'axios'
import Multiselect from '@vueform/multiselect'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Multiselect
    },
    data(){
        return{
            init: true,
            progress: 0,
            show_download_modal: false,
            student_nickname: '',
            theme_id: '',
            error_student_nickname: false,
            controller : '',
            list: {
                levels: this.$page.props.levels,
            },
            filter: {
                level_id: 1,
            },
            searching: {
                art_book_themes: false,
            },
            generating: false
        }
    },
    watch: {
        'filter.level_id': {
            handler(){
                this.getArtBookThemes()
            },
            deep: true
        },
    },
    methods: {
        getArtBookThemes(){
            if(this.filter.level_id){
                if(this.searching.art_book_themes){
                    return
                }
                this.searching.art_book_themes = true
                axios.get(route('parent.art_gallery.get_themes', this.filter.level_id))
                .then(response => {
                    this.$page.props.art_books       =   response.data
                    this.searching.art_book_themes  =   false
                })
            }
        },
        openDownloadModal(theme_id){
            this.student_nickname = ''
            this.theme_id =   theme_id
            this.show_download_modal = true
        },
        generateArtBook(){
            if(this.student_nickname === '' || this.student_nickname.length > 10){
                this.error_student_nickname = true
                return
            }
            else{
                this.error_student_nickname = false
            }

            if(this.generating){
                return
            }

            this.generating = true
            this.controller = new AbortController();

            axios.get(route('parent.art_book.generate'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    'theme_id': this.theme_id,
                    'student_nickname': this.student_nickname
                },
                signal: this.controller.signal
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generating = false
                this.show_download_modal = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generating = false
            });
        },
        stopGenerate(){
            this.controller.abort()
        }
    }
}
</script>

