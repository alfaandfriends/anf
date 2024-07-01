<template>
    <Head title="Home" />
    <div class="fixed w-full flex justify-center top-[4rem] md:top-[10rem] font-extrabold bg-white border border-gray-300 py-3 z-20">
        <span>{{ $page.props.session_data.current_active_programme.name }}</span>
    </div>
    <Authenticated>
        <div class="max-w-xl mx-auto border shadow bg-white rounded-lg px-4 mt-14">
            <simplebar data-simplebar-auto-hide="true">
                <div class="flex justify-evenly sm:justify-center space-x-8 md:space-x-10 pt-3 pb-4 font-medium">
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.stories') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.stories', $page.props.session_data.current_active_programme.encrypted_id))">
                        <img src="/images/parents/stories.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Stories</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.progress_reports') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.progress_reports'))">
                        <img src="/images/parents/progress_report.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Progress Reports</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.invoices') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.invoices'))">
                        <img src="/images/parents/fee_invoice.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Invoices</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_gallery') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_gallery'))" v-if="$page.props.session_data.current_active_programme.id == 3 || $page.props.session_data.current_active_programme.id == 5">
                        <img src="/images/parents/art_gallery.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Gallery</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_book') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_book'))" v-if="$page.props.session_data.current_active_programme.id == 3 || $page.props.session_data.current_active_programme.id == 5">
                        <img src="/images/parents/art_book.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Book</span>
                    </div>
                </div>
            </simplebar>
        </div>
        <div class="max-w-xl mx-auto mt-10" @scroll="handleScroll()"  ref="scrollContainer">
            <div class="flex items-center space-y-3" v-if="$page.props.artworks.data">
                <h2 class="text-lg md:text-xl mx-1 font-extrabold">Art Gallery</h2>
            </div>
            <div class="mb-3 flex flex-col space-y-2 justify-between items-end mt-3">
                <Multiselect 
                    v-model="filter.level_id" 
                    :options="$page.props.levels"
                    valueProp="id"
                    placeholder="Select Level"
                    label="name"
                    :closeOnSelect="true"
                    :canDeselect="false"
                    :classes="{
                        container: 'relative mx-auto w-full flex items-center justify-end box-border rounded-lg shadow cursor-pointer border border-gray-200 rounded bg-white text-base leading-snug outline-none',
                        containerDisabled: 'cursor-default bg-gray-100',
                        containerOpen: 'rounded-b-none',
                        containerOpenTop: 'rounded-t-none',
                        containerActive: 'ring-0 ring-opacity-30',
                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                        search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5 rtl:pl-0 rtl:pr-3.5',
                        tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2 rtl:pl-0 rtl:pr-2',
                        tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',
                        tagDisabled: 'pr-2 opacity-50 rtl:pl-2',
                        tagRemove: 'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                        tagRemoveIcon: 'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
                        tagsSearchWrapper: 'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                        tagsSearch: 'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full',
                        tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
                        placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5',
                        caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none rtl:mr-0 rtl:ml-3.5',
                        caretOpen: 'rotate-180 pointer-events-auto',
                        clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 rtl:pr-0 rtl:pl-3.5',
                        clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                        spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0 rtl:mr-0 rtl:ml-3.5',
                        inifite: 'flex items-center justify-center w-full',
                        inifiteSpinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 animate-spin flex-shrink-0 flex-grow-0 m-3.5',
                        dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                        dropdownTop: '-translate-y-full top-px bottom-auto rounded-b-none rounded-t',
                        dropdownHidden: 'hidden',
                        options: 'flex flex-col p-0 m-0 list-none',
                        optionsTop: '',
                        group: 'p-0 m-0',
                        groupLabel: 'flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                        groupLabelPointable: 'cursor-pointer',
                        groupLabelPointed: 'bg-gray-300 text-gray-700',
                        groupLabelSelected: 'bg-indigo-600 text-white',
                        groupLabelDisabled: 'bg-gray-100 text-gray-300 cursor-not-allowed',
                        groupLabelSelectedPointed: 'bg-indigo-600 text-white opacity-90',
                        groupLabelSelectedDisabled: 'text-indigo-100 bg-indigo-600 bg-opacity-50 cursor-not-allowed',
                        groupOptions: 'p-0 m-0',
                        option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                        optionPointed: 'text-gray-800 bg-gray-100',
                        optionSelected: 'text-white bg-indigo-500',
                        optionDisabled: 'text-gray-300 cursor-not-allowed',
                        optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                        optionSelectedDisabled: 'text-indigo-100 bg-indigo-500 bg-opacity-50 cursor-not-allowed',
                        noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                        noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                        fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                        spacer: 'h-9 py-px box-content',
                    }" 
                /> 
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg border p-6" v-if="$page.props.artworks.data.length && !searching.artworks">
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                    <div v-for="artwork in $page.props.artworks.data">
                        <img class="object-cover object-center w-full h-40 max-w-full rounded-lg cursor-pointer"
                            :src="'/storage/art_gallery/'+artwork.filename"
                             @click="showImage(artwork.filename, artwork.activity)"
                        />
                    </div>
                </div>
            </div>
            <div class="flex justify-center mx-1 mt-10" v-if="!$page.props.artworks.data.length && !searching.artworks">
                <span class="text-slate-500">No Artworks Found</span>
            </div>
            <div class="flex justify-center mx-1 mt-10" v-if="searching.artworks">
                <span class="text-slate-500">Searching for student's artworks...</span>
            </div>
        </div>
    </Authenticated>
    <VueEasyLightbox 
        @hide="lightbox.open = false"
        :visible="lightbox.open" 
        :zoomDisabled="true" 
        :rotateDisabled="true" 
        :moveDisabled="true"
        :imgs="lightbox.images" 
        :index="0"
        :dblclickDisabled="true"
        :maskClosable="true"
    >
    </VueEasyLightbox>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeButton from '@/Components/Button.vue'
import VueEasyLightbox from 'vue-easy-lightbox' // work
</script>

<script>
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
import Multiselect from '@vueform/multiselect'
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';

export default {
    components: {
        Multiselect, simplebar
    },
    data(){
        return{
            lightbox: {
                open: false,
                images: [{
                    src: '',
                }]
            },
            list: {
                levels: this.$page.props.levels,
            },
            filter: {
                level_id: 1,
            },
            searching: {
                artworks: false
            },
            loading: false
        }
    },
    watch: {
        'filter.level_id': {
            handler(){
                this.getArtwork()
            },
            deep: true
        },
    },
    methods: {
        getArtwork(){
            if(this.filter.level_id){
                if(this.searching.artworks){
                    return
                }
                this.searching.artworks = true
                axios.get(route('parent.art_gallery.get_artworks'), { params: this.filter })
                .then(response => {
                    this.$page.props.artworks.data   =   response.data
                    this.searching.artworks  = false
                })
            }
        },
        showImage(filename, activity){
            this.lightbox.images[0].src     = window.location.origin+'/storage/art_gallery/'+filename

            this.lightbox.open         = !this.lightbox.open
        },
        handleScroll() {
            console.log('yes')
            const scrollContainer = this.$refs.scrollContainer;
            if(scrollContainer.scrollTop + scrollContainer.clientHeight >= scrollContainer.scrollHeight - 10) {
                // this.fetchPosts();
                console.log('yes')
            }
        }
    }
}
</script>

