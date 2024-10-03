<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Art Book" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card v-for="themes, level in $page.props.artbooks">
            <template #title>{{ level }}</template>
            <template #content>
                <div class="grid grid-cols-1 px-12 py-2">
                    <Carousel 
                    class="relative w-full mx-1"
                    :opts="{
                        align: 'start',
                    }"
                    >
                    <CarouselContent>
                        <CarouselItem v-for="artbook, index in themes" :key="index" class="py-2 sm:basis-1/2 lg:basis-1/3 xl:basis-1/4 2xl:basis-1/6 cursor-pointer" @click="openDownloadModal(artbook.id)">
                            <div class="p-1 border rounded-lg">
                                <img :src="'/images/' + artbook.art_book_assets + 'thumbnail.jpg'" class="w-full rounded-lg hover:scale-105 duration-200">
                            </div>
                        </CarouselItem>
                    </CarouselContent>
                    <CarouselPrevious />
                    <CarouselNext />
                    </Carousel>
                </div>
            </template>
        </Card>
        <Dialog v-model:open="open_generate_modal" classProp="max-w-md" :interactOutside="(e) => { e.preventDefault() }" :hideClose="true">
            <template #title v-if="!generating">Generate Art Book</template>
            <template #title v-else>Do not close the browser</template>
            <template #content v-if="!generating">
                <div class="p-1 grid grid-cols-1 gap-4">
                    <div>
                        <Label>Student Name<span class="text-red-500">*</span></Label>
                        <ComboBox @search="findStudents" :items="list.students" label-property="name" value-property="id" :error="error_student_id" v-model="form.student_id" select-placeholder="Enter some characters to search" search-placeholder="Search student..."
                                :loading="loading.students"></ComboBox>
                    </div>
                    <div>
                        <Label>Nickname<span class="text-red-500">*</span></Label>
                        <Input :error="error_student_nickname" v-model="form.student_nickname" maxlength="10" placeholder="Max : 10 Characters"></Input>
                    </div>
                </div>
            </template>
            <template #content v-else>
                <div class="pb-10">
                    <div class="flex items-center mb-4 text-sm" >
                        <div role="status">
                            <svg aria-hidden="true" class="w-6 h-6 me-2 text-indigo-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                        Please stay in this page and kindly wait as the system is in the process of creating your art book, this might take a while...
                    </div>
                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="bg-indigo-600 text-xs font-medium text-indigo-100 text-center p-0.5 leading-none rounded-full h-2" :style="'width: ' + current_progress + '%'"></div>
                    </div>
                </div>
            </template>
            <template #footer v-if="!generating">
                <Button variant="outline" @click="open_generate_modal = false">Cancel</Button>
                <Button @click="generateArtBook">Generate</Button>
            </template>
        </Dialog>
        <Dialog v-model:open="open_ad_detected" classProp="max-w-md" :interactOutside="(e) => { e.preventDefault() }" :hideClose="true">
            <template #title>Adblocker Detected</template>
            <template #content>
                <span class="font-medium text-sm text-slate-600">Please disable adblocker to prevent error during artbook generation. Thank you.</span>
            </template>
            <template #footer>
                <Button @click="open_ad_detected = false">Okay</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import axios from 'axios'
import { debounce } from 'vue-debounce'
import detectAdBlocker from '../../Plugins/DetectAdBlocker/index'
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious, } from '@/Components/ui/carousel'
import Card from '@/Components/Card.vue'
import Dialog from '@/Components/DialogModal.vue'

export default {
    components: {
        Head, Link
    },
    mixins: [detectAdBlocker],
    data(){
        return{
            open_ad_detected: false,
            open_generate_modal: false,
            form: {
                student_id: '',
                student_nickname: '',
                theme_id: ''
            },
            loading: {
                students: false
            },
            list: {
                students: []
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
            this.open_generate_modal             =   true
            this.form.student_id        =   ''
            this.form.student_nickname  =   ''
            this.form.theme_id          =   theme_id
        },
        findStudents: debounce(function(query) {
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
        }, 1000),
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
                this.open_generate_modal = false
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
    created(){
        this.detectAdBlock().then((response)=>{
            if(response){
                this.open_ad_detected = true
            }
        })
    }
}
</script>