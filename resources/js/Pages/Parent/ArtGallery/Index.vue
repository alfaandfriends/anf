<template>
    <Authenticated>
        <div class="relative overflow-x-auto mt-4">
            <div class="flex justify-between items-center text-center" style="width: 600px;">
                <div class="mt-auto">
                    <h1 class="text-2xl">Art Gallery</h1>
                </div>
                <div class="bg-indigo-700 border-b-2 border-indigo-800 rounded-xl hover:bg-indigo-600">
                    <button type="button" class="flex items-center justify-center w-full p-2 font-semibold text-white">Upload</button>
                </div>
            </div>
            <hr class="my-4 border-gray-600">
            <div class="flex justify-between items-center text-center" style="width: 600px;">
                <ListBox :lists="levels" />
                <ListBox :lists="topics" />
            </div>
            <p class="mt-10">Lesson 1: Paiting the Beach Scenery</p>
            <hr class="my-4 border-gray-600">
            <div class="grid gap-4 grid-cols-3">
                <div v-for="(image, index) in images" :key="index" class="relative">
                    <img :src="image.url" alt="Image" class="w-full h-40 object-cover rounded-lg" />
                    <button @click="deleteImage(index)" class="absolute bottom-0 w-full bg-red-600 text-white">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import ListBox from '@/Components/ListBox.vue';
import { ref } from 'vue';

const images = ref([
    { url: 'https://placehold.co/200x200' },
    { url: 'https://placehold.co/200x200' },
    { url: 'https://placehold.co/200x200' },
]);

const levels = [
    { name: 'Level 1' },
    { name: 'Level 2' },
    { name: 'Level 3' },
    { name: 'Level 4' },
]

const topics = [
    { name: 'ArtVenture to the beach' },
    { name: 'Arlene Mccoy' },
    { name: 'Devon Webb' },
    { name: 'Tom Cook' },
    { name: 'Tanya Fox' },
    { name: 'Hellen Schmidt' },
]
</script>
