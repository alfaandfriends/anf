<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Stories" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="flex space-x-1 justify-end mb-3" v-if="$page.props.can.create_stories">
                <BreezeButton @click="openAddStoryModal">Add Story</BreezeButton>
            </div>
            <hr class="my-3 border border-dashed border-gray-400">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3" @click.stop>
                <div class="relative w-full">
                    <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                </div>
                <div class="relative w-full">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        v-model="params.centre_id"
                        valueProp="ID"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.allowed_centres"
                        :clearOnSelect="true"
                        :clearOnDeselect="true"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="label"
                        label="label"
                        placeholder="All Centres"
                        :classes="{
                            container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerActive: 'border-2 border-gray-300',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
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
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
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
                </div>
                <div class="relative w-full">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        v-model="params.programme_id"
                        valueProp="id"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.programmes"
                        :clearOnSelect="true"
                        :closeOnDeselect="true"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="name"
                        label="name"
                        placeholder="All Programmes"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-gray-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
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
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
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
                        <template #singlelabel="{ value }">
                            <div class="multiselect-single-label">
                                {{ value.name }}
                            </div>
                        </template>
                        <template #option="{ option }">
                            {{ option.name }} ({{ option.country_name }})
                        </template>
                    </Multiselect>
                </div>
                <div class="w-full self-center">
                    <BreezeButton buttonType="gray" class="py-2 px-3" :route="route('art_gallery')">Clear Search</BreezeButton>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="shadow overflow--x-auto border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="1%">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="39%">Title</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="15%">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="15%">Reactions</th>
                                <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="15%">Comment</th> -->
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="!$page.props.stories.data.length">
                                <td class="text-center" colspan="10">
                                    <div class="p-3">
                                        No Record Found! 
                                    </div>
                                </td>
                            </tr> 
                            <tr class="hover:bg-gray-200" v-for="(result, index) in $page.props.stories.data" :key="result.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-700">{{ index+1 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <div class="flex space-x-4">
                                            <!-- <img :src="'/storage/stories/' + result.images[0].image_filename" class="h-10 w-10 rounded cursor-pointer" alt=""> -->
                                            <div class="flex flex-col max-w-md space-y-1">
                                                <span class="truncate" :title="result.story_title">{{ result.story_title }}</span>
                                                <div class="text-xs text-slate-500">{{ result.story_author_name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ moment(result.story_date).format('DD MMM Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="py-1 px-2 border border-indigo-500 bg-indigo-100 rounded-md text-indigo-600 cursor-pointer text-xs font-semibold" @click="show_likes_modal = true">{{ result.reaction_count }} Reactions</span>
                                </td>
                                <!-- <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="py-1 px-2 border border-blue-500 bg-blue-100 rounded-md text-blue-600 cursor-pointer text-xs font-semibold" @click="show_comments_modal = true">{{ result.reaction_count }} Comments</span>
                                </td> -->
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <BreezeButton buttonType="warning" @click="openEditStoryModal(index)" v-if="$page.props.can.edit_stories">Edit</BreezeButton>
                                        <BreezeButton buttonType="danger" @click="deleteStory(result.story_id)" v-if="$page.props.can.delete_stories">Delete</BreezeButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :page_data="$page.props.stories" :params="params"></Pagination>
            </div>
            <ConfirmationModal 
                :show="isOpen" 
                @close="isOpen = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Story"
                confirmationText="Are you sure want to delete this story?"
                confirmationButton="Delete"
                confirmationMethod="delete"
                :confirmationRoute="confirmationRoute"
                :confirmationData="confirmationData"
            />
            <FsLightbox
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
                        <div class="flex flex-col justify-center items-start space-y-4" v-if="!show_add_tag">
                            <Multiselect 
                                v-model="form.programme_id"
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
                            >
                                <template #singlelabel="{ value }">
                                    <div class="multiselect-single-label">
                                        {{ value.name }}
                                    </div>
                                </template>
                                <template #option="{ option }">
                                    {{ option.name }} ({{ option.country_name }})
                                </template>
                            </Multiselect>
                            <textarea class="bg-white border border-gray-300 p-3 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="3" placeholder="What's happening today?" v-model="form.caption"></textarea>
                            <div class="w-full" v-if="form.photos.length">
                                <div class="overflow-x-auto scrollbar pb-3">
                                    <div class="flex space-x-4">
                                        <div class="relative" v-for="(photo, photo_index) in form.photos" :key="photo_index">
                                            <div class="relative w-28 h-28">
                                                <img :src="photo.url" class="w-full h-full rounded-lg" />
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-black bg-opacity-50 rounded-lg">
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
                                        <span class="text-xs text-center text-slate-500">Hold <strong>Shift</strong> or <strong>CTRL</strong> and click on images to select multiple</span>
                                    </div>
                                    <input id="dropzone-file" type="file" class="hidden" multiple/>
                                </label>
                            </div> 
                            <button type="button" class="text-white font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" :class="(form.photos.length || form.caption) ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-indigo-400 cursor-not-allowed'" @click="post">Post</button>
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
                                v-model="form_edit.programme_id"
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
                                <template #singlelabel="{ value }">
                                    <div class="multiselect-single-label">
                                        {{ value.name }}
                                    </div>
                                </template>
                                <template #option="{ option }">
                                    {{ option.name }} ({{ option.country_name }})
                                </template>
                            </Multiselect>
                            <textarea class="bg-white border border-gray-300 p-3 rounded w-full resize-none focus:ring-0 focus:border-2 focus:border-indigo-300 text-sm" rows="3" placeholder="What's happening today?" v-model="form_edit.caption"></textarea>
                            <div class="w-full" v-if="form_edit.photos.length">
                                <div class="overflow-x-auto scrollbar pb-3">
                                    <div class="flex space-x-4">
                                        <div class="relative" v-for="(photo, photo_index) in form_edit.photos" :key="photo_index">
                                            <div class="relative w-28 h-28">
                                                <img :src="photo.url ? photo.url : '/storage/stories/' + photo.image_filename" class="w-full h-full rounded-lg" />
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-black bg-opacity-50 rounded-lg">
                                                    <button class="text-xs py-1 px-2 rounded text-red-500 font-semibold bg-white" @click="removePhotoEditStory(photo_index)">
                                                        Delete
                                                    </button>
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
                            <button type="button" class="text-white font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" :class="(form_edit.photos.length || form_edit.caption) ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-indigo-400 cursor-not-allowed'" @click="savePost">Save</button>
                            <button type="button" class="text-white bg-gray-400 hover:bg-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center" @click="show_edit_story_modal = false">Cancel</button>
                        </div>
                    </div>
                </template>
            </Modal >
            <!-- <Modal :showModal="show_likes_modal" modalType="sm" @hideModal="show_likes_modal = false">
                <template v-slot:header>
                    <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
                        <h3 class="text-gray-900 text font-semibold">                
                            Likes
                        </h3>       
                        <button type="button" @click="show_likes_modal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>                 
                </template>
                <template v-slot:content>
                    <div class="">
                        <div class="flex justify-center w-full">
                            <img :src="artwork.file_location" class="object-scale-down" alt="">
                        </div>
                    </div>
                </template>
                <template v-slot:footer>
                    <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                        <BreezeButton buttonType="gray" @click="show_likes_modal = false">Close</BreezeButton>
                    </div>
                </template>
            </Modal >
            <Modal :showModal="show_comments_modal" modalType="sm" @hideModal="show_comments_modal = false">
                <template v-slot:header>
                    <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
                        <h3 class="text-gray-900 font-semibold">                
                            Comments
                        </h3>       
                        <button type="button" @click="show_comments_modal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>                 
                </template>
                <template v-slot:content>
                    <div class="">
                        <div class="flex justify-center w-full">
                            <img :src="artwork.file_location" class="object-scale-down" alt="">
                        </div>
                    </div>
                </template>
                <template v-slot:footer>
                    <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                        <BreezeButton buttonType="gray" @click="show_comments_modal = false">Close</BreezeButton>
                    </div>
                </template>
            </Modal> -->
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'
import axios from 'axios'
import Modal from '@/Components/Modal.vue'
import { debounce } from 'vue-debounce'
import Multiselect from '@vueform/multiselect'
import FsLightbox from "fslightbox-vue/v3";
import moment from "moment";

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head, Link, Modal, Pagination, Multiselect, FsLightbox
    },
    props: {
        filter: Object,
    },
    data(){
        return{
            isOpen: false,
            searching: false,
            show_add_story_modal: false,
            show_edit_story_modal: false,
            show_likes_modal: false,
            show_comments_modal: false,
            confirmationData: '',
            confirmationRoute: '',
            lightbox: {
                open: false,
                src: [],
            },
            student_status: [{
                'id' : 1,
                'name' : 'Active'
            },{
                'id' : 0,
                'name' : 'Inactive'
            }],
            form:{
                programme_id: '',
                caption: '',
                photos: [],
            },
            form_edit:{
                story_id: '',
                programme_id: '',
                caption: '',
                photos: [],
                photos_to_delete: [],
            },
            params: {
                search: this.filter.search ? this.filter.search : '',
                centre_id: this.filter.centre_id ? this.filter.centre_id : '',
                programme_id: this.filter.programme_id ? this.filter.programme_id : '',
                theme: this.filter.theme ? this.filter.theme : '',
                status: this.filter.status ? this.filter.status : '',
            },
            imageExists: false,
            artwork:{
                lesson: '',
                activity: '',
                file_location: ''
            }
        }
    },
    methods: {
        openAddStoryModal(){
            this.show_add_story_modal = true
        },
        openEditStoryModal(index){
            this.form_edit.story_id =   this.$page.props.stories.data[index].story_id
            this.form_edit.programme_id =   this.$page.props.stories.data[index].story_programme_id
            this.form_edit.caption      =   this.$page.props.stories.data[index].story_title
            this.form_edit.photos       =   this.$page.props.stories.data[index].images
            // console.log(index)
            this.show_edit_story_modal = true
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
        changePhotoEditStory({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                const filesArray = Array.from(files);
                filesArray.forEach((file)=>{
                    this.read(file, target)
                    .then((data) => {
                        this.form_edit.photos.push({
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
        removePhotoEditStory(photo_index){
            if(this.form_edit.photos[photo_index].id){
                this.form_edit.photos_to_delete.push(this.form_edit.photos[photo_index].id)
            }
            this.form_edit.photos.splice(photo_index, 1)
        },
        post(){
            if(this.form.caption || this.form.photos.length){
                this.$inertia.post(route('stories.store'), this.form, {preserveState: false})
            }
        },
        savePost(){
            if(this.form_edit.caption || this.form_edit.photos.length){
                this.$inertia.post(route('stories.update'), this.form_edit, {preserveState: false})
            }
        },
        // viewArtwork(artwork_file_location){
        //     fetch(window.location.origin+'/storage/art_gallery/'+artwork_file_location)
        //     .then(response => {
        //         if (!response.ok) {
        //             this.lightbox.src = [window.location.origin+'/images/no_image.jpg']
        //         }
        //         else{
        //             this.lightbox.src  = [window.location.origin+'/storage/art_gallery/'+artwork_file_location]
        //         }
        //         this.lightbox.open         = !this.lightbox.open
        //     })
        // },
        deleteStory(story_id){
            this.confirmationRoute = 'stories.destroy'
            this.confirmationData = story_id
            this.isOpen = true
        },
        search(){
            this.$inertia.get(this.route('stories'), this.params, {replace: true, preserveState: true});
        }
    }
}
</script>