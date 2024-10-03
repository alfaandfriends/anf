<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Math Manipulatives" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Upload Math Manipulative</template>
            <template #content>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <Label>Title<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.title" v-model="form.title"></Input>
                    </div>
                    <div class="space-y-2" v-show="form.thumbnail.image_url == ''">
                        <label class="block text-sm text-gray-700 font-bold"> Thumbnail <span class="text-red-500">*</span></label>
                        <div class="rounded-md bg-red-100 p-4" v-if="$page.props.errors['artwork.file']">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <ExclamationTriangleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
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
                    <div v-show="form.thumbnail.image_url != ''">
                        <label class="block text-sm text-gray-700 font-bold mb-2"> Artwork File </label>
                        <div class="flex flex-row justify-start space-x-2">
                            <div class="flex-column text-center">
                                <img class="object-scale-down h-40 w-40" :src="form.thumbnail.image_url" alt="">
                            </div>
                            <div class="flex-column">
                                <div class="flex flex-col space-y-1">
                                    <Button @click="reselect_thumbnail()" title="Reselect an image">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <Label>Folder Name<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.folder_name" v-model="form.folder_name"></Input>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex justify-end">
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('math_manipulatives.configuration'))">Cancel</Button>
                        <Button @click="submit">Save</Button>
                    </div>
                </div>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>

<script>

import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'
import { ExclamationTriangleIcon } from '@radix-icons/vue'

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
                folder_name: '',
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
