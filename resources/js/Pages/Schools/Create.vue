<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>
<style>
    .image {
        display: block;

        /* This rule is very important, please don't ignore this */
        max-width: 100%;
        max-height: 20px;
    }
    .preview {
        overflow: hidden;
        width: 240px;
        height: 240px;
    }
</style>
<template>
    <Head title="Schools" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add School
            </h2>
        </template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form action="#" method="POST">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-3 sm:col-span-1">
                                <label for="company-website" class="block text-sm font-medium text-gray-700"> Centre Name <span class="text-red-500">*</span> </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"> ANFC </span>
                                    <input type="text" name="company-website" id="company-website" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" />
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-6">
                            <div class="col-span-4 sm:col-span-1">
                                <label for="company-website" class="block text-sm font-medium text-gray-700"> Phone <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="company-website" id="company-website" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" />
                                </div>
                            </div>  
                            <div class="col-span-4 sm:col-span-1">
                                <label for="company-website" class="block text-sm font-medium text-gray-700"> Email </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="email" name="company-website" id="company-website" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" />
                                </div>
                            </div>  
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-3 sm:col-span-1">
                                <label for="about" class="block text-sm font-medium text-gray-700"> Address <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-0 focus:border-indigo-300 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" />
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-6">
                            <div class="col-span-4 sm:col-span-1" v-show="show_front_upload">
                                <label class="block text-sm font-medium text-gray-700"> Centre Front View <span class="text-red-500">*</span> (Maximum: 1)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                    @change="change_front"
                                    @dragover="dragover_front"
                                    @drop="drop_front"
                                >
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="browse text-indigo-400 hover:text-indigo-700 cursor-pointer">Click here
                                                <input
                                                id="file"
                                                class="sr-only"
                                                type="file"
                                                accept="image/*"
                                                >
                                            </label>
                                            <p class="pl-1">or drag and drop an image</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-4 sm:col-span-1" v-show="show_inside_upload">
                                <label class="block text-sm font-medium text-gray-700"> Centre Inside View <span class="text-red-500">*</span> (Maximum: 5)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                    @change="change_inside"
                                    @dragover="dragover_inside"
                                    @drop="drop_inside"
                                >
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="browse text-indigo-400 hover:text-indigo-700 cursor-pointer">Click here
                                                <input
                                                id="file"
                                                class="sr-only"
                                                type="file"
                                                accept="image/*"
                                                >
                                            </label>
                                            <p class="pl-1">or drag and drop an image</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-4 sm:col-span-1" v-show="show_image">
                                <label class="block text-sm font-medium text-gray-700"> Crop Image</label>
                                <div class="w-96 h-60 mt-2">
                                    <img class="image" ref="image" :src="this.image">
                                </div>
                            </div>
                            <div class="col-span-4 sm:col-span-1" v-show="show_image">
                                <div class="flex flex-row justify-end">
                                    <div class="flex-column text-center">
                                        <label class="block text-sm font-medium text-gray-700"> Image Preview </label>
                                        <div class="preview h-52 w-96 mt-2"></div>
                                    </div>
                                    <div class="flex-column pl-1 pt-7">
                                        <div class="flex-row pb-1">
                                            <button type="button" class="py-1 px-2 bg-green-500 hover:bg-green-600 rounded text-white shadow" @click="select_cropped_front_image()" title="Select cropped image">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="flex-row">
                                            <button type="button" class="py-1 px-2 bg-blue-500 hover:bg-blue-600 rounded text-white shadow" @click="reselect_front_image()" title="Reselect an image">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="grid grid-cols-4 gap-6">
                            <div class="col-span-4 sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-700"> Centre Inside View <span class="text-red-500">*</span> (Maximum: 5)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                    @change="change_inside"
                                    @dragover="dragover_inside"
                                    @drop="drop_inside"
                                    v-show="show_inside_upload">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="browse text-indigo-400 hover:text-indigo-700 cursor-pointer">Click here
                                                <input
                                                id="file"
                                                class="sr-only"
                                                type="file"
                                                accept="image/*"
                                                >
                                            </label>
                                            <p class="pl-1">or drag and drop an image</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                <div class="w-96 h-60 mt-2" v-show="show_inside_img">
                                    <img class="img" ref="inside_view" :src="this.inside_image">
                                </div>
                            </div>
                            <div class="col-span-4 sm:col-span-1" v-show="show_inside_img">
                                <div class="flex flex-row justify-end">
                                    <div class="flex-column text-center">
                                        <label class="block text-sm font-medium text-gray-700"><span class="text-blue-500 font-bold">Preview</span>  </label>
                                        <div class="inside_preview h-52 w-96 mt-2"></div>
                                    </div>
                                    <div class="flex-column pl-1 pt-7">
                                        <div class="flex-row pb-1">
                                            <button type="button" class="py-1 px-2 bg-green-500 hover:bg-green-600 rounded text-white shadow" @click="select_cropped_inside_image()" title="Select cropped image">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="flex-row">
                                            <button type="button" class="py-1 px-2 bg-blue-500 hover:bg-blue-600 rounded text-white shadow" @click="reselect_inside_image()" title="Reselect an image">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="grid grid-cols-2 gap-6" v-if="image_list.length">
                            <div class="col-span-2 sm:col-span-1">
                                <div class="overflow-auto hover:no-scroll">
                                    <div class="rounded">
                                        <table class="w-full">
                                            <thead>
                                                <tr class="text-sm text-gray-800 p-2 bg-indigo-200">
                                                    <th class="py-1 px-2 text-left" width="10%">#</th>
                                                    <th class="py-1 px-2 text-left">View Type</th>
                                                    <th class="py-1 px-2 text-left">File Name</th>
                                                    <th class="py-1 px-2 text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="(image_data, index) in image_list" :key="index">
                                                <tr class="text-sm p-2 bg-white">
                                                    <td class="py-1 px-2 text-left">{{ (index + 1) }}</td>
                                                    <td class="py-1 px-2 text-left">{{ image_data.type == 'front' ? 'Front' : 'Inside'}}</td>
                                                    <td class="py-1 px-2 text-left">{{ image_data.name }}</td>
                                                    <td class="py-1 px-2">
                                                        <button type="button" class="py-1 px-1 rounded bg-red-500 hover:bg-red-600 text-white shadow" title="Delete photo" @click="delete_cropped_front_image(index)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="">
                                <label for="" class="block text-sm font-medium text-gray-700">Active</label>
                                <Toggle v-model="form.menu_status" 
                                        :classes="{
                                            container: 'inline-block',
                                            toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                            toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                            toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                        }
                                "/>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Toggle from '@vueform/toggle';
import Cropper from 'cropperjs';    

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

let cropper = null

export default {
    components: {
        Link, Toggle, Cropper
    },
    data() {
        return {
            data:  {
                type: Object,
                default: () => ({}),
            },
            image_list: [],
            show_front_upload: true,
            show_inside_upload: true,
            show_image: false,
            image: '',
            form: {
                status: true,
                role: null,
                role_name: null,
            },
        }
    },
    mounted(){
        const image = this.$refs['image'] 
        cropper = new Cropper(image, {
            aspectRatio: 1,
            cropBoxResizable: false,
            cropBoxMovable: false,
            viewMode: 1,
            dragMode: 'move',
            movable: true,
            rotatable: true,
            preview: '.preview',
            minCropBoxWidth: 500,
            minCropBoxHeight: 500,
        });
    },
    watch: {
        image: {
            handler(value){ 
                cropper.replace(value)
            },
            deep: true
        }
    },
    methods: {
        // submit() {
        //     this.$inertia.post(route('roles.store'), this.form)
        // },
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
                    reject(new Error(`Please ${event ? event.type : 'choose'} an image file.`));
                }
            });
        },
        change_front({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                this.read(files[0], target)
                .then((data) => {
                    this.image    =   data.url
                    this.show_front_upload = false;
                    this.show_inside_upload = false;
                    this.show_image = true;
                    this.update(data, 'front');
                })
                .catch(this.alert);
            }
        },
        dragover_front(e) {
            e.preventDefault();
        },
        drop_front(e) {
            const { files } = e.dataTransfer;
            e.preventDefault();
            if (files && files.length > 0) {
                this.read(files[0], e)
                .then((data) => {
                    this.front_image    =   data.url
                    this.show_front_upload = false;
                    this.show_inside_upload = false;
                    this.update(data);
                })
                .catch(this.alert);
            }
        },
        change_inside({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                this.read(files[0], target)
                .then((data) => {
                    this.image    =   data.url
                    this.show_front_upload = false;
                    this.show_inside_upload = false;
                    this.show_image = true;
                    this.update(data, 'inside');
                })
                .catch(this.alert);
            }
        },
        dragover_inside(e) {
            e.preventDefault();
        },
        drop_inside(e) {
            const { files } = e.dataTransfer;
            e.preventDefault();
            if (files && files.length > 0) {
                this.read(files[0], e)
                .then((data) => {
                    this.front_image    =   data.url
                    this.show_front_upload = false;
                    this.show_inside_upload = false;
                    this.update(data);
                })
                .catch(this.alert);
            }
        },
        alert(e) {
            window.alert(e && e.message ? e.message : e);
        },
        update(data, view_type) {
            Object.assign(this.data, data);
            Object.assign(this.data, {'view_type': view_type});
        },
        reselect_front_image(){
            this.show_front_upload = true
            this.show_inside_upload = true
            this.show_image = false
        },
        select_cropped_front_image(){
            const max_front_image = this.image_list.filter((value) => {
                if (value.type == 'front') return true;
            });
            const max_inside_image = this.image_list.filter((value) => {
                if (value.type == 'inside') return true;
            });
            console.log(max_front_image.length <= 1)

        //    var heroes = [
        //         {name: 'Batman', franchise: 'DC'},
        //         {name: 'Ironman', franchise: 'Marvel'},
        //         {name: 'Thor', franchise: 'Marvel'},
        //         {name: 'Superman', franchise: 'DC'}
        //     ];

        // //     var marvelHeroes =  heroes.filter(function(hero) {
        // //         return hero.franchise == 'Marvel';
        // //     });
        //     console.log(heroes)
        //     console.log(this.image_list)

            if(this.data.view_type == 'front' && max_front_image.length <= 1){
                // const maximum = this.image_list.filter(function(image, key) {
            // console.log(notifications)
            // console.log(key)
                //     return image;
                // });
                // console.log(maximum)
                const cropped_image =   cropper.getCroppedCanvas().toDataURL("image/png");
                this.image_list.push({'name': this.data.name, 'image': cropped_image, 'type': this.data.view_type})
                this.show_front_upload = true
                this.show_inside_upload = true
                this.show_image = false
            }
            else if(this.data.view_type == 'inside' && max_inside_image.length <= 5){
                const cropped_image =   cropper.getCroppedCanvas().toDataURL("image/png");
                this.image_list.push({'name': this.data.name, 'image': cropped_image, 'type': this.data.view_type})
                this.show_front_upload = true
                this.show_inside_upload = true
                this.show_image = false
            }
            else{
                alert('Only 1 image is allowed!')
            }
        },
        delete_cropped_front_image(index){
            this.image_list.splice(index, 1)
        },
    },
}
</script>
