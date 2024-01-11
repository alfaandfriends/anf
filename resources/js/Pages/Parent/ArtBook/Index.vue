
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


<style>
    .storybook-scroll::-webkit-scrollbar {
       width: 10px;          
       height: 6px;  
    }
    
    .storybook-scroll::-webkit-scrollbar-thumb {   
      border-radius: 30px;
      background: rgb(105 105 105);
      box-shadow: inset 2px 2px 2px rgba(255,255,255,.25), inset -2px -2px 2px rgba(0,0,0,.25);}
    
    .storybook-scroll::-webkit-scrollbar-track {     
      background-color: #fff;
      border-radius:10px;
      margin-left: 6px;
      margin-right: 6px;
      background: rgb(211 211 211);
    }
</style>

<template>
    <Head title="Art Gallery" />
    <Authenticated>
        <div class="bg-white overflow-hidden shadow rounded-lg border p-6 min-h-[600px]">
            <div class="flex flex-col md:flex-row lg:flex-row justify-start md:justify-between lg:justify-between items-start md:items-center">
                <div class="p-3 mt-auto">
                    <h1 class="text-2xl">Generate Art Book</h1>
                </div>
                <!-- <div class="hidden md:block lg:block" v-if="$page.props.current_active_child.student_id"> -->
                <!-- <div class="hidden md:block lg:block">
                    <button type="button" class="flex bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-slate-400 hover:shadow-slate-600 rounded-lg border-indigo-600 py-2 px-4 items-center justify-center w-full font-semibold text-white" @click="showUpload">
                        Generate Art Book
                    </button>
                </div> -->
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
                <div @click="getArtBookThemes" class="w-full md:w-12 md:flex md:justify-center rounded-lg bg-indigo-600 hover:bg-indigo-700 shadow-sm shadow-slate-400 hover:shadow-slate-600 text-white p-2.5 cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <svg v-if="searching.art_book_themes" class="inline w-5 h-5 text-gray-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <!-- <svg v-if="searching.artworks" class="w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        </svg> -->
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        <span class="md:hidden" v-if="!searching.art_book_themes">Search</span>
                        <span class="md:hidden" v-else>Searching...</span>
                    </div>
                </div>
            </div>
            <div v-if="init" class="p-4 text-sm text-gray-800 rounded-lg bg-gray-200 text-center" role="alert">
                <span class="font-medium">Use filters above to get list of art books.</span>
            </div>
            <div v-if="!init && list.art_book_themes.length < 1" class="p-4 text-sm text-gray-800 rounded-lg bg-gray-50 text-center" role="alert">
                <span class="font-medium">Uh oh! Nothing found.</span>
            </div>
            <div v-if="!this.searching.art_book_themes && list.art_book_themes.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-2">
                <div class="w-full space-y-4 p-4 bg-white border border-gray-200 rounded-lg shadow-sm shadow-gray-400" v-for="artbook in list.art_book_themes">
                    <img :src="'/images' + artbook.art_book_folder + 'cover.jpg'" alt="">
                    <button type="button" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="openDownloadModal()">Select</button>
                </div>
            </div>
            
        </div>
        <SimpleModal v-if="show_download_modal" :open="show_download_modal" @close:modal="show_download_modal = false" class="w-5/6 md:w-3/6 xl:w-2/6 px-6 py-8">
            <div class="flex flex-col justify-center items-center space-y-4">
                <form action="">
                    <h2 class="block mb-2 font-semibold text-gray-900 dark:text-white">What do you prefer to be called?</h2>
                    <input type="text" :class="error_student_nickname ? 'border-red-300' : 'border-gray-300'" class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" placeholder="Max 10 Characters" v-model="student_nickname" required>
                    <button type="button" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="generateArtBook()">Generate</button>
                </form>
            </div>
        </SimpleModal>
    </Authenticated>
</template>
<script>
import axios from 'axios'
import Multiselect from '@vueform/multiselect'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: { Multiselect },
    data(){
        return{
            init: true,
            show_download_modal: false,
            student_nickname: '',
            error_student_nickname: false,
            list: {
                levels: this.$page.props.levels,
                art_book_themes: [],
            },
            filter: {
                level_id: '',
            },
            searching: {
                art_book_themes: false,
            },
        }
    },
    watch: {
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
                    this.init                       =   false
                    this.list.art_book_themes       =   response.data
                    this.searching.art_book_themes  =   false
                })
            }
        },
        openDownloadModal(){
            this.student_nickname = ''
            this.show_download_modal = true
        },
        generateArtBook(){
            this.error_student_nickname = this.student_nickname === '' ? true : false
            if(this.student_nickname === ''){
                return
            }
            if(this.generating){
                return
            }
            axios.get(route('parent.art_book.generate'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    'student_nickname': this.student_nickname
                }
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generating[index] = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generating[index] = false
            });
            
        }
    }
}
</script>

