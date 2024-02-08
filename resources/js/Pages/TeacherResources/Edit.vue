<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Teacher Resources" />

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
                                        <h1 class="font-bold text-indigo-800">Resource Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="title" class="block text-sm font-bold text-gray-700"> Title <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="title" id="title" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.title ? 'border-red-300' : 'border-gray-300'" v-model="form.title" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="programme_id" class="block text-sm font-bold text-gray-700"> Programme <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="programme_id" id="programme_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme_id ? 'border-red-300' : 'border-gray-300'" v-model="form.programme_id" autocomplete="off" :disabled="disable_class_levels">
                                                <option value="">Please Select</option>
                                                <option :value="programme.id" v-for="programme, index in $page.props.programmes" :key="programme.id">{{ programme.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="level_id" class="block text-sm font-bold text-gray-700"> Level <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="level_id" id="level_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.level_id ? 'border-red-300' : 'border-gray-300'" v-model="form.level_id" autocomplete="off">
                                                <option value="">Please Select</option>
                                                <option :value="level.id" v-for="level, index in $page.props.levels" :key="level">{{ level.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="language_id" class="block text-sm font-bold text-gray-700"> Language <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="language_id" id="language_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.language_id ? 'border-red-300' : 'border-gray-300'" v-model="form.language_id" autocomplete="off">
                                                <option value="">Please Select</option>
                                                <option :value="language.id" v-for="language, index in $page.props.languages" :key="language.id">{{ language.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="media_type_id" class="block text-sm font-bold text-gray-700"> Media Type <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="media_type_id" id="media_type_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.media_type_id ? 'border-red-300' : 'border-gray-300'" v-model="form.media_type_id" autocomplete="off">
                                                <option value="">Please Select</option>
                                                <option :value="media_type.id" v-for="media_type, index in $page.props.media_types" :key="media_type.id">{{ media_type.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4" v-if="form.media_type_id == 1">
                                        <label for="embed_link" class="block text-sm font-bold text-gray-700"> Embed Link <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <textarea type="text" name="embed_link" id="embed_link" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.embed_link ? 'border-red-300' : 'border-gray-300'" v-model="form.embed_link" autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-4" v-if="form.media_type_id == 2 || form.media_type_id == 3"> 
                                        <label for="" class="block text-sm font-bold text-gray-700"> File <span class="text-red-500">*</span></label>
                                        <label class="mt-1 block focus:ring-0 focus:border-gray-300" v-if="show_upload_file">
                                            <span class="sr-only">Browse File</span>
                                            <input type="file" ref="file_input" class="focus:ring-0 border rounded-md block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 focus:outline-none" :class="$page.props.errors.embed_file ? 'border-red-300' : 'border-gray-300'" @change="uploadFile"/>
                                        </label>
                                        <div class="mt-1 mb-5 rounded-md bg-[#F5F7FB] py-4 px-4" v-else>
                                            <div class="flex items-center justify-between">
                                              <span class="truncate pr-3 text-base font-medium text-[#07074D]">{{ form.embed_link }}</span>
                                              <button type="button" class="text-indigo" @click="deletePreviousFile">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z" fill="currentColor"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z" fill="currentColor"/>
                                                </svg>
                                              </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                    <div class="flex items-center justify-end">
                                        <div class="flex space-x-2">
                                            <BreezeButton buttonType="gray" :route="route('teacher_resources')">Cancel</BreezeButton>
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
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        Head, Link, Multiselect
    },
    data(){
        return{
            list: {
                levels: [],
            },
            show_upload_file: false,
            form: {
                id: this.$page.props.resource_info.id ? this.$page.props.resource_info.id : '',
                title: this.$page.props.resource_info.title ? this.$page.props.resource_info.title : '',
                programme_id: this.$page.props.resource_info.programme_id ? this.$page.props.resource_info.programme_id : '',
                level_id: this.$page.props.resource_info.level ? this.$page.props.resource_info.level : '',
                language_id: this.$page.props.resource_info.language_id ? this.$page.props.resource_info.language_id : '',
                media_type_id: this.$page.props.resource_info.media_type ? this.$page.props.resource_info.media_type : '',
                embed_link: this.$page.props.resource_info.content ? this.$page.props.resource_info.content : '',
                embed_file: '',
                delete_previous_file: false
            }
        }
    },
    watch: {
        // 'form.programme_id': {
        //     handler(){
        //         if(this.form.programme_id != ''){
        //             axios.get(route('get_programme_levels', this.form.programme_id))
        //             .then((response) => {
        //                 this.form.level_id  =   ''
        //                 this.list.levels    =   response.data
        //             })
        //         }
        //     },
        //     deep: true
        // },
        'form.media_type_id': {
            handler(){
                this.form.embed_link = ''
                this.form.embed_file = ''
                this.form.delete_previous_file = true
                if(this.form.media_type_id == 2 || this.form.media_type_id == 3){
                    this.show_upload_file = true
                }
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('teacher_resources.update'), this.form, { preserveState: true})
        },
        uploadFile($event){
            const file  =   $event.target.files[0]
            if(this.form.media_type_id  ==  2){
                if(file.type == 'application/pdf' || file.name.toLowerCase().endsWith('.pdf')){
                    this.form.embed_file  =   file
                }
                else{
                    alert('Only PDF File allowed!')
                    this.$refs.file_input.value = ''
                    this.form.embed_file = ''
                }
            }
            
            if(this.form.media_type_id  ==  3){
                if(file.type === 'application/vnd.ms-powerpoint' || file.type === 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || file.name.toLowerCase().endsWith('.ppt') || file.name.toLowerCase().endsWith('.pptx')){
                    this.form.embed_file  =   file
                }
                else{
                    alert('Only PowerPoint Sildeshow File allowed!')
                    this.$refs.file_input.value = ''
                    this.form.embed_file = ''
                }
            }
        },
        deletePreviousFile(){
            this.form.embed_link = ''
            this.form.delete_previous_file = true
            this.show_upload_file = true
        }
    },
    // created(){
    //     axios.get(route('get_programme_levels', this.form.programme_id))
    //     .then((response) => {
    //         this.list.levels    =   response.data
    //     })
    //     if(!this.form.embed_link){
    //         this.show_upload_file =  true
    //     }
    // }
}
</script>