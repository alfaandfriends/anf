<template>
    <div class="min-h-screen bg-slate-50 px-3 flex flex-col">
        <div class="flex-grow w-full max-w-xl mx-auto py-3 space-y-2">
            <div class="border rounded-lg bg-green-200 px-3 py-2" v-if="response.success">
                <Label>{{ $page.props.flash.message }}</Label>
            </div>
            <div class="border rounded-lg bg-red-100 px-3 py-2" v-if="response.error">
                <Label>{{ $page.props.flash.message }}</Label>
            </div>
            <div class="px-4 mt-3">
                <Label>Class Information</Label>
            </div>
            <div class="py-3 px-4 grid gap-3 text-sm border border-slate-300 rounded-xl bg-white">
                <dl class="grid gap-2">
                    <div>
                        <dt class="font-medium underline">
                        Student Name
                        </dt>
                        <dd>{{ $page.props.student }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium underline">
                        Theme
                        </dt>
                        <dd>
                        <a>{{ $page.props.theme }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium underline">
                        Lesson
                        </dt>
                        <dd>
                        <a>{{ $page.props.lesson }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium underline">
                        Activity
                        </dt>
                        <dd>
                        <a>{{ $page.props.activity }}</a>
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="px-4 mt-3">
                <Label>Selected Artworks</Label>
            </div>
            <div class="px-4 py-1.5 bg-white border border-solid border-gray-300 rounded-xl" v-for="item, index in form">
                <div class="mb-1 flex justify-between items-center">
                    <div class="">
                        <span class="truncate text-sm inline-block align-bottom">{{ item.file.name }}</span>
                        <div class="flex items-center space-x-1">
                            <Checkbox :id="index" :checked="!!item.for_artbook" @click.native="item.for_artbook = !item.for_artbook"></Checkbox>
                            <label :for="index" class="text-sm font-medium cursor-pointer select-none">For Art Book</label>
                        </div>
                    </div>
                    <button type="button" @click="deleteFile(index)" class="text-red-500 hover:text-red-600">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                        <line x1="10" x2="10" y1="11" y2="17"></line>
                        <line x1="14" x2="14" y1="11" y2="17"></line>
                        </svg>
                    </button>
                </div>
            </div>
            <div @click="triggerInput" class="cursor-pointer p-12 flex justify-center bg-white border border-dashed border-gray-300 rounded-xl">
                <div class="text-center">
                    <span class="inline-flex justify-center items-center size-16 bg-gray-100 text-gray-800 rounded-full dark:bg-neutral-700 dark:text-neutral-200">
                        <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" x2="12" y1="3" y2="15"></line>
                        </svg>
                    </span>

                    <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600">
                        <span class="pe-1 font-medium text-gray-800 dark:text-neutral-200">Select artwork to upload</span>
                    </div>

                    <p class="mt-1 text-xs text-gray-500 dark:text-neutral-400">
                        You may select multiple files
                    </p>
                </div>

                <!-- Hidden File Input -->
                <input
                type="file"
                ref="fileInput"
                class="hidden"
                accept="image/*"
                multiple
                @change="handleFileUpload"
                />
            </div>
            <div class="flex justify-center">
                <Button @click="submit">Upload Artwork</Button>
            </div>
        </div>
    </div>
  </template>

<script>
export default {
    data() { 
        return {
            response: {
                success: false,
                error: false,
            },
            encrypted_data: this.$page.props.encrypted,
            form: []
        }
    },
    methods: {
        triggerInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                if (!files[i].type.startsWith('image/')) {
                    alert(`${files[i].name} is not an image file.`);
                    return;
                }
                if(this.form.find(item => item.file.name == files[i].name)){
                    alert(`${files[i].name} already_exists.`);
                    return;
                }
                this.form.push({
                    file: files[i],
                    for_artbook: false
                })
            }

        },
        deleteFile(index){
            this.form.splice(index, 1)
        },
        submit(){
            this.$inertia.post(route('store_artwork'), {data: this.form, encrypted_data: this.encrypted_data}, {
                onSuccess: () => {
                    if(this.$page.props.flash.type == 'success'){
                        this.response.success = true
                        this.response.error = false
                    }
                    else{
                        this.response.success = false
                        this.response.error = true
                    }
                    this.form = []
                }
            })
        }
    }
}
</script>