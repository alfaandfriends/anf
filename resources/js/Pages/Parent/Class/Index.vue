<template>
    <Head title="Home" />
    <div class="fixed w-full flex justify-center top-[4rem] md:top-[10rem] font-extrabold bg-white border border-gray-300 py-3 z-20">
        <span>{{ $page.props.programme_info.name }}</span>
    </div>
    <Authenticated>
        <div class="max-w-xl mx-auto bg-white rounded-lg px-4 mt-14">
            <simplebar data-simplebar-auto-hide="true">
                <div class="flex space-x-8 md:space-x-10 pt-3 pb-4 font-medium">
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap">
                        <img src="/images/parents/stories.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Stories</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap">
                        <img src="/images/parents/progress_report.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Progress Report</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap">
                        <img src="/images/parents/fee_invoice.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Fee Invoice</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap">
                        <img src="/images/parents/art_gallery.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Gallery</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap">
                        <img src="/images/parents/art_book.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Book</span>
                    </div>
                </div>
            </simplebar>
        </div>
        <div class="max-w-xl mx-auto mt-5">
            <div class="flex items-center space-y-3 bg-white pb-3 pt-2.5 px-4 shadow rounded-xl">
                <h2 class="text-lg md:text-xl mx-1 font-extrabold">Stories</h2>
            </div>
            <div class="mt-3 flex flex-col space-y-3 bg-white py-3 px-4 shadow-md rounded-xl" v-for="post, post_index in $page.props.posts">
                <div class="flex flex-row text-sm items-center">
                    <div class="flex justify-between items-center flex-1 font-bold leading-tight select-none">
                        <div class="flex flex-col mx-1">
                            <span class="text-slate-900 md:text-md font-bold">{{ post.post_author_name }}</span>
                            <span class="text-xs font-medium text-slate-500">ALFA and Friends Maths</span>
                        </div>
                        <div class="flex items-center">
                            <TimeAgo class="text-gray-500 font-medium text-xs" :datetime="post.post_date"></TimeAgo>
                        </div>
                    </div>
                </div>
                <hr>
                <span class="text-sm text-slate-800">{{ post.post_title }}</span>
                    <Carousel v-if="post.post_images.length" :mouseDrag="post.post_images.length > 1" :touchDrag="post.post_images.length > 1">
                      <Slide v-for="image, image_index in post.post_images" :key="image">
                        <div class="carousel__item h-full">
                            <img :src="'/storage/posts/' + image.image_filename" class="select-none h-full" @dblclick="toggleLike(post_index, post.post_id)">
                        </div>
                      </Slide>
                      <template #addons>
                        <Navigation v-if="post.post_images.length > 1"/>
                      </template>
                    </Carousel>
                <div class="flex items-center space-x-4">
                    <div class="" v-if="!$page.props.can.create_posts">
                        <svg v-if="isLikedByCurrentStudent(post_index)" @click="toggleLike(post_index, post.post_id)" xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6 text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/>
                        </svg>
                        <svg v-else @click="toggleLike(post_index, post.post_id)" xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6 text-gray-500 hover:text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold select-none" v-if="isLikedByCurrentStudent(post_index) && !$page.props.can.create_posts">You liked this</span>
                </div>
                <div class="" v-if="post.show_comment">
                    <textarea class="bg-white border border-gray-300 p-2 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="2" placeholder="Drop a comment..."></textarea>
                    <div class="flex justify-end">
                        <button class="px-4 py-2 text-xs bg-indigo-600 hover:bg-indigo-700 text-white rounded">Comment</button>
                    </div>
                </div>
            </div>
            <div class="" v-if="!$page.props.posts.length">
                <div class="flex flex-col items-center justify-center mt-20">
                    <img width="80" height="80" src="https://img.icons8.com/dusk/64/activity-feed.png" alt="activity-feed"/>
                    <span class="text-slate-500 text-lg">Couldn't find any posts yet.</span>
                </div>
            </div>
        </div>
        <ConfirmationModal 
            :show="isOpen" 
            @close="isOpen = false"
            :confirmationAlert="confirmationAlert"
            :confirmationTitle="confirmationTitle"
            :confirmationText="confirmationText"
            :confirmationButton="confirmationButton"
            :confirmationMethod="confirmationMethod"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        >
        </ConfirmationModal>
        <SimpleModal :isOpen="show_add_child" @close="show_add_child = false">
            <template #header>
                Add Child
            </template>
            <div class="">
                <label class="font-medium text-gray-900 text-sm md:text-md">Name</label>
                <input type="text" class="mt-1 focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md mb-4 text-sm md:text-md" :class="!errors.name ? 'border-gray-300' : 'border-red-300'" v-model="child_form.name">
                <label class="font-medium text-gray-900 text-sm md:text-md">Date of Birth</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <Datepicker class="w-full rounded-lg shadow-sm mb-4 " 
                        :style="errors.dob ? '--dp-border-color: #FCA5A5' : '--dp-border-color: #D1D5DB'" 
                        input-class-name="date-picker"
                        v-model="child_form.dob" 
                        :enable-time-picker="false"
                        :auto-apply="true" 
                        :format="'dd/MM/yyyy'"
                    />
                </div>
                <label class="font-medium text-gray-900 text-sm md:text-md">Gender</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <select name="gender" id="gender" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm cursor-pointer" :class="!errors.gender ? 'border-gray-300' : 'border-red-300'" v-model="child_form.gender" autocomplete="none">
                        <option value="">-- Select Gender --</option>
                        <option :value="gender.id" v-for="(gender, index) in $page.props.gender_list" :key="index">{{ gender.name }}</option>
                    </select>
                </div>
                <hr class="my-5">
                <div class="flex justify-end items-center space-x-2">
                    <BreezeButton @click="addChild" buttonType="info" class="px-4 py-2">
                        <div v-if="adding" class="flex space-x-2">
                            <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span>Adding...</span>
                        </div>
                        <span v-else>Add</span>
                    </BreezeButton>
                    <BreezeButton type="button" buttonType="gray" @click="show_add_child = false" v-if="!adding">Cancel</BreezeButton>
                </div>
            </div>
        </SimpleModal>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeButton from '@/Components/Button.vue'
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';
</script>

<script>

export default {
    components: {
        simplebar
    },
    data(){
        return{
            isOpen: false,
            switching: false,
            confirmationAlert: '',
            confirmationTitle: '',
            confirmationText: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationRoute: '',
            confirmationData: '',
            show_add_child: false,
            adding: false,
            disable_overlay: false,
            child_form: {
                name: '',
                gender: '',
                dob: ''
            },
            errors: []
        }
    },
    methods: {
        toggleLike(post_index, post_id){
            if(this.isLikedByCurrentStudent(post_index)){
                const like_index    =   this.$page.props.posts[post_index].post_likes.findIndex(like => like.liked_by === this.$page.props.current_active_child.student_id);
                this.$page.props.posts[post_index].post_likes.splice(like_index, 1)
            }
            else{
                this.$page.props.posts[post_index].post_likes.push({
                    'liked_by' : this.$page.props.current_active_child.student_id
                })
            }
            axios.post(route('parent.like_post'), {'post_id': post_id, 'to_delete' : !this.isLikedByCurrentStudent(post_index)})
            .then(response => {
                console.log(response)
            });
        },
        isLikedByCurrentStudent(post_index){
        return this.$page.props.posts[post_index].post_likes.some(student => student.liked_by == this.$page.props.current_active_child.student_id);
        }
    }
}
</script>

