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
        <div class="flex justify-center">
            <div class="flex-1 max-w-xl">
                <!-- <div class="bg-indigo-100 border-t border-b border-indigo-500 text-indigo-700 px-4 py-3 mb-3" role="alert">
                    <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 text-sm">
                        <p class="font-bold">You have pending fee payment</p>
                        <button class="ml-3 self-center text-sm px-2 pb-1.5 pt-1 border border-indigo-300 rounded bg-white hover:shadow">Pay now</button>
                    </div>
                </div> -->
                <!-- <div class="flex mb-3" v-if="$page.props.can.create_posts">
                    <div class="flex items-center space-x-2 bg-indigo-100 rounded px-3 py-2 font-semibold w-full cursor-pointer transform scale-100 hover:scale-105 duration-200 select-none" @click="showCreatePost">
                        <img width="44" height="44" src="https://img.icons8.com/dusk/64/create-new.png" alt="create-new"/>
                        <div class="flex flex-col">
                            <span>Create New Post</span>
                            <span class="text-xs text-gray-700">Share student activities, notices, announcements or reminder with parents.</span>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="flex flex-col bg-white p-3 shadow-md rounded">
                    
                    <textarea class="bg-white border border-gray-300 p-2 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="5" placeholder="What's happening today?" v-model="form.status_text"></textarea>
                    <div class="flex justify-between pt-2">
                        <div class="flex space-x-2">
                            <div class="self-center space-x-2 bg-blue-200 rounded px-3 py-2 text-xs font-semibold cursor-pointer transform hover:scale-105" @click="showCreatePost">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4" fill="currentColor" viewBox="0 0 512 512">
                                    <path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/>
                                </svg>
                                <span class="inline-block">Photo</span>
                            </div>
                            <div class="self-center space-x-2 bg-green-200 rounded px-3 py-2 text-xs font-semibold cursor-pointer transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4" fill="currentColor" viewBox="0 0 448 512">
                                    <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/>
                                </svg>
                                <span class="inline-block">Tag Parent</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ">
                            <button class="px-4 py-2 text-sm text-white rounded" :class="!form.status_text ? 'bg-indigo-300 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700'" :disabled="!form.status_text">Post</button>
                        </div>
                    </div>
                </div> -->
                <div class="flex items-center space-y-3 bg-white pb-3 pt-2.5 px-4 shadow rounded-xl" v-if="$page.props.posts.length">
                    <h2 class="text-lg md:text-2xl mx-1 font-extrabold">Stories</h2>
                </div>
                <div class="mt-3 flex flex-col space-y-3 bg-white py-3 px-4 shadow-md rounded-xl" v-for="post, post_index in $page.props.posts">
                    <div class="flex flex-row text-sm items-center">
                        <!-- <img class="object-cover w-12 h-12 border-2 border-gray-300 rounded-full select-none" src="https://images.unsplash.com/photo-1517070208541-6ddc4d3efbcb?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&faces=1&faceindex=1&facepad=2.5&w=500&h=500&q=80"> -->
                        <div class="flex justify-between items-center flex-1 font-bold leading-tight select-none">
                            <div class="flex flex-col mx-1">
                                <span class="text-slate-900 md:text-lg font-bold">{{ post.post_author_name }}</span>
                                <span class="text-xs font-medium text-slate-500">ALFA and Friends Maths</span>
                            </div>
                            <div class="flex items-center">
                                <TimeAgo class="text-gray-500 font-medium text-xs" :datetime="post.post_date"></TimeAgo>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <span class="text-sm text-slate-800">{{ post.post_title }}</span>
                    <!-- <template> -->
                        <Carousel v-if="post.post_images.length" :mouseDrag="post.post_images.length > 1" :touchDrag="post.post_images.length > 1">
                          <Slide v-for="image, image_index in post.post_images" :key="image">
                            <div class="carousel__item h-full">
                                <img :src="'storage/posts/' + image.image_filename" class="select-none h-full" @dblclick="toggleLike(post_index, post.post_id)">
                            </div>
                          </Slide>
                      
                          <template #addons>
                            <Navigation v-if="post.post_images.length > 1"/>
                            <!-- <Pagination v-if="post.post_images.length > 1"/> -->
                          </template>
                        </Carousel>
                      <!-- </template> -->
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
                        <!-- <div class="" @click="toggleComment(post_index)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-7 w-7 text-gray-500 hover:text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9c.1-.2 .2-.3 .3-.5z"/>
                            </svg>
                        </div> -->
                    </div>
                    <!-- <div class="flex-col w-full py-4 bg-white sm:px-4 sm:py-4 md:px-4 rounded-lg border text-sm">
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
                                    <svg class="8 h-5 ml-2 text-gray-600 cursor-pointer fill-current hover:text-gray-900"
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
                    </div> -->
        
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
        </div>
    </Authenticated>
    
    <SimpleModal :isOpen="show_create_post" @close="this.show_create_post = false">
        <template #header v-if="!show_add_tag">Create Post</template>
        <div class="flex flex-col justify-center items-start space-y-4" v-if="!show_add_tag">
            <textarea class="bg-white border border-gray-300 p-2 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="3" placeholder="What's happening today?" v-model="form.caption"></textarea>
            <!-- <div class="overflow-x-auto scrollbar"> -->
            <div class="w-full" v-if="form.photos.length">
                <div class="overflow-x-auto scrollbar pb-3">
                    <div class="flex space-x-4">
                        <div class="relative" v-for="(photo, photo_index) in form.photos" :key="photo_index">
                            <div class="relative w-28 h-28">
                                <img :src="photo.url" class="w-full h-full" />
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-black bg-opacity-50">
                                    <button class="text-xs py-1 px-2 rounded text-red-500 font-semibold bg-white" @click="removePhoto(photo_index)">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600" @change="changePhoto">
                    <div class="flex flex-col items-center justify-center py-6">
                        <svg class="w-8 h-8 mb-1 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400 ">
                            <span class="font-semibold">Click to upload</span>
                        </p>
                        <span class="text-xs text-center text-slate-500">Hold <strong>Shift</strong> or <strong>CTRL</strong> and click on image to select multiple images</span>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" multiple/>
                </label>
            </div> 
            <div class="flex w-full">
                <div class="flex space-x-1 items-center text-white bg-blue-600 py-2 px-3 rounded cursor-pointer" @click="showAddTag">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="h-5 w-5 text-white" fill="currentColor">
                        <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c10 0 18.8-4.9 24.2-12.5l-99.2-99.2c-14.9-14.9-23.3-35.1-23.3-56.1v-33c-15.9-4.7-32.8-7.2-50.3-7.2H178.3zM384 224c-17.7 0-32 14.3-32 32v82.7c0 17 6.7 33.3 18.7 45.3L478.1 491.3c18.7 18.7 49.1 18.7 67.9 0l73.4-73.4c18.7-18.7 18.7-49.1 0-67.9L512 242.7c-12-12-28.3-18.7-45.3-18.7H384zm24 80a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/>
                    </svg>
                    <span class="text-sm">Tags</span>
                </div>
            </div>
            <button type="button" class="text-white font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" :class="(form.photos.length || form.caption) && form.tagged_students.length ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-indigo-400 cursor-not-allowed'" :disabled="(!form.caption || !form.photos.length) && !form.tagged_students" @click="post">Post</button>
            <button type="button" class="text-white bg-gray-400 hover:bg-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="show_create_post = false">Cancel</button>
        </div>
        <div class="" v-if="show_add_tag">
            <div class="flex items-center mb-2 rounded-t text-xl font-semibold dark:text-white text-slate-800">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5 cursor-pointer" fill="currentColor" @click="show_add_tag = false">
                    <path d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z"/>
                </svg>
                <h3 class="flex-1 text-center text-lg">Tag Students</h3>
            </div>
            <hr class="mb-3">
            <div class="">
                <Multiselect 
                    v-debounce:1s="findStudents"
                    :mode="'tags'"
                    @open="showAddTag"
                    v-model="form.tagged_students" 
                    :loading="loading.students"
                    :options="student_list"
                    valueProp="id"
                    placeholder="Search for students"
                    label="name"
                    :noOptionsText="'No items'"
                    :noResultsText="'No items'"
                    :show-options="false"
                    :closeOnSelect="false"
                    :canDeselect="false"
                    :searchable="true"
                    :minChars="1"
                    :classes="{
                        container: 'relative mx-auto w-full flex items-center justify-end box-border rounded border-gray-200 shadow-sm cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none mt-0',
                        containerDisabled: 'cursor-default bg-gray-100',
                        containerOpen: 'rounded-b-none',
                        containerOpenTop: 'rounded-t-none',
                        containerActive: 'ring-0 ring-opacity-30',
                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                        search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 rtl:pl-0 rtl:pr-3.5 h-10',
                        tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2 rtl:pl-0 rtl:pr-2',
                        tag: 'bg-indigo-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',
                        tagDisabled: 'pr-2 opacity-50 rtl:pl-2',
                        tagWrapper: 'overflow-hidden overflow-ellipsis',
                        tagRemove: 'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                        tagRemoveIcon: 'multiselect-tag-remove-icon bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60 hover:scale-105',
                        tagsSearchWrapper: 'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                        tagsSearch: 'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full',
                        tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
                        placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5 text-sm',
                        caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none rtl:mr-0 rtl:ml-3.5',
                        caretOpen: 'rotate-180 pointer-events-auto',
                        clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 rtl:pr-0 rtl:pl-3.5',
                        clearIcon: 'multiselect-tag-remove-icon w-10 h-4 py-px box-content inline-block',
                        dropdown: 'max-h-44 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b scrollbar',
                        dropdownTop: '-translate-y-full top-px bottom-auto rounded-b-none rounded-t ',
                        dropdownHidden: '',
                        options: 'flex flex-col p-0 m-0 list-none',
                        optionsTop: '',
                        option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                        optionPointed: 'text-gray-800 bg-gray-100',
                        optionSelected: 'text-white bg-indigo-500',
                        optionDisabled: 'text-gray-300 cursor-not-allowed',
                        optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                        optionSelectedDisabled: 'text-indigo-100 bg-indigo-500 bg-opacity-50 cursor-not-allowed',
                        noOptions: 'py-2 px-3 text-gray-600 bg-white text-left text-sm',
                        noResults: 'py-2 px-3 text-gray-600 bg-white text-left text-sm',
                        fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                        spacer: 'h-9 py-px box-content',
                    }"
                >
                </Multiselect>
            </div>
        </div>
    </SimpleModal>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
