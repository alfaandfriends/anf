<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Stories" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="flex items-center justify-between">
            <div class="flex justify-between space-x-2">
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                    <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
                </div>
                <Button class="border border-slate-700 border-dashed bg-white text-slate-800 hover:bg-slate-50" @click="showFilters()"> 
                    <Filter class="h-4 w-4" />
                    <span class="ml-1 hidden sm:block">Filters</span>
                </Button>
            </div>
            <Button @click="openAddStoryModal"> 
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Story</span>
            </Button>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-5 gap-2" v-if="show_filters">
            <ComboBox canClear :items="$page.props.allowed_centres" label-property="label" value-property="ID" @select="search" v-model="params.centre_id" select-placeholder="Centres" search-placeholder="Search centre..."></ComboBox>
            <ComboBox canClear :items="$page.props.programmes" label-property="name" value-property="id" @select="search" v-model="params.programme_id" select-placeholder="Programmes" search-placeholder="Search programme...">
                <template #label="{ item }">
                    {{ item.name }} ({{ item.country_name }})
                </template>
                <template #label-content="{ selectedItem, selectedItems, multiple }">
                    <span v-if="selectedItem">{{ selectedItem.name }} ({{ selectedItem.country_name }})</span>
                </template>
            </ComboBox>
            <div class="">
                <Button @click="$inertia.get(route('stories'))">Clear Search</Button>
            </div>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Date</TableHead>
                        <TableHead>Reactions</TableHead>
                        <TableHead>Comments</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.stories.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="result, index in $page.props.stories.data">
                            <TableCell>{{ $page.props.stories.from + index }}</TableCell>
                            <TableCell>
                                <div class="flex flex-col max-w-md space-y-1">
                                    <Label class="truncate" :title="result.story_title">{{ result.story_title }}</Label>
                                    <div class="text-xs text-slate-500">{{ result.story_author_name }}</div>
                                </div>
                            </TableCell>
                            <TableCell><Label>{{ moment(result.story_date).format('DD MMM Y') }}</Label></TableCell>
                            <TableCell>
                                <Badge class="cursor-pointer" @click="openLikesModal(index)">
                                    <span>{{ result.likes.length }} Reactions</span>
                                </Badge>
                            </TableCell>
                            <TableCell>
                                <Badge class="cursor-pointer" @click="openCommentsModal(index)">
                                    <span>{{ result.comments.length }} Comments</span>
                                </Badge>
                            </TableCell>
                            <TableCell class="text-center">
                                <div class="flex justify-center space-x-2">
                                    <Button variant="outline" @click="openEditStoryModal(index)" v-if="$page.props.can.edit_stories">Edit</Button>
                                    <Button variant="destructive" @click="deleteStory(result.story_id)" v-if="$page.props.can.delete_stories">Delete</Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.stories" :params="params"></Pagination>
        
        <Dialog v-model:open="show_add_story_modal" :interactOutside="(e) => { e.preventDefault(), lightbox.open = false }">
            <template #title>Add Story</template>
            <template #content>
                <div class="grid grid-cols-1 gap-4">
                    <ComboBox :items="$page.props.programmes" label-property="name" value-property="id" v-model="add_story.form.programme_id" select-placeholder="Select Programme" search-placeholder="Search programme...">
                        <template #label="{ item }">
                            {{ item.name }} ({{ item.country_name }})
                        </template>
                        <template #label-content="{ selectedItem, selectedItems, multiple }">
                            <span v-if="selectedItem">{{ selectedItem.name }} ({{ selectedItem.country_name }})</span>
                        </template>
                    </ComboBox>
                    <ComboBox :items="$page.props.centres" label-property="label" value-property="ID" v-model="add_story.form.centre_id" select-placeholder="Select Centre" search-placeholder="Search centre..."></ComboBox>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                        <ComboBox canClear :items="$page.props.class_types" label-property="name" value-property="id" v-model="add_story.find.class_types" select-placeholder="Select Class Type (optional)" search-placeholder="Search class type..."></ComboBox>
                        <ComboBox canClear :items="add_story.list.levels" label-property="level" value-property="id" v-model="add_story.find.levels" select-placeholder="Select Level" search-placeholder="Search level...">
                            <template #label="{ item }">
                                Level {{ item.level }}
                            </template>
                            <template #label-content="{ selectedItem, selectedItems, multiple }">
                                <span v-if="selectedItem">Level {{ selectedItem.level }}</span>
                            </template>
                        </ComboBox>
                    </div>
                    <ComboBox multiple :items="add_story.students[0].options" label-property="name" value-property="id" v-model="add_story.form.students" select-placeholder="Select Students" search-placeholder="Search student..."></ComboBox>
                    <Textarea rows="3" placeholder="What's happening today?" v-model="add_story.form.caption"></Textarea>
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
                                <svg class="w-8 h-8 mb-1 text-slate-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="text-sm text-slate-500">
                                    <span class="font-medium">Click to upload</span>
                                </p>
                                <Label class="text-xs text-center text-slate-500">Hold <strong>Shift</strong> or <strong>CTRL</strong> and click on images to select multiple</Label>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" multiple/>
                        </label>
                    </div> 
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="show_add_story_modal = false">Cancel</Button>
                <Button @click="post">Post</Button>
            </template>
        </Dialog>
        <Dialog v-model:open="show_edit_story_modal" :interactOutside="(e) => { e.preventDefault(), lightbox.open = false }">
            <template #title>Edit Story</template>
            <template #content>
                <div class="grid grid-cols-1 gap-4">
                    <ComboBox :items="$page.props.programmes" label-property="name" value-property="id" v-model="edit_story.form.programme_id" select-placeholder="Select Programme" search-placeholder="Search programme...">
                        <template #label="{ item }">
                            {{ item.name }} ({{ item.country_name }})
                        </template>
                        <template #label-content="{ selectedItem, selectedItems, multiple }">
                            <span v-if="selectedItem">{{ selectedItem.name }} ({{ selectedItem.country_name }})</span>
                        </template>
                    </ComboBox>
                    <ComboBox :items="$page.props.centres" label-property="label" value-property="ID" v-model="edit_story.form.centre_id" select-placeholder="Select Centre" search-placeholder="Search centre..."></ComboBox>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                        <ComboBox canClear :items="$page.props.class_types" label-property="name" value-property="id" v-model="edit_story.find.class_types" select-placeholder="Select Class Type (optional)" search-placeholder="Search class type..."></ComboBox>
                        <ComboBox canClear :items="edit_story.list.levels" label-property="level" value-property="id" v-model="edit_story.find.levels" select-placeholder="Select Level" search-placeholder="Search level...">
                            <template #label="{ item }">
                                Level {{ item.level }}
                            </template>
                            <template #label-content="{ selectedItem, selectedItems, multiple }">
                                <span v-if="selectedItem">Level {{ selectedItem.level }}</span>
                            </template>
                        </ComboBox>
                    </div>
                    <ComboBox multiple :items="edit_story.students[0].options" label-property="name" value-property="id" v-model="edit_story.form.students" select-placeholder="Select Students" search-placeholder="Search student..."></ComboBox>
                    <Textarea rows="3" placeholder="What's happening today?" v-model="edit_story.form.caption"></Textarea>
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
                                <svg class="w-8 h-8 mb-1 text-slate-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="text-sm text-slate-500 ">
                                    <span class="font-medium">Click to upload</span>
                                </p>
                                <span class="text-xs text-center text-slate-500">Hold <strong>Shift</strong> or <strong>CTRL</strong> and click on images to select multiple</span>
                            </div>
                            <input id="dropzone-file-2" type="file" class="hidden" multiple/>
                        </label>
                    </div> 
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="show_edit_story_modal = false">Cancel</Button>
                <Button @click="savePost">Save</Button>
            </template>
        </Dialog>
        <Dialog v-model:open="show_likes_modal" classProp="max-w-sm">
            <template #title>Reactions</template>
            <template #content>
                <div class="grid grid-cols-1">
                    <div class="divide-y px-4 text-slate-600">
                        <div class="flex items-center justify-between py-2" v-if="likes.length" v-for="like in likes">
                            <div class="text-slate-800 text-sm font-medium">{{ like.like_author_name}}</div>
                            <TimeAgo class="text-slate-400 text-xs" :datetime="like.like_date" :key="like.like_date"></TimeAgo>
                        </div>
                        <div class="py-2 text-sm" v-else>
                            <span>No one has liked this story yet.</span>
                        </div>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="show_likes_modal = false">Close</Button>
            </template>
        </Dialog>
        <Dialog v-model:open="show_comments_modal" classProp="max-w-sm">
            <template #title>Reactions</template>
            <template #content>
                <div class="grid grid-cols-1">
                    <div class="divide-y px-4 text-slate-600">
                        <div class="flex items-center justify-between py-2" v-if="comments.length" v-for="comment in comments">
                            <div class="flex flex-col">
                                <div class="text-slate-800 text-sm font-semibold">{{ comment.comment_user_name}}</div>
                                <blockquote class="text-slate-800 text-xs font-medium italic">
                                    <p>{{ comment.comment}}</p>
                                </blockquote>
                            </div>
                            <TimeAgo class="text-slate-400 text-xs" :datetime="comment.created_at" :key="comment.created_at"></TimeAgo>
                        </div>
                        <div class="py-2 text-sm" v-else>
                            <span>There are no comments on this story yet.</span>
                        </div>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="show_comments_modal = false">Close</Button>
            </template>
        </Dialog>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Story</template>
            <template #description>Are you sure want to delete this story?</template>
        </DeleteConfirmation>
        <FsLightbox
            :toggler="lightbox.open"
            :sources="lightbox.src"
            :exitFullscreenOnClose="true"
        />
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { Filter, PlusCircle } from 'lucide-vue-next';
import axios from 'axios'
import { debounce } from 'vue-debounce'
import FsLightbox from "fslightbox-vue/v3";
import moment from "moment";
import TimeAgo from '@/Components/TimeAgo.vue'
import Compressor from 'compressorjs';
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Pagination from '@/Components/Pagination.vue'
import { Badge } from '@/Components/ui/badge'
import Dialog from '@/Components/DialogModal.vue'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

