<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Math Manipulatives" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full p-2 space-y-6">
                        <div class="flex lg:grow sm:justify-end" v-if="$page.props.can.create_math_manipulatives">
                            <BreezeButton buttonType="info" @click="$inertia.get(route('math_manipulatives.configuration'))">Configuration</BreezeButton>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-5 gap-10" v-if="$page.props.math_manipulatives.length">
                            <div class="group relative block cursor-pointer" v-for="item in $page.props.math_manipulatives" @click="openNewTab(item.folder_name)">
                                <span class="absolute inset-0 border-2 border-dashed border-black rounded"></span>
                                <div class="rounded px-6 py-4 flex flex-col justify-between h-full transform items-center border-2 border-black  bg-white transition-transform group-hover:-translate-x-2 group-hover:-translate-y-2">
                                    <!-- <div class="flex items-center h-20 w-20"> -->
                                        <img :src="'/math_manipulatives/thumbnails/'+item.thumbnail">
                                    <!-- </div> -->
                                    <h3 class="mt-2 text-xl font-medium sm:text-xl">{{ item.name }}</h3>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="bg-gray-50 rounded shadow p-6" v-if="$page.props.math_manipulatives.length">
                            <div class="p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-10">
                                    <div class="flex flex-col divide-y items-center justify-center bg-white rounded-lg overflow-hidden shadow-lg transform transition hover:scale-[0.99] hover:cursor-pointer" v-for="item in $page.props.math_manipulatives" @click="openNewTab(item.folder_name)">
                                        <div class="flex items-center h-60 w-60">
                                            <img :src="'/math_manipulatives/thumbnails/'+item.thumbnail">
                                        </div>
                                        <div class="w-full p-4 text-center bg-indigo-200">
                                            <h3 class="font-medium text-gray-900">{{ item.name }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="bg-white shadow-md rounded border" v-else>
                            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 lg:py-24">
                              <div class="max-w-3xl mx-auto text-center">
                                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-3xl">No math manipulatives have been added.</h2>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Head, Link,
    },
    methods: {
        openNewTab(folder_name){
            window.open(route('math_manipulatives.play', {name: folder_name}), '_blank')
        }
    }
}
</script>