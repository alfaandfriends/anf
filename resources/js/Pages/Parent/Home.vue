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
    <Authenticated @scroll="handleScroll">
        <div class="flex justify-center">
            <div class="flex-1 max-w-xl">
                <!-- <div class="bg-indigo-100 border-t border-b border-indigo-500 text-indigo-700 px-4 py-3 mb-3" role="alert">
                    <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 text-sm">
                        <p class="font-bold">You have pending fee payment</p>
                        <button class="ml-3 self-center text-sm px-2 pb-1.5 pt-1 border border-indigo-300 rounded bg-white hover:shadow">Pay now</button>
                    </div>
                </div> -->
                <div class="flex mb-3" v-if="$page.props.can.create_stories">
                    <div class="flex items-center space-x-2 bg-indigo-100 rounded px-3 py-2 font-semibold w-full cursor-pointer transform scale-100 hover:scale-105 duration-200 select-none" @click="showCreatePost">
                        <img width="44" height="44" src="https://img.icons8.com/dusk/64/create-new.png" alt="create-new"/>
                        <div class="flex flex-col">
                            <span>Create New Story</span>
                            <span class="text-xs text-gray-700">Share student activities, notices, announcements or reminder with parents.</span>
                        </div>
                    </div>
                </div>
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
                                <Menu as="div" class="relative inline-block text-left" v-if="$page.props.can.view_student_stories">
                                    <MenuButton class="pl-3 py-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 128 512">
                                            <path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/>
                                        </svg>
                                    </MenuButton>
                                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <div class="py-1 text-sm">
                                            <a class="cursor-pointer block px-4 py-2 text-sm hover:bg-indigo-100 text-gray-900" @click="openEditStoryModal(story_index)">Edit</a>
                                            <a class="cursor-pointer block px-4 py-2 text-sm hover:bg-indigo-100 text-gray-900" @click="deleteStory(story.story_id)">Delete</a>
                                        </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <span class="text-sm text-slate-800">{{ story.story_title }}</span>
                    <Carousel v-if="story.images.length" :mouseDrag="story.images.length > 1" :touchDrag="story.images.length > 1">
                        <Slide v-for="image, image_index in story.images" :key="image">
                        <div class="carousel__item h-full cursor-pointer" @click="viewImage(image)">
                            <img :src="'/storage/stories/' + image.image_filename" class="select-none h-full" @dblclick="toggleLike(story_index, story.story_id)">
                        </div>
                        </Slide>
                        <template #addons>
                        <Navigation v-if="story.images.length > 1"/>
                        </template>
                    </Carousel>
                    <div class="flex items-center space-x-4">
                        <div class="">
                            <svg v-if="isLikedByParent(story_index)" @click="toggleLike(story_index, story.story_id)" xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6 text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/>
                            </svg>
                            <svg v-else @click="toggleLike(story_index, story.story_id)" xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6 text-gray-500 hover:text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                            </svg>
                        </div>
                        <!-- <span class="text-xs font-semibold select-none" v-if="isLikedByParent(story_index) && !$page.props.can.create_stories">You liked this</span> -->
                        <div class="" @click="toggleComment(story_index)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6 text-gray-500 hover:text-red-500 cursor-pointer" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9c.1-.2 .2-.3 .3-.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-2" v-if="show_comment[story_index]">
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
        </div>
    </Authenticated>
    
    <FsLightbox
        class="z-50"
        :toggler="lightbox.open"
        :sources="lightbox.src"
        :exitFullscreenOnClose="true"
    />
    <Modal :showModal="show_add_story_modal" modalType="sm" @hideModal="show_add_story_modal = false">
        <template v-slot:header>
            <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
                <h3 class="text-gray-900 text font-semibold">                
                    Add Story
                </h3>       
                <button type="button" @click="show_add_story_modal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>                 
        </template>
        <template v-slot:content>
            <div class="p-3">
                <div class="flex flex-col justify-center items-start space-y-2" v-if="!show_add_tag">
                    <Multiselect 
                        v-model="add_story.form.programme_id"
                        valueProp="id"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.programmes"
                        :clearOnSelect="true"
                        :closeOnDeselect="true"
                        :canClear="false"
                        :canDeselect="false"
                        trackBy="name"
                        label="name"
                        placeholder="Select programme"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-indigo-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }"
                    />
                    <Multiselect 
                        v-model="add_story.form.centre_id"
                        valueProp="ID"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.centres"
                        :clearOnSelect="true"
                        :closeOnDeselect="true"
                        :canClear="false"
                        :canDeselect="false"
                        trackBy="label"
                        label="label"
                        placeholder="Select centre"
                        :classes="{
                            container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerActive: 'border-2 border-indigo-300',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                            clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                            clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none w-full',
                            group: 'p-0 m-0',
                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                            groupLabelPointable: 'cursor-pointer',
                            groupLabelPointed: 'bg-gray-300 text-black-700',
                            groupLabelSelected: 'bg-gray-100 text-black',
                            groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                            groupOptions: 'p-0 m-0',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                            optionPointed: 'text-gray-800 bg-gray-100',
                            optionSelected: 'text-white bg-indigo-500',
                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                        }"
                    />
                    <div class="w-full grid grid-cols-1 2xl:grid-cols-2 gap-2">
                        <Multiselect 
                            v-model="add_story.find.class_types"
                            valueProp="id"
                            :appendNewOption="false"
                            :searchable="true"
                            :options="$page.props.class_types"
                            :clearOnSelect="true"
                            :closeOnDeselect="true"
                            :canClear="false"
                            :canDeselect="true"
                            trackBy="name"
                            label="name"
                            placeholder="Select class type (optional)"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-indigo-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }"
                        />
                        <Multiselect 
                            v-model="add_story.find.levels"
                            valueProp="id"
                            :appendNewOption="false"
                            :searchable="true"
                            :options="add_story.list.levels"
                            :clearOnSelect="true"
                            :closeOnDeselect="true"
                            :canClear="false"
                            :canDeselect="true"
                            trackBy="level"
                            label="level"
                            placeholder="Select level (optional)"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-indigo-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }"
                        >
                            <template v-slot:singlelabel="{ value }">
                                <div class="multiselect-single-label">
                                    Level {{ value.level }}
                                </div>
                            </template>
                            <template v-slot:option="{ option }">
                                Level {{ option.level }}
                            </template>
                        </Multiselect>
                    </div>
                    <Multiselect
                        id="students"
                        mode="multiple"
                        v-model="add_story.form.students"
                        valueProp="id"
                        :multiple="true"
                        :searchable="true"
                        :options="add_story.students"
                        :closeOnSelect="false"
                        :clearOnSelect="true"
                        :canClear="false"
                        :hideSelected="false"
                        :groups="true"
                        groupOptions="options"
                        groupLabel="select_all"
                        :groupSelect="true"
                        placeholder="Select students"
                        trackBy="name"
                        label="name"
                        :classes="{
                            container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm p-0',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerActive: 'border-2 border-indigo-300',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            multipleLabel: 'pl-3 flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug',
                            search: 'pl-3 w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                            clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                            clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none w-full',
                            group: 'p-0 m-0',
                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-medium cursor-default leading-normal text-slate-800',
                            groupLabelPointable: 'cursor-pointer',
                            groupLabelPointed: 'text-slate-800',
                            groupLabelSelected: 'text-slate-800',
                            groupLabelSelectedPointed: 'text-slate-80',
                            groupOptions: 'p-0 m-0',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                            optionPointed: 'text-slate-800 bg-indigo-50',
                            optionSelected: 'text-slate-800 bg-indigo-200',
                            optionSelectedPointed: 'text-slate-800 bg-indigo-200',
                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                        }"
                        >
                        <template v-slot:multiplelabel="{ values }">
                            <div class="multiselect-multiple-label">
                              {{ values.length }} {{ values.length > 1 ? 'students'  :'student' }} selected
                            </div>
                          </template>
                    </Multiselect>
                    <textarea class="bg-white border border-gray-300 p-3 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="3" placeholder="What's happening today?" v-model="add_story.form.caption"></textarea>
                    <div class="w-full" v-if="add_story.form.photos.length">
                        <div class="overflow-x-auto scrollbar pb-3">
                            <div class="flex space-x-4">
                                <div class="relative" v-for="(photo, photo_index) in add_story.form.photos" :key="photo_index">
                                    <div class="relative w-28 h-28">
                                        <img :src="photo.url" class="w-full h-full rounded-lg" />
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-black bg-opacity-50 rounded-lg">
                                            <div class="flex flex-col space-y-2">
                                                <button class="text-xs py-1 px-2 rounded text-indigo-500 font-semibold bg-white" @click="viewImage(photo)">
                                                    View
                                                </button>
                                                <button class="text-xs py-1 px-2 rounded text-red-500 font-semibold bg-white" @click="removePhoto(photo_index)">
                                                    Delete
                                                </button>
                                            </div>
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
                                <span class="text-xs text-center text-slate-500">Hold <strong>Shift</strong> or <strong>CTRL</strong> and click on images to select multiple</span>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" multiple/>
                        </label>
                    </div> 
                    <button type="button" class="text-white font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" :class="(add_story.form.photos.length || add_story.form.caption) && add_story.form.students.length ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-indigo-400 cursor-not-allowed'" @click="post">Post</button>
                    <button type="button" class="text-white bg-gray-400 hover:bg-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="show_add_story_modal = false">Cancel</button>
                </div>
            </div>
        </template>
    </Modal >
    <Modal :showModal="show_edit_story_modal" modalType="sm" @hideModal="show_edit_story_modal = false">
        <template v-slot:header>
            <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
                <h3 class="text-gray-900 text font-semibold">                
                    Edit Story
                </h3>
                <button type="button" @click="show_edit_story_modal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>                 
        </template>
        <template v-slot:content>
            <div class="p-3">
                <div class="flex flex-col justify-center items-start space-y-4" v-if="!show_add_tag">
                    <Multiselect 
                        v-model="edit_story.form.programme_id"
                        valueProp="id"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.programmes"
                        :clearOnSelect="true"
                        :closeOnDeselect="true"
                        :canClear="false"
                        :canDeselect="false"
                        trackBy="name"
                        label="name"
                        placeholder="Select programme"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-indigo-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }"
                    />
                    <Multiselect 
                        v-model="edit_story.form.centre_id"
                        valueProp="ID"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.centres"
                        :clearOnSelect="true"
                        :closeOnDeselect="true"
                        :canClear="false"
                        :canDeselect="false"
                        trackBy="label"
                        label="label"
                        placeholder="Select centre"
                        :classes="{
                            container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerActive: 'border-2 border-indigo-300',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                            clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                            clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none w-full',
                            group: 'p-0 m-0',
                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                            groupLabelPointable: 'cursor-pointer',
                            groupLabelPointed: 'bg-gray-300 text-black-700',
                            groupLabelSelected: 'bg-gray-100 text-black',
                            groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                            groupOptions: 'p-0 m-0',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                            optionPointed: 'text-gray-800 bg-gray-100',
                            optionSelected: 'text-white bg-indigo-500',
                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                        }"
                    />
                    <div class="w-full grid grid-cols-1 2xl:grid-cols-2 gap-2">
                        <Multiselect 
                            v-model="edit_story.find.class_types"
                            valueProp="id"
                            :appendNewOption="false"
                            :searchable="true"
                            :options="$page.props.class_types"
                            :clearOnSelect="true"
                            :closeOnDeselect="true"
                            :canClear="false"
                            :canDeselect="true"
                            trackBy="name"
                            label="name"
                            placeholder="Select class type (optional)"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-indigo-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }"
                        />
                        <Multiselect 
                            v-model="edit_story.find.levels"
                            valueProp="id"
                            :appendNewOption="false"
                            :searchable="true"
                            :options="edit_story.list.levels"
                            :clearOnSelect="true"
                            :closeOnDeselect="true"
                            :canClear="false"
                            :canDeselect="true"
                            trackBy="level"
                            label="level"
                            placeholder="Select level (optional)"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-indigo-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }"
                        >
                            <template v-slot:singlelabel="{ value }">
                                <div class="multiselect-single-label">
                                    Level {{ value.level }}
                                </div>
                            </template>
                            <template v-slot:option="{ option }">
                                Level {{ option.level }}
                            </template>
                        </Multiselect>
                    </div>
                    <Multiselect
                        id="edit_students"
                        mode="multiple"
                        v-model="edit_story.form.students"
                        valueProp="id"
                        :multiple="true"
                        :searchable="true"
                        :options="edit_story.students"
                        :closeOnSelect="false"
                        :clearOnSelect="true"
                        :canClear="false"
                        :hideSelected="false"
                        :groups="true"
                        groupOptions="options"
                        groupLabel="select_all"
                        :groupSelect="true"
                        placeholder="Select students"
                        trackBy="name"
                        label="name"
                        :classes="{
                            container: 'relative w-full flex items-center justify-end cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-10 text-sm p-0',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerActive: 'border-2 border-indigo-300',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            multipleLabel: 'pl-3 flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug',
                            search: 'pl-3 w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-indigo-300 text-base font-sans bg-white rounded-lg text-sm',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 text-gray-500',
                            clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                            clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none w-full',
                            group: 'p-0 m-0',
                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-medium cursor-default leading-normal text-slate-800',
                            groupLabelPointable: 'cursor-pointer',
                            groupLabelPointed: 'text-slate-800',
                            groupLabelSelected: 'text-slate-800',
                            groupLabelSelectedPointed: 'text-slate-80',
                            groupOptions: 'p-0 m-0',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3.5 text-sm',
                            optionPointed: 'text-slate-800 bg-indigo-50',
                            optionSelected: 'text-slate-800 bg-indigo-200',
                            optionSelectedPointed: 'text-slate-800 bg-indigo-200',
                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                        }"
                        >
                        <template v-slot:multiplelabel="{ values }">
                            <div class="multiselect-multiple-label">
                              {{ values.length }} {{ values.length > 1 ? 'students'  :'student' }} selected
                            </div>
                          </template>
                    </Multiselect>
                    <textarea class="bg-white border border-gray-300 p-3 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="3" placeholder="What's happening today?" v-model="edit_story.form.caption"></textarea>
                    <div class="w-full" v-if="edit_story.form.photos.length">
                        <div class="overflow-x-auto scrollbar pb-3">
                            <div class="flex space-x-4">
                                <div class="relative" v-for="(photo, photo_index) in edit_story.form.photos" :key="photo_index">
                                    <div class="relative w-28 h-28">
                                        <img :src="photo.url ? photo.url : '/storage/stories/' + photo.image_filename" class="w-full h-full rounded-lg object-cover" />
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-black bg-opacity-50 rounded-lg">
                                            <div class="flex flex-col space-y-2">
                                                <button class="text-xs py-1 px-2 rounded text-indigo-500 font-semibold bg-white" @click="viewImage(photo)">
                                                    View
                                                </button>
                                                <button class="text-xs py-1 px-2 rounded text-red-500 font-semibold bg-white" @click="removePhotoEditStory(photo_index)">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file-2" class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600" @change="changePhotoEditStory">
                            <div class="flex flex-col items-center justify-center py-6">
                                <svg class="w-8 h-8 mb-1 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400 ">
                                    <span class="font-semibold">Click to upload</span>
                                </p>
                                <span class="text-xs text-center text-slate-500">Hold <strong>Shift</strong> or <strong>CTRL</strong> and click on images to select multiple</span>
                            </div>
                            <input id="dropzone-file-2" type="file" class="hidden" multiple/>
                        </label>
                    </div> 
                    <button type="button" class="text-white font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" :class="(edit_story.form.photos.length || edit_story.form.caption) ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-indigo-400 cursor-not-allowed'" @click="savePost">Save</button>
                    <button type="button" class="text-white bg-gray-400 hover:bg-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="show_edit_story_modal = false">Cancel</button>
                </div>
            </div>
        </template>
    </Modal >
    <ConfirmationModal 
        :show="show_delete" 
        @close="show_delete = false"
        confirmationAlert="danger"
        confirmationTitle="Delete Story"
        confirmationText="Are you sure want to delete this story?"
        confirmationButton="Delete"
        confirmationMethod="delete"
        :confirmationRoute="confirmationRoute"
        :confirmationData="confirmationData"
    />
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
import Modal from '@/Components/Modal.vue'
import TimeAgo from '@/Components/TimeAgo.vue'
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import axios from 'axios'
import moment from 'moment';
import 'moment-timezone';
import FsLightbox from "fslightbox-vue/v3";
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Compressor from 'compressorjs';

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
        show_add_story_modal: false,
        show_edit_story_modal: false,
        show_comment: [],
        show_delete: false,
        confirmationData: '',
        confirmationRoute: '',
        loading:{
            students: false,
            stories: false
        },
        student_list: [],
        form:{
            caption: '',
            photos: [],
            tagged_students: []
        },
        comments: [],
        add_story: {
            find: {
                class_types: '',
                levels: '',
            },
            list: {
                class_types: [],
                levels: [],
            },
            students: [{
                select_all: 'Select all',
                options: []
            }],
            form:{
                programme_id: '',
                centre_id: '',
                caption: '',
                photos: [],
                students: [],
            },
        },
        edit_story: {
            find: {
                class_types: '',
                levels: '',
            },
            list: {
                class_types: [],
                levels: [],
            },
            students: [{
                select_all: 'Select all',
                options: []
            }],
            form:{
                story_id: '',
                programme_id: '',
                centre_id: '',
                caption: '',
                photos: [],
                students: [],
                photos_to_delete: [],
            },
        },
        lightbox: {
            open: false,
            src: [],
        },
    }
  },
  watch: {
    'add_story.form.programme_id': {
        handler(){
            if(this.add_story.form.programme_id && this.add_story.form.centre_id){
                this.add_story.find.class_types = ''
                this.add_story.find.levels = ''
                this.add_story.students[0].options = []
                this.add_story.form.students = []

                axios.get(route('programmes.get_students', [this.add_story.form.programme_id, this.add_story.form.centre_id]))
                .then(response => {
                    this.add_story.students[0].options = response.data
                })
            }
        }
    },
    'add_story.form.centre_id': {
        handler(){
            if(this.add_story.form.programme_id && this.add_story.form.centre_id){
                this.add_story.find.class_types = ''
                this.add_story.find.levels = ''
                this.add_story.students[0].options = []
                this.add_story.form.students = []

                axios.get(route('programmes.get_students', [this.add_story.form.programme_id, this.add_story.form.centre_id]))
                .then(response => {
                    this.add_story.students[0].options = response.data
                })
            }
        }
    },
    'add_story.find.class_types': {
        handler(){
            this.add_story.find.levels = ''
            this.add_story.list.levels = []
            if(this.add_story.form.programme_id && this.add_story.form.centre_id && this.add_story.find.class_types){
                axios.get(route('classes.get_class_levels', [this.add_story.form.programme_id, this.add_story.find.class_types]))
                .then(response => {
                    this.add_story.list.levels = response.data
                })
            }
            else{
                axios.get(route('programmes.get_students', [this.add_story.form.programme_id, this.add_story.form.centre_id]))
                .then(response => {
                    this.add_story.students[0].options = response.data
                })
            }
        }
    },
    'add_story.find.levels': {
        handler(){
            this.add_story.students[0].options = []
            this.add_story.form.students = []

            if(this.add_story.form.programme_id && this.add_story.form.centre_id && this.add_story.find.levels){
                axios.get(route('programmes.get_students', [this.add_story.form.programme_id, this.add_story.form.centre_id, this.add_story.find.levels]))
                .then(response => {
                    this.add_story.students[0].options = response.data
                })
            }
            else{
                axios.get(route('programmes.get_students', [this.add_story.form.programme_id, this.add_story.form.centre_id]))
                .then(response => {
                    this.add_story.students[0].options = response.data
                })
            }
        }
    },
    'edit_story.form.programme_id': {
        handler(){
            if(this.edit_story.form.programme_id && this.edit_story.form.centre_id){
                this.edit_story.find.class_types = ''
                this.edit_story.find.levels = ''
                this.edit_story.students[0].options = []
                this.edit_story.form.students = []

                axios.get(route('programmes.get_students', [this.edit_story.form.programme_id, this.edit_story.form.centre_id]))
                .then(response => {
                    this.edit_story.students[0].options = response.data
                })
            }
        }
    },
    'edit_story.form.centre_id': {
        handler(){
            if(this.edit_story.form.programme_id && this.edit_story.form.centre_id){
                this.edit_story.find.class_types = ''
                this.edit_story.find.levels = ''
                this.edit_story.students[0].options = []
                this.edit_story.form.students = []

                axios.get(route('programmes.get_students', [this.edit_story.form.programme_id, this.edit_story.form.centre_id]))
                .then(response => {
                    this.edit_story.students[0].options = response.data
                })
            }
        }
    },
    'edit_story.find.class_types': {
        handler(){
            this.edit_story.find.levels = ''
            this.edit_story.list.levels = []
            if(this.edit_story.form.programme_id && this.edit_story.form.centre_id && this.edit_story.find.class_types){
                this.edit_story.students[0].options = []
                this.edit_story.form.students = []

                axios.get(route('classes.get_class_levels', [this.edit_story.form.programme_id, this.edit_story.find.class_types]))
                .then(response => {
                    this.edit_story.list.levels = response.data
                })
            }
            else{
                axios.get(route('programmes.get_students', [this.edit_story.form.programme_id, this.edit_story.form.centre_id]))
                .then(response => {
                    this.edit_story.students[0].options = response.data
                })
            }
        }
    },
    'edit_story.find.levels': {
        handler(){
            this.edit_story.students[0].options = []
            this.edit_story.form.students = []
            console.log(this.edit_story.form.programme_id)
            if(this.edit_story.form.programme_id && this.edit_story.form.centre_id && this.edit_story.find.levels){
                axios.get(route('programmes.get_students', [this.edit_story.form.programme_id, this.edit_story.form.centre_id, this.edit_story.find.levels]))
                .then(response => {
                    this.edit_story.students[0].options = response.data
                })
            }
            else{
                axios.get(route('programmes.get_students', [this.edit_story.form.programme_id, this.edit_story.form.centre_id]))
                .then(response => {
                    this.edit_story.students[0].options = response.data
                })
            }
        }
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
    toggleComment(index){
        this.show_comment[index] = !this.show_comment[index]
    },
    postComment(story_index, story_id){
        axios.post(route('parent.stories.comments.store'), {'story_id': story_id, 'comment' : this.comments[story_index]})
        .then(response => {
            if(response.data){
                this.$page.props.stories.data[story_index].comments.unshift({
                    'comment': this.comments[story_index],
                    'comment_user_name': this.$page.props.auth.user.display_name,
                    'created_at': moment().tz('Asia/Kuala_Lumpur').format('YYYY-MM-DD HH:mm:ss')
                })
                this.comments[story_index] = ''
            }
        });
    },
    showCreatePost(){
        this.show_add_story_modal = true
    },
    openEditStoryModal(index){
        this.edit_story.form.story_id     =   this.$page.props.stories.data[index].story_id
        this.edit_story.form.programme_id =   this.$page.props.stories.data[index].story_programme_id
        this.edit_story.form.centre_id    =   this.$page.props.stories.data[index].story_centre_id
        this.edit_story.form.caption      =   this.$page.props.stories.data[index].story_title
        this.edit_story.form.photos       =   this.$page.props.stories.data[index].images

        axios.get(route('programmes.get_students', [this.edit_story.form.programme_id, this.edit_story.form.centre_id]))
        .then(response => {
            this.edit_story.students[0].options =   []
            this.edit_story.students[0].options =   response.data
            this.edit_story.form.students       =   this.$page.props.stories.data[index].students.map(student => student.student_id);
        })

        this.show_edit_story_modal  =   true
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
    changePhoto({ target }) {
        const { files } = target;
        if (files && files.length > 0) {
            const filesArray = Array.from(files);
            filesArray.forEach((file)=>{
                this.read(file, target)
                .then((data) => {
                    new Compressor(file, {
                        quality: 0.8,
                        height: 1000,
                        width: 1000,
                        success: (result) => {
                            const blobUrl   = URL.createObjectURL(result);
                            const new_file  =   this.blobToFile(result, Date.now()+'.jpg')
                            console.log(new_file)
                            this.add_story.form.photos.push({
                                'name'  :Date.now() + Math.floor(Math.random() * 1000),
                                'url'   :blobUrl,
                                'file'  :new_file
                            })
                        },
                    });
                })
                .catch(this.alert);
            })
        }
    },
    changePhotoEditStory({ target }) {
        const { files } = target;
        if (files && files.length > 0) {
            const filesArray = Array.from(files);
            filesArray.forEach((file)=>{
                this.read(file, target)
                .then((data) => {
                    new Compressor(file, {
                        quality: 0.8,
                        height: 1000,
                        width: 1000,
                        success: (result) => {
                            const blobUrl   = URL.createObjectURL(result);
                            const new_file  =   this.blobToFile(result, Date.now()+'.jpg')
                            console.log(new_file)
                            this.edit_story.form.photos.push({
                                'name'  :Date.now() + Math.floor(Math.random() * 1000),
                                'url'   :blobUrl,
                                'file'  :new_file
                            })
                        },
                    });
                })
                .catch(this.alert);
            })
        }
    },
    removePhoto(photo_index){
        this.add_story.form.photos.splice(photo_index, 1)
    },
    removePhotoEditStory(photo_index){
        if(this.edit_story.form.photos[photo_index].id){
            this.edit_story.form.photos_to_delete.push(this.edit_story.form.photos[photo_index].id)
        }
        this.edit_story.form.photos.splice(photo_index, 1)
    },
    post(){
        if((this.add_story.form.caption || this.add_story.form.photos.length) && this.add_story.form.students.length > 0){
            this.$inertia.post(route('stories.store'), this.add_story.form, {preserveState: false})
        }
    },
    savePost(){
        if(this.edit_story.form.caption || this.edit_story.form.photos.length){
            this.$inertia.post(route('stories.update'), this.edit_story.form, {preserveState: false})
        }
    },
    handleScroll() {
      const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
      const scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
      const clientHeight = document.documentElement.clientHeight || window.innerHeight;
      
      if (scrollTop + clientHeight >= scrollHeight - 100) {
        if(this.$page.props.stories.next_page_url){
            if(!this.loading.stories){
                this.loading.stories = true
                axios.get(route('parent.student_stories'), {
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
    },
    viewImage(image){
        this.lightbox.src   = image.url ? [image.url] : [window.location.origin+'/storage/stories/' + image.image_filename]
        this.lightbox.open  = !this.lightbox.open
    },
    deleteStory(story_id){
        this.confirmationRoute = 'stories.destroy'
        this.confirmationData = story_id
        this.show_delete = true
    },
    blobToFile(blob, filename) {
        const file = new File([blob], filename, { type: blob.type });
        return file;
    }
  }
}
</script>

