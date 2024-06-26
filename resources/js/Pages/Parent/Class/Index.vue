<template>
    <Head title="Home" />
    <div class="fixed w-full flex justify-center top-[4rem] md:top-[10rem] font-extrabold bg-white border border-gray-300 py-3 z-20">
        <span>{{ $page.props.current_active_programme.name }}</span>
    </div>
    <Authenticated>
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
        <div class="max-w-xl mx-auto mt-5">
            <div class="flex items-center space-y-3" v-if="$page.props.posts.length">
                <h2 class="text-lg md:text-xl mx-1 font-extrabold">Stories</h2>
            </div>
            <div class="flex justify-center mx-1 mt-10" v-if="!$page.props.posts.length">
                <span class="text-slate-500">No Stories Found</span>
            </div>
            <div class="mt-3 flex flex-col space-y-3 bg-white py-3 px-4 shadow-md rounded-xl text-sm" v-for="post, post_index in $page.props.posts">
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
                <div class="" v-if="post.show_comment">
                    <textarea class="bg-white border border-gray-300 p-2 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="2" placeholder="Drop a comment..."></textarea>
                    <div class="flex justify-end">
                        <button class="px-4 py-2 text-xs bg-indigo-600 hover:bg-indigo-700 text-white rounded">Comment</button>
                    </div>
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
}
</script>
