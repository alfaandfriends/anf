<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
  .uploader-example {
    width: 880px;
    padding: 15px;
    font-size: 12px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .4);
  }
  .uploader-example .uploader-btn {
    margin-right: 4px;
  }
  .uploader-example .uploader-list {
    max-height: 440px;
    overflow: auto;
    overflow-x: hidden;
    overflow-y: auto;
  }
</style>

<template>
    <Head title="Art Gallery" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Upload Math Manipulative</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="title" class="block text-sm font-bold text-gray-700"> Title <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md.shadow-sm">
                                            <input type="text" name="title" id="title" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.title ? 'border-red-300' : 'border-gray-300'" v-model="form.title" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="mb-4 space-y-2" v-show="form.thumbnail.image_url == ''">
                                        <label class="block text-sm text-gray-700 font-bold"> Thumbnail </label>
                                        <div class="rounded-md bg-red-100 p-4" v-if="$page.props.errors['artwork.file']">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <ExclamationIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                                                </div>
                                                <div class="ml-3">
                                                    <h3 class="text-sm font-medium text-red-500">File is required!</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                            @change="changeThumbnail"
                                            @dragover="dragoverThumbnail"
                                            @drop="dropThumbnail"
                                        >
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label class="browse text-indigo-400 hover:text-indigo-800 cursor-pointer font-bold">Click here
                                                        <input ref="thumbnail" id="file" class="sr-only" type="file" accept="image/*">
                                                    </label>
                                                    <p class="pl-1">or drag and drop an image</p>
                                                </div>
                                                <p class="text-xs text-gray-500">Image Format : PNG, JPG</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4" v-show="form.thumbnail.image_url != ''">
                                        <label class="block text-sm text-gray-700 font-bold mb-2"> Artwork File </label>
                                        <div class="flex flex-row justify-start space-x-2">
                                            <div class="flex-column text-center">
                                                <img class="object-scale-down h-40 w-40" :src="form.thumbnail.image_url" alt="">
                                            </div>
                                            <div class="flex-column">
                                                <div class="flex flex-col space-y-1">
                                                    <BreezeButton class="py-1 px-2 bg-blue-500 hover:bg-blue-600 rounded text-white shadow" @click="reselect_thumbnail()" title="Reselect an image">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                    </BreezeButton>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 space-y-2">
                                        <label class="block text-sm text-gray-700 font-bold"> Math Manipulative Folder </label>
                                        <div class="flex items-center justify-center bg-grey-lighter" v-if="Object.keys(form.folder).length === 0">
                                            <label class="w-full flex flex-col items-center px-4 py-6 bg-white text-indigo-400 rounded-lg shadow-lg tracking-wide uppercase border border-indigo cursor-pointer hover:bg-indigo-400 hover:text-white">
                                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                </svg>
                                                <span class="mt-2 text-base leading-normal">Select folder</span>
                                                <input type="file" id="filepicker" class="hidden" @change="change($event)" webkitdirectory multiple />
                                            </label>
                                        </div>
                                        <div v-else class="flex flex-col space-y-4 p-4 border rounded shadow">
                                            <folder-tree :folders="form.folder" />
                                            <button class="py-2 px-4 bg-red-600 hover:bg-red-500 rounded text-white" @click="removeFolder()">Remove Folder</button>
                                        </div>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                    <div class="flex items-center justify-end">
                                        <div class="flex space-x-2">
                                            <BreezeButton buttonType="gray" :route="route('math_manipulatives.configuration')">Cancel</BreezeButton>
                                            <BreezeButton type="submit">Save</BreezeButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>

import { Head, Link } from '@inertiajs/inertia-vue3';
import FolderTree from "../../../Components/FolderTree.vue";

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

export default {
    components: {
        Head, Link
    },
    data(){
        return{
            data:  {
                type: Object,
                default: () => ({}),
            },
            list: {
                students: [],
                levels: this.$page.props.levels,
                themes: [],
                lessons: [],
                activities: []
            },
            form: {
                title: '',
                folder: [],
                thumbnail: {
                    image_url: '',
                    file: ''
                }
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('math_manipulatives.configuration.store'), this.form, { preserveState: true})
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
                        reject(new Error('Your browser is not supported.'));
                    }
                } else {
                    reject(new Error(`Please select a valid image file.`));
                    // reject(new Error(`Please ${event ? event.type : 'choose'} an image file.`));
                }
            });
        },
        changeThumbnail({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                this.read(files[0], target)
                .then((data) => {
                    this.form.thumbnail.image_url =   data.url
                    this.form.thumbnail.file      =   files[0]
                })
                .catch(this.alert);
            }
        },
        dragoverThumbnail(e) {
            e.preventDefault();
        },
        dropThumbnail(e) {
            const { files } = e.dataTransfer;
            e.preventDefault();
            if (files && files.length > 0) {
                this.read(files[0], e)
                .then((data) => {
                    this.form.thumbnail.image_url =   data.url
                    this.form.thumbnail.file      =   files[0]
                })
                .catch(this.alert);
            }
        },
        reselect_thumbnail(){
            this.$refs.thumbnail.value = ''
            this.form.thumbnail.image_url    =   ''
            this.form.thumbnail.file    =   ''
        },
        change(event) {
            const files = event.target.files;

            // Create an empty object to represent the folder structure
            const folderTree = {};

            // Iterate over each file in the FileList object
            for (let i = 0; i < files.length; i++) {
                // Get the current file from the FileList
                const file = files[i];

                // Split the path into an array of folder names
                const folders = file.webkitRelativePath.split('/');

                // Get a reference to the current level of the folder tree
                let currentLevel = folderTree;

                // Iterate over each folder name in the path
                for (let j = 0; j < folders.length; j++) {
                    const folder = folders[j];

                    // If the folder doesn't exist in the current level, create it
                    if (!currentLevel[folder]) {
                    // If this is the last element in the array, it's a file
                        if (j === folders.length - 1) {
                            currentLevel[folder] = [file];
                        } else {
                            currentLevel[folder] = {};
                        }
                    } else if (j === folders.length - 1) {
                        // If this is the last element in the array and the folder already exists, it's a file
                        currentLevel[folder].push(file);
                    }

                    // Move down one level in the folder tree
                    currentLevel = currentLevel[folder];
                }
            }
            this.form.folder   =   folderTree
        },
        removeFolder(){
            this.form.folder = []
        }
    },
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>