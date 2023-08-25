<template>
    <div>
        <div class="relative">
            <div v-if="previewUrl" class="flex justify-center items-center relative w-24 h-24 border border-gray-400 cursor-pointer">
                <img :src="previewUrl" alt="Preview" class="object-fill w-full h-full" style="margin: 0px"/>
            </div>
            <div v-else class="w-24 h-24 border-2 border-dashed border-gray-400 flex items-center justify-center cursor-pointer">
                <p class="text-gray-400">+</p>
            </div>
            <input
                type="file"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                @input="emit('update:value', $event.target.files[0])"
                @click="resetInput"
            />
        </div>
    </div>
</template>
<script>
export default {
    methods: {
        resetInput(event) {
            event.target.value = null;
        },
    }
}
</script>
<script setup>
const props = defineProps({
    previewUrl: {
        required: true,
    },
});

const emit = defineEmits(['update:value']);
</script>

<style scoped>
img {
    max-width: 100%;
    height: auto;
    margin-top: 10px;
}
</style>