import { debounce } from 'vue-debounce'
</script>

<script>
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';
import Multiselect from '@vueform/multiselect'
import TimeAgo from '@/Components/TimeAgo.vue'
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import axios from 'axios'

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

export default {
  components: {
    simplebar, Multiselect, TimeAgo, 
    Carousel,
    Slide,
    Pagination,
    Navigation,
  },
  data() {
    return {
        show_create_post: false,
        show_add_tag: false,
        loading:{
            students: false,
        },
        student_list: [],
        form:{
            caption: '',
            photos: [],
            tagged_students: []
        },
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
    toggleComment(post_index){
        this.posts[post_index].show_comment = !this.posts[post_index].show_comment
    },
    showCreatePost(){
        this.show_create_post = true
    },
    showAddTag(){
        this.show_add_tag = true
    },
    changePhoto({ target }) {
        const { files } = target;
        if (files && files.length > 0) {
            const filesArray = Array.from(files);
            filesArray.forEach((file)=>{
                this.read(file, target)
                .then((data) => {
                    this.form.photos.push({
                        'name' :Date.now() + Math.floor(Math.random() * 1000),
                        'url' :data.url,
                        'file':file
                    })
                })
                .catch(this.alert);
            })
        }
    },
    read(file, event) {
        return new Promise((resolve, reject) => {
            if (!file) {
                resolve();
                return;
            }
            if (REGEXP_MIME_TYPE_IMAGES.test(file.type)) {
                if (URL) {
                    resolve({
                        loaded: true,
                        name: file.name,
                        type: file.type,
                        url: URL.createObjectURL(file),
                    });
                } else {
                    alert('Your browser is not supported.');
                }
            } else {
                alert(`Please select a valid image file.`);
            }
        });
    },
    removePhoto(photo_index){
        this.form.photos.splice(photo_index, 1)
    },
    findStudents(query){
        if(query){
            this.loading.students = true
            axios.get(route('students.find'), {
                params: {
                    'keyword': query
                }
            })
            .then((res) => {
                console.log(res)
                this.student_list = res.data.length > 0 ? res.data : []
                this.loading.students = false
            });
        }
    },
    post(){
        this.$inertia.post(route('parent.create_post'), this.form, {preserveState: false})
    },
    isLikedByCurrentStudent(post_index){
      return this.$page.props.posts[post_index].post_likes.some(student => student.liked_by == this.$page.props.current_active_child.student_id);
    }
  }
}
</script>

