 <style>
/* Define a custom scrollbar */
textarea::-webkit-scrollbar {
width: 5px; /* Width of the scrollbar */
border-radius: 8px; /* Rounded corners */
}

/* Track */
textarea::-webkit-scrollbar-track {
background:  transparent; /* Color of the track */
border-radius: 8px; /* Rounded corners */
}

/* Handle */
textarea::-webkit-scrollbar-thumb {
background: #888; /* Color of the handle */
border-radius: 8px; /* Rounded corners */
}

/* Handle on hover */
textarea::-webkit-scrollbar-thumb:hover {
background: #555; /* Color of the handle when hovered */
}
</style>

<template>
    <Head title="Home" />
    <Authenticated>
        <!-- <div class="bg-white overflow-hidden shadow rounded-lg border">
            <div class="px-6 md:px-6 py-5">
                <span class="text-lg leading-6 text-gray-900 font-semibold">
                    Academy Information
                </span>
            </div>
            <hr>
            <div class="border-t border-gray-200 px-6 py-4" v-if="!$page.props.user_has_children.length">
                <span class="italic">No children have been added at the moment.</span>
            </div>
            <ul class="flex flex-col px-4 md:px-6 py-4 md:py-6 rounded-lg space-y-4" v-else-if="$page.props.current_active_child.student_id">
                <template v-if="$page.props.academics.length">
                    <li class="relative flex py-4 px-6 rounded-t-inherit rounded-xl bg-white border-2 border-dashed border-indigo-400" v-for="academic in $page.props.academics">
                        <div class="flex flex-col space-y-2">
                            <h6 class="mb-2 leading-normal font-bold font-sans underline">{{ academic.programme_name }}</h6>
                            <span class="leading-tight text-sm font-sans">Level: <span class="font-semibold text-slate-700 sm:ml-2">{{ academic.programme_level }}</span></span>
                            <span class="leading-tight text-sm font-sans">Centre: <span class="font-semibold text-slate-700 sm:ml-2">{{ academic.centre_name }}</span></span>
                            <span class="leading-tight text-sm font-sans">Class Type: <span class="font-semibold text-slate-700 sm:ml-2">{{ academic.class_type }}</span></span>
                        </div>
                    </li>
                </template>
                <template v-else>
                    <div>
                        <span class="italic">No programme or classes enrolled for this student.</span>
                    </div>
                </template>
            </ul>
            <div class="border-t border-gray-200 px-6 py-4" v-else-if="$page.props.user_has_children.length && !$page.props.current_active_child.child_id">
                <span class="italic">Please select a child to view their information.</span>
            </div>
            <div class="border-t border-gray-200 px-6 py-4" v-else>
                <span class="italic">Sorry, this little cutie is not a student.</span>
            </div>
        </div> -->
        <div class="flex flex-col bg-white p-3 shadow-md rounded">
            <textarea class="bg-white border border-gray-300 p-2 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="5" placeholder="What's happening today?" v-model="form.status_text"></textarea>
            <div class="flex justify-between pt-2">
                <div class="flex space-x-2">
                    <div class="self-center space-x-2 bg-blue-200 rounded px-3 py-2 text-xs font-semibold cursor-pointer transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/>
                        </svg>
                        <span class="inline-block">Photo</span>
                    </div>
                    <div class="self-center space-x-2 bg-green-200 rounded px-3 py-2 text-xs font-semibold cursor-pointer transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4" fill="currentColor" viewBox="0 0 448 512">
                            <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/>
                        </svg>
                        <span class="inline-block">Tag Person</span>
                    </div>
                </div>
                <div class="flex items-center space-x-2 ">
                    <button class="px-4 py-2 text-sm text-white rounded" :class="!form.status_text ? 'bg-indigo-300 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700'" :disabled="!form.status_text">Post</button>
                </div>
            </div>
        </div>
        <div class="mt-3 flex flex-col space-y-3 bg-white py-3 px-4 shadow-md rounded" v-for="post, post_index in posts">
            <div class="flex flex-row text-sm items-center">
                <img class="object-cover w-12 h-12 border-2 border-gray-300 rounded-full" alt="Noob master's avatar" src="https://images.unsplash.com/photo-1517070208541-6ddc4d3efbcb?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&faces=1&faceindex=1&facepad=2.5&w=500&h=500&q=80">
                <div class="flex justify-between items-center flex-1 px-4 font-bold leading-tight">
                    <span>{{ post.created_by }}</span>
                    <span class="ml-2 text-xs font-normal text-gray-500">2 weeks ago</span>
                </div>
            </div>
            <img @dblclick="toggleLike(post_index)" :src="'storage/posts/'+post.image" class="select-none">
            <div class="flex space-x-4">
                <div class="">
                    <svg v-if="post.liked" @click="toggleLike(post_index)" xmlns="http://www.w3.org/2000/svg" class="inline-block h-7 w-7 text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                        <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/>
                    </svg>
                    <svg v-else @click="toggleLike(post_index)" xmlns="http://www.w3.org/2000/svg" class="inline-block h-7 w-7 text-gray-500 hover:text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                        <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                    </svg>
                </div>
                <div class="" @click="toggleComment(post_index)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-7 w-7 text-gray-500 hover:text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                        <path d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9c.1-.2 .2-.3 .3-.5z"/>
                    </svg>
                </div>
            </div>
            <div class="flex-col w-full py-4 bg-white sm:px-4 sm:py-4 md:px-4 rounded-lg border text-sm">
                <div class="flex flex-row">
                    <img class="object-cover w-12 h-12 border-2 border-gray-300 rounded-full" alt="Noob master's avatar" src="https://images.unsplash.com/photo-1517070208541-6ddc4d3efbcb?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&faces=1&faceindex=1&facepad=2.5&w=500&h=500&q=80">
                    <div class="flex-col mt-1">
                        <div class="flex items-end flex-1 px-4 font-bold leading-tight">
                            <span>Noob master</span>
                            <span class="ml-2 text-xs font-normal text-gray-500">2 weeks ago</span>
                        </div>
                        <div class="flex-1 px-2 ml-2 text-xs font-medium leading-loose text-gray-600">Wow!!! how you did you
                            create this?
                        </div>
                        <button class="inline-flex items-center px-1 pt-2 ml-1 flex-column">
                            <svg class="w-5 h-5 ml-2 text-gray-600 cursor-pointer fill-current hover:text-gray-900"
                                viewBox="0 0 95 78" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M29.58 0c1.53.064 2.88 1.47 2.879 3v11.31c19.841.769 34.384 8.902 41.247 20.464 7.212 12.15 5.505 27.83-6.384 40.273-.987 1.088-2.82 1.274-4.005.405-1.186-.868-1.559-2.67-.814-3.936 4.986-9.075 2.985-18.092-3.13-24.214-5.775-5.78-15.377-8.782-26.914-5.53V53.99c-.01 1.167-.769 2.294-1.848 2.744-1.08.45-2.416.195-3.253-.62L.85 30.119c-1.146-1.124-1.131-3.205.032-4.312L27.389.812c.703-.579 1.49-.703 2.19-.812zm-3.13 9.935L7.297 27.994l19.153 18.84v-7.342c-.002-1.244.856-2.442 2.034-2.844 14.307-4.882 27.323-1.394 35.145 6.437 3.985 3.989 6.581 9.143 7.355 14.715 2.14-6.959 1.157-13.902-2.441-19.964-5.89-9.92-19.251-17.684-39.089-17.684-1.573 0-3.004-1.429-3.004-3V9.936z"
                                    fill-rule="nonzero" />
                            </svg>
                        </button>
                        <button class="inline-flex items-center px-1 -ml-1 flex-column">
                            <svg class="w-5 h-5 text-gray-600 cursor-pointer hover:text-gray-700" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
                <hr class="my-2 ml-16 border-gray-200">
                <div class="flex flex-row pt-1 md-10 md:ml-16">
                    <img class="w-12 h-12 border-2 border-gray-300 rounded-full" alt="Emily's avatar"
                        src="https://images.unsplash.com/photo-1581624657276-5807462d0a3a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&fit=facearea&faces=1&faceindex=1&facepad=2.5&w=500&h=500&q=80">
                    <div class="flex-col mt-1">
                        <div class="flex items-center flex-1 px-4 font-bold leading-tight">Emily
                            <span class="ml-2 text-xs font-normal text-gray-500">5 days ago</span>
                        </div>
                        <div class="flex-1 px-2 ml-2 text-xs font-medium leading-loose text-gray-600">I created it using
                            TailwindCSS
                        </div>
                        <button class="inline-flex items-center px-1 pt-2 ml-1 flex-column">
                            <svg class="w-5 h-5 ml-2 text-gray-600 cursor-pointer fill-current hover:text-gray-900"
                                viewBox="0 0 95 78" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M29.58 0c1.53.064 2.88 1.47 2.879 3v11.31c19.841.769 34.384 8.902 41.247 20.464 7.212 12.15 5.505 27.83-6.384 40.273-.987 1.088-2.82 1.274-4.005.405-1.186-.868-1.559-2.67-.814-3.936 4.986-9.075 2.985-18.092-3.13-24.214-5.775-5.78-15.377-8.782-26.914-5.53V53.99c-.01 1.167-.769 2.294-1.848 2.744-1.08.45-2.416.195-3.253-.62L.85 30.119c-1.146-1.124-1.131-3.205.032-4.312L27.389.812c.703-.579 1.49-.703 2.19-.812zm-3.13 9.935L7.297 27.994l19.153 18.84v-7.342c-.002-1.244.856-2.442 2.034-2.844 14.307-4.882 27.323-1.394 35.145 6.437 3.985 3.989 6.581 9.143 7.355 14.715 2.14-6.959 1.157-13.902-2.441-19.964-5.89-9.92-19.251-17.684-39.089-17.684-1.573 0-3.004-1.429-3.004-3V9.936z"
                                    fill-rule="nonzero" />
                            </svg>
                        </button>
                        <button class="inline-flex items-center px-1 -ml-1 flex-column">
                            <svg class="w-5 h-5 text-gray-600 cursor-pointer hover:text-gray-700"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="" v-if="post.show_comment">
                <textarea class="bg-white border border-gray-300 p-2 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="2" placeholder="Drop a comment..."></textarea>
                <div class="flex justify-end">
                    <button class="px-4 py-2 text-xs bg-indigo-600 hover:bg-indigo-700 text-white rounded">Comment</button>
                </div>
            </div>
        </div>
    </Authenticated>
    
    <SimpleModal v-if="show_upload_modal" :open="show_upload_modal" @close:modal="show_upload_modal = false" :disable_overlay="true" class="flex flex-col space-y-4 w-5/6 md:w-3/6 xl:w-2/6 2xl:w-3/12 px-6 py-8">
        <div class="flex flex-col justify-center items-center space-y-4" v-if="!generating">
            <h2 class="block mb-2 font-semibold text-gray-900 dark:text-white">What's the fun name you want to be called?</h2>
            <input type="text" :class="error_student_nickname ? 'border-red-300' : 'border-gray-300'" class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 capitalize" maxlength="10" placeholder="Max : 10 Characters" v-model="student_nickname" required>
            <button type="button" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="generateArtBook()">Generate</button>
            <a href="#" class="text-sm underline" @click="show_upload_modal = false">Cancel</a>
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
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
</script>

<script>
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';

export default {
  components: {
    simplebar,
  },
  data() {
    return {
        form:{
            status_text: '',
        },
        posts: [{
            image: 'image_1.png',
            caption: 'Day 1 - Amazing artwork from this student.',
            liked: false,
            show_comment: false,
            user_tagged: [],
            created_by: 'Noob Master',
            created_at: '2024-05-01'
        },{
            image: 'image_2.png',
            caption: 'True artist does exist.',
            liked: true,
            show_comment: false,
            user_tagged: [],
            created_by: 'Pajeet',
            created_at: '2024-04-20'
        },{
            image: 'image_3.png',
            caption: "Artistic at it's final. Can't wait for the upcoming competition for Digital Art's Student!",
            liked: false,
            show_comment: false,
            user_tagged: [],
            created_by: 'China Number 1',
            created_at: '2024-04-13'
        }],
    }
  },
  methods: {
    toggleLike(post_index){
        this.posts[post_index].liked = !this.posts[post_index].liked
    },
    toggleComment(post_index){
        this.posts[post_index].show_comment = !this.posts[post_index].show_comment
    }
  }
}
</script>

