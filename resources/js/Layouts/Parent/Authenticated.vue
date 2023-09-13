<script setup>
import Header from '@/Components/Parent/Header.vue'
import Footer from '@/Components/Parent/Footer.vue'
import Navigation from '@/Components/Parent/Navigation.vue'
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
</script>

<template>
    <div class="flex">
        <div class="min-h-screen bg-gray-100 w-full">
            <!-- Page Content -->
            <Header />
            <Navigation />
            <main class="flex flex-col bg-indigo-50 relative h-full justify-between mt-20 md:mt-0">
                <div class="bg-orange-50 min-h-screen">
                    <div class="flex justify-center">
                        <div class="flex-1 max-w-4xl overflow-y-auto p-3 mb-10">
                            <slot/>
                        </div>
                    </div>
                </div>
                <Footer />
                <!-- Payment Modal -->
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
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            show_modal: this.$page.props.flash.type ? true : false
        }
    },
}
</script>