export default {
    components: {
        Head, Link, FsLightbox, TimeAgo, 
    },
    props: {
        filter: Object,
    },
    data(){
        return{
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            show_filters: false,
            show_add_story_modal: false,
            show_edit_story_modal: false,
            show_likes_modal: false,
            show_comments_modal: false,
            likes: [],
            comments: [],
            lightbox: {
                open: false,
                src: [],
            },
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
            params: {
                search: this.filter.search ? this.filter.search : '',
                centre_id: this.filter.centre_id ? this.filter.centre_id : '',
                programme_id: this.filter.programme_id ? this.filter.programme_id : '',
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
                    this.add_story.students[0].options = []
                    this.add_story.form.students = []

                    axios.get(route('stories.get_class_levels', [this.add_story.form.programme_id, this.add_story.find.class_types]))
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

                    axios.get(route('stories.get_class_levels', [this.edit_story.form.programme_id, this.edit_story.find.class_types]))
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
        openAddStoryModal(){
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
        openLikesModal(index){
            this.likes = []
            this.likes = this.$page.props.stories.data[index].likes
            this.show_likes_modal = true
        },
        openCommentsModal(index){
            this.comments = []
            this.comments = this.$page.props.stories.data[index].comments
            this.show_comments_modal = true
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
            if((this.edit_story.form.caption || this.edit_story.form.photos.length) && this.edit_story.form.students.length > 0){
                this.$inertia.post(route('stories.update'), this.edit_story.form, {preserveState: false})
            }
        },
        deleteStory(story_id){
            this.confirmation.route_name    = 'stories.destroy'
            this.confirmation.id            = story_id
            this.confirmation.is_open       = true
        },
        search(){
            this.$inertia.get(this.route('stories'), this.params, {replace: true, preserveState: true});
        },
        viewImage(image){
            this.lightbox.src   = image.url ? [image.url] : [window.location.origin+'/storage/stories/' + image.image_filename]
            this.lightbox.open  = !this.lightbox.open
        },
        blobToFile(blob, filename) {
            const file = new File([blob], filename, { type: blob.type });
            return file;
        },
        showFilters(){
            this.show_filters = !this.show_filters
        },
    }
}
</script>