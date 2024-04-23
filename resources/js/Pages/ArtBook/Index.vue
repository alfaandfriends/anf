<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Art Book" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="p-4">
            <div class="p-6 bg-white border border-gray-400 rounded" v-for="themes, level in $page.props.artbooks">
                <h3 class="font-semibold text-lg">{{ level }}</h3>
                <hr class="my-3 border border-dashed border-gray-400">
                <div class="flex">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-6">
                        <div class="w-full space-y-4 p-2 border border-gray-200 rounded-lg shadow-sm shadow-gray-400" v-for="artbook in themes">
                            <img class="w-full" :src="'/images/' + artbook.art_book_assets + 'thumbnail.jpg'" alt="">
                            <button type="button" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="openDownloadModal(artbook.id)">Select</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <Modal :showModal="open_modal" @hideModal="open_modal = false" :modalType="'xs'">
                    <template v-slot:header v-if="!generating">
                        <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
                            <h3 class="text-gray-900 text-xl font-semibold">                
                                Generate Art Book
                            </h3>        
                            <button type="button" @click="open_modal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>        
                    </template>
                    <template v-slot:content>
                        <div class="p-6" v-if="!generating">
                            <div class="mb-4">
                                <label for="class_name" class="block text-sm font-bold text-gray-700"> Student <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Multiselect 
                                        v-debounce:1s="findStudents"
                                        v-model="form.student_id"
                                        @close="clearStudents"
                                        valueProp="id"
                                        :loading="loading.students"
                                        placeholder="Please enter some characters"
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
                                            error_student_id ? 
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
                                <label for="class_name" class="block text-sm font-bold text-gray-700"> Nickname <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <input type="text" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="error_student_nickname ? 'border-red-300' : 'border-gray-300'" maxlength="10" placeholder="Max : 10 Characters" v-model="form.student_nickname">
                                </div>
                            </div>
                        </div>
                        <div class="p-6" v-else>
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
                                Kindly wait as the system is in the process of creating your art book, this might take a while...
                            </div>
                            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                <div class="bg-indigo-600 text-xs font-medium text-indigo-100 text-center p-0.5 leading-none rounded-full h-2" :style="'width: ' + current_progress + '%'"></div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer v-if="!generating">
                        <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                            <BreezeButton buttonType="info" @click="generateArtBook()">Generate</BreezeButton>
                        </div>
                    </template>
                </Modal>
                <Modal :showModal="open_ad_detected" @hideModal="open_ad_detected = false" :modalType="'xs'">
                    <template v-slot:content>
                        <div class="fixed z-10 inset-0 overflow-y-auto" id="my-modal">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                    role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <div>
                                        <!-- <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div> -->
                                        <div class="mt-3 text-center sm:mt-5">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                                Adblocker Detected
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    Please disable adblocker to prevent error during artbook generation.
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    Thank you.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-6">
                                        <button
                                            class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm"
                                            @click="open_ad_detected = false">
                                            OK
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </Modal>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import axios from 'axios'
import Modal from '@/Components/Modal.vue'
import Multiselect from '@vueform/multiselect'
import { debounce } from 'vue-debounce'
import detectAdBlocker from '../../Plugins/DetectAdBlocker/index'

export default {
    components: {
        Head, Link, Modal, Multiselect, 
    },
    mixins: [detectAdBlocker],
    data(){
        return{
            open_ad_detected: false,
            open_modal: false,
            form: {
                student_id: '',
                student_nickname: '',
                theme_id: ''
            },
            loading: {
                students: false
            },
            list: {
                students: false
            },
            current_progress: 0,
            interval_id: null,
            generating: false,
            error_student_nickname: false,
            error_student_id: false
        }
    },
    methods: {
        openDownloadModal(theme_id){
            this.open_modal             =   true
            this.form.student_id        =   ''
            this.form.student_nickname  =   ''
            this.form.theme_id          =   theme_id
        },
        findStudents(query){
            if(query){
                this.loading.students = true
                axios.get(route('students.find_digital_art_students'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.students = res.data
                    this.loading.students = false
                });
            }
        },
        generateArtBook(){
            this.error_student_nickname = this.form.student_nickname === '' || this.form.student_nickname.length > 10 ? true : false
            this.error_student_id = this.form.student_id === '' ? true : false

            if(this.form.student_nickname === '' || this.form.student_nickname.length > 10){
                return
            }

            if(this.form.student_id === ''){
                return
            }

            if(this.generating){
                return
            }

            this.generating = true
            this.interval_id = null
            this.current_progress = 0   

            const increment = 100 / 120;

            this.interval_id = setInterval(() => {
                this.current_progress += increment;
            }, 1000);

            const options = {
                params: {
                    'student_id': this.form.student_id,
                    'theme_id': this.form.theme_id,
                    'student_nickname': this.form.student_nickname
                },
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
            }
            axios.get(route('art_book.generate'), options)
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generating = false
                this.open_modal = false
                clearInterval(this.interval_id);
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generating = false
            });
        },
        clearStudents(){
            this.list.students = []
        },
    },
    mounted(){
        this.detectAdBlock().then((response)=>{
            if(response){
                this.open_ad_detected = true
            }
        })
    }
}
</script>