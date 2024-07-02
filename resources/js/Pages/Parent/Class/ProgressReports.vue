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
                        <span class="text-sm">Progress Reports</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.invoices') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.invoices'))">
                        <img src="/images/parents/fee_invoice.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Invoices</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_gallery') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_gallery'))" v-if="$page.props.session_data.current_active_programme.id == 3 || $page.props.session_data.current_active_programme.id == 5">
                        <img src="/images/parents/art_gallery.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Gallery</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_book') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_book'))" v-if="$page.props.session_data.current_active_programme.id == 3 || $page.props.session_data.current_active_programme.id == 5">
                        <img src="/images/parents/art_book.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Book</span>
                    </div>
                </div>
            </simplebar>
        </div>
        <div class="max-w-xl mx-auto mt-10">
            <div class="flex items-center space-y-3" v-if="$page.props.progress_reports.data.length">
                <h2 class="text-lg md:text-xl mx-1 font-extrabold">Progress Reports</h2>
            </div>
            <div class="flex justify-center mx-1 mt-10" v-if="!$page.props.progress_reports.data.length">
                <span class="text-slate-500">No Progress Reports Found</span>
            </div>
            <div class="mt-3" v-if="$page.props.progress_reports.data.length">
                <div class="bg-white shadow rounded-lg border">
                    <simplebar data-simplebar-auto-hide="true" class="max-h-96" @scroll="handlePRScroll" ref="progress_report_container">
                        <ul class="divide-y divide-slate-200 dark:divide-zink-500 px-6 py-4">
                            <li class="flex items-center gap-3 py-2 first:pt-0 last:pb-0" v-for="progress_report, progress_report_index in $page.props.progress_reports.data">
                                <div class="grow">
                                    <h6 class="font-medium">{{ moment(progress_report.month).format('MMMM Y') }}</h6>
                                </div>
                                <div class="shrink-0">
                                    <BreezeButton class="py-1 px-4" @click="showProgressReport(progress_report.id, progress_report.student_fee_id)">{{ generate.id == progress_report.id && generate.running ? 'Generating...'  : 'View'}}</BreezeButton>
                                </div>
                            </li>
                            <div class="flex items-center justify-between pt-5 animate-pulse" v-if="loading.progress_reports">
                                <div>
                                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-32 mb-2.5"></div>
                                </div>
                                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-16"></div>
                            </div>
                        </ul>
                    </simplebar>
                </div>
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeButton from '@/Components/Button.vue'
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';
import moment from 'moment';
import axios from 'axios';
</script>

<script>

export default {
    components: {
        simplebar
    },
    data(){
        return{
            generate: {
                id: '',
                running: false,
            },
            loading: {
                progress_reports: false
            }
        }
    },
    methods: {
        showProgressReport(progress_report_id, student_fee){
            if(this.generate.running){
                return
            }
            this.generate.running = true
            axios.get(route('progress_report.full_reports'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    progress_report_id: progress_report_id, 
                    student_fee: student_fee
                }
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generate.running = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generate.running = false
            });
        },
        handlePRScroll() {
            const container = this.$refs.progress_report_container.$el.querySelector('.simplebar-content-wrapper');
            const scrollTop = container.scrollTop;
            const scrollHeight = container.scrollHeight;
            const clientHeight = container.clientHeight;
            
            if (scrollTop + clientHeight >= scrollHeight - 100) {
                if(this.$page.props.progress_reports.next_page_url){
                    if(!this.loading.progress_reports){
                        this.loading.progress_reports = true
                        axios.get(route('parent.student_progress_reports'), {
                            params: {
                                page: this.$page.props.progress_reports.current_page + 1
                            }
                        })
                        .then((res) => {
                            res.data.data.forEach((item)=>{
                                this.$page.props.progress_reports.data.push(item)
                            })
                            this.$page.props.progress_reports.current_page   =    res.data.current_page
                            this.$page.props.progress_reports.next_page_url  =    res.data.next_page_url
                            this.loading.progress_reports = false
                        });
                    }
                }
            }
        }
    }
}
</script>

