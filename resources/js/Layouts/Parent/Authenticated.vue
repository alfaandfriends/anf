<script setup>
import Header from '@/Components/Parent/Header.vue'
import Footer from '@/Components/Parent/Footer.vue'
import Navigation from '@/Components/Parent/Navigation.vue'
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
import Announcement from '@/Components/Parent/Announcement.vue';
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex flex-col justify-between w-full andika-regular">
        <Header />
        <Navigation />
        <div class="fixed w-full bottom-16 md:bottom-14 z-20">
            <div class="px-6 py-3 bg-blue bg-red-500 space-y-4 md:flex md:space-y-0 justify-between items-center mt-16 md:mt-0" v-if="$page.props.can.impersonate_access || $page.props.can.is_impersonated">
                <span class="text-white text-sm font-semibold italic whitespace-nowrap">Warning: Please use this feature with caution!</span>
                <form @submit.prevent="impersonate" class="flex flex-col lg:flex-row w-full space-x-2 items-center md:justify-end lg:justify-end">
                    <label for="impersonate_username" class="text-white 2xl:text-sm sm:text-md font-bold">Username</label>
                    <div class="flex space-x-2 items-center">
                        <input type="text" id="impersonate_username" class="rounded py-1 px-2 border-orange-500 focus:ring-0 focus:border-orange-500" v-model="username" autocomplete="none">
                        <BreezeButton tooltip="Switch User" @click="impersonate" class="px-3 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M0 224c0 17.7 14.3 32 32 32s32-14.3 32-32c0-53 43-96 96-96H320v32c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l64-64c12.5-12.5 12.5-32.8 0-45.3l-64-64c-9.2-9.2-22.9-11.9-34.9-6.9S320 19.1 320 32V64H160C71.6 64 0 135.6 0 224zm512 64c0-17.7-14.3-32-32-32s-32 14.3-32 32c0 53-43 96-96 96H192V352c0-12.9-7.8-24.6-19.8-29.6s-25.7-2.2-34.9 6.9l-64 64c-12.5 12.5-12.5 32.8 0 45.3l64 64c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6V448H352c88.4 0 160-71.6 160-160z"/>
                            </svg>
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
        <main class="flex-grow flex-col bg-orange-50 relative justify-start mt-16 mb-16 md:mb-0 md:mt-0 py-5 px-3">
            <slot/>
            <SimpleModal :open="$page.props.flash.type === null ? false : true" @close:modal="$page.props.flash.type = null" class="md:w-2/6">
                <div class="text-center flex flex-col items-center justify-start space-y-2 p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2/12 w-2/12 text-green-500" viewBox="0 0 512 512" fill="currentColor" v-if="$page.props.flash.type == 'success'">
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2/12 w-2/12 text-red-500" viewBox="0 0 512 512" fill="currentColor" v-else>
                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/>
                    </svg>
                    <h3 class="md:text-2xl text-base text-gray-900 font-semibold text-center">{{ $page.props.flash.header }}</h3>
                    <p class="text-gray-600 my-2">{{ $page.props.flash.message }}</p>
                    <div class="py-2 text-center">
                        <button @click="$page.props.flash.type = null" class="rounded px-6 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-1.5">Close</button>
                    </div>
                </div>
            </SimpleModal>
        </main>
        <Footer />
    </div>
</template>

<script>
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';

export default {
    components: {
        simplebar,
    },
    data(){
        return{
            show_modal: this.$page.props.flash.type ? true : false
        }
    },
    methods: {
        onScroll(event) {
            this.$emit('scroll', event); // Emit 'scroll' event to parent component
        },
        impersonate(){
            if(this.username){
                this.$inertia.get(route('impersonate', this.username))
            }
        },
    },
    mounted(){
        window.addEventListener('scroll', this.onScroll);
    },
    beforedDestroy() {
        window.removeEventListener('scroll', this.onScroll);
    },
}
</script>
