<template>
    <div>
        <div class="relative">
            <input
                type="file"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                @input="emit('update:value', $event.target.files[0])"
            />
            <div v-if="previewUrl" class="relative w-24 h-24">
                <img :src="previewUrl" alt="Preview" class="object-cover w-full h-full" />
            </div>
            <div v-else class="w-24 h-24 border-2 border-dashed border-gray-400 flex items-center justify-center">
                <p class="text-gray-400">+</p>
            </div>
        </div>
    </div>
</template>

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
