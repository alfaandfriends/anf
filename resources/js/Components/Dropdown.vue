<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    align: {
        default: 'right'
    },
    width: {
        default: '48'
    },
    contentClasses: {
        default: () => ['bg-white']
    }
});

// const closeOnEscape = (e) => {
//     if (open.value && e.key === 'Escape' || open.value && e.click ) {
//         open.value = false;
//     }
// };

// onMounted(() => document.addEventListener('keydown', closeOnEscape));
// onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
    return {
        '48': 'w-48',
        '72': 'w-72',
        '80': 'w-80',
        '96': 'w-96',
    }[props.width.toString()];
});

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'origin-top-left left-0';
    } else if (props.align === 'right') {
        return 'origin-top-right right-0';
    } else {
        return 'origin-top';
    }
});
</script>

<template>
    <div class="relative">
        <div @click="open = ! open">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-if="open" v-show="open" class="fixed inset-0 z-40" @click="closeOverlay()"></div>

        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <div v-show="open"
                    class="absolute z-50 mt-2 rounded-md shadow-lg"
                    :class="[widthClass, alignmentClasses]"
                    style="display: none;"
                    @click="open = false">
                <div class="rounded-md ring-0 ring-red-500 ring-opacity-5" :class="contentClasses">
                    <slot name="content" />
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    data(){
        return{
            open: false
        }
    },
    methods: {
        closeOverlay(){
            this.open = false
            this.$emit('close-notification', 'true')
        }
    }
}
</script>