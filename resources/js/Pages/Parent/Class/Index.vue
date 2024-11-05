<template>
    <Head title="Home" />
    <Header>{{ $page.props.current_active_programme.name }}</Header>
    <Authenticated @scroll="handleStoryScroll">
        <div class="max-w-xl mx-auto border shadow bg-white rounded-lg px-4 mt-14">
            <simplebar data-simplebar-auto-hide="true">
                <div class="flex justify-evenly sm:justify-center space-x-8 md:space-x-10 pt-3 pb-4 font-medium">
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.stories') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.stories', $page.props.current_active_programme.encrypted_id))">
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
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_gallery') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_gallery'))" v-if="$page.props.current_active_programme.id == 3 || $page.props.current_active_programme.id == 5">
                        <img src="/images/parents/art_gallery.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Gallery</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_book') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_book'))" v-if="$page.props.current_active_programme.id == 3 || $page.props.current_active_programme.id == 5">
                        <img src="/images/parents/art_book.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Book</span>
                    </div>
                </div>
            </simplebar>
        </div>
        <div class="max-w-xl mx-auto mt-5">
            <div class="flex items-center space-y-3" v-if="$page.props.stories.data.length">
                <h2 class="text-lg md:text-xl mx-1 font-extrabold">Stories</h2>
            </div>
            <div class="flex justify-center mx-1 mt-10" v-if="!$page.props.stories.data.length">
                <span class="text-slate-500">No Stories Found</span>
            </div>
            <div class="mt-3 flex flex-col space-y-3 bg-white py-3 px-4 shadow-md rounded-xl text-sm" v-if="$page.props.stories.data.length" v-for="story, story_index in $page.props.stories.data">
                <div class="flex flex-row text-sm items-center">
                    <div class="flex justify-between items-center flex-1 font-bold leading-tight select-none">
                        <div class="flex flex-col">
                            <span class="text-slate-900 md:text-md font-bold">{{ story.story_author_name }}</span>
                            <span class="text-xs font-medium text-slate-500">{{ story.story_programme_name }}</span>
                        </div>
                        <div class="flex items-center">
                            <TimeAgo class="text-gray-500 font-medium text-xs" :datetime="story.story_date"></TimeAgo>
                        </div>
                    </div>
                </div>
                <hr>
                <span class="text-sm text-slate-800">{{ story.story_title }}</span>
                <Carousel v-if="story.images" :mouseDrag="story.images.length > 1" :touchDrag="story.images.length > 1">
                    <Slide v-for="image, image_index in story.images" :key="image">
                    <div class="carousel__item h-full">
                        <img :src="'/storage/stories/' + image.image_filename" class="select-none h-full" @dblclick="toggleLike(story_index, story.story_id)">
                    </div>
                    </Slide>
                    <template #addons>
                    <Navigation v-if="story.images.length > 1"/>
                    </template>
                </Carousel>
                <div class="flex items-center space-x-4">
                    <div class="" v-if="!$page.props.can.create_stories">
                        <svg v-if="isLikedByParent(story_index)" @click="toggleLike(story_index, story.story_id)" xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6 text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/>
                        </svg>
                        <svg v-else @click="toggleLike(story_index, story.story_id)" xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6 text-gray-500 hover:text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                        </svg>
                    </div>
                    <!-- <span class="text-xs font-semibold select-none" v-if="isLikedByParent(story_index) && !$page.props.can.create_stories">You liked this</span> -->
                    <div class="" @click="toggleComment()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6 text-gray-500 hover:text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9c.1-.2 .2-.3 .3-.5z"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-2" v-if="show_comment">
                    <div class="flex-col w-full mx-auto bg-white shadow border border-gray-300 px-4 py-3 rounded-lg" v-if="story.comments.length">
                        <simplebar data-simplebar-auto-hide="true" class="max-h-96">
                            <div class="divide-y space-y-2">
                                <div class="flex flex-row pt-1 md-10" v-for="comment in story.comments">
                                    <div class="flex-col mt-1">
                                        <div class="flex items-center flex-1 font-bold leading-tight">{{ comment.comment_user_name }}
                                            <span class="text-xs font-normal text-gray-500 ml-2">
                                                <TimeAgo class="text-gray-500 font-medium text-xs" :datetime="comment.created_at" :key="comment.created_at"></TimeAgo>
                                            </span>
                                        </div>
                                        <div class="flex-1 text-sm font-medium leading-loose text-gray-600">
                                            {{ comment.comment }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </simplebar>
                    </div>
                    <textarea class="bg-white border border-gray-300 p-2 px-3.5 rounded-lg w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="2" placeholder="Drop a comment..." :key="story_index" v-model="comments[story_index]"></textarea>
                    <div class="flex justify-end" @click="postComment(story_index, story.story_id)">
                        <button class="px-4 py-2 text-xs bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">Comment</button>
                    </div>
                </div>
            </div>
            <div class="mt-3 max-w-xl py-3 px-4 border border-gray-200 rounded-xl shadow animate-pulse bg-white" v-if="loading.stories">
                <div class="flex items-center">
                    <div>
                        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-32 mb-2"></div>
                        <div class="w-48 h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-4"></div>
                    </div>
                </div>
                <hr>
                <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4 mt-3"></div>
                <div class="flex items-center justify-center h-48 mb-4 bg-gray-300 rounded dark:bg-gray-700">
                    <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                        <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z"/>
                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                    </svg>
                </div>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';
import Header from './Header.vue'
</script>

<script>
import TimeAgo from '@/Components/TimeAgo.vue'
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { DateTime } from 'luxon';

export default {
    components: {
        simplebar, TimeAgo, Carousel, Slide, Pagination, Navigation,
    },
    data(){
        return{
            show_comment: false,
            loading:{
                stories: false
            },
            comments: [],
        }
    },
    methods: {
        isLikedByParent(story_index){
            if(this.$page.props.stories.data[story_index].likes.length){
                return this.$page.props.stories.data[story_index].likes.some(like => like.like_author_id === this.$page.props.auth.user.ID);
            }
            return false
        },
        toggleLike(story_index, story_id){
            if(this.isLikedByParent(story_index)){
                const like_index    =   this.$page.props.stories.data[story_index].likes.findIndex(like => like.like_author_id === this.$page.props.auth.user.ID);
                this.$page.props.stories.data[story_index].likes.splice(like_index, 1)
            }
            else{
                this.$page.props.stories.data[story_index].likes.push({
                    'like_author_id' : this.$page.props.auth.user.ID
                })
            }
            
            axios.post(route('parent.like_story'), {'story_id': story_id, 'to_delete' : !this.isLikedByParent(story_index)})
            .then(response => {
            });
        },
        toggleComment(){
            this.show_comment = !this.show_comment
        },
        postComment(story_index, story_id){
            axios.post(route('parent.stories.comments.store'), {'story_id': story_id, 'comment' : this.comments[story_index]})
            .then(response => {
                if(response.data){
                    this.$page.props.stories.data[story_index].comments.unshift({
                        'comment': this.comments[story_index],
                        'comment_user_name': this.$page.props.auth.user.display_name,
                        'created_at': DateTime.now().setZone('Asia/Kuala_Lumpur').toFormat('yyyy-MM-dd HH:mm:ss')
                    })
                    this.comments[story_index] = ''
                }
            });
        },
        handleStoryScroll() {
            const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
            const clientHeight = document.documentElement.clientHeight || window.innerHeight;
            
            if (scrollTop + clientHeight >= scrollHeight - 100) {
                if(this.$page.props.stories.next_page_url){
                    if(!this.loading.stories){
                        this.loading.stories = true
                        axios.get(route('parent.student_stories', [this.$page.props.session_data.current_active_child.student_id, this.$page.props.session_data.current_active_programme.id]), {
                            params: {
                                page: this.$page.props.stories.current_page + 1
                            }
                        })
                        .then((res) => {
                            res.data.data.forEach((item)=>{
                                this.$page.props.stories.data.push(item)
                            })
                            this.$page.props.stories.current_page   =    res.data.current_page
                            this.$page.props.stories.next_page_url  =    res.data.next_page_url
                            this.loading.stories = false
                        });
                    }
                }
            }
        }
    }
}
</script>

