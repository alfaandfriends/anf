<template>
    <div class="modal-wrapper" v-if="open">
        <div class="modal-overlay" @click="disable_overlay ? '' : emit('close:modal')"></div>
        <div class="modal-content" :class="class">
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
import { ref, onUnmounted, watch } from 'vue';

const props = defineProps({
    disable_overlay: {
        type: Boolean,
    },
    open: {
        type: Boolean,
    },
    class: {
        default: '',
        type: String,
    },
});
const emit = defineEmits(['close:modal']);
</script>

<script>
export default {
    data(){
        return{
            modal_open: false
        }
    },
    watch: {
        open: {
            deep: true,
            handler() {
                if (this.open) {
                    // Prevent scrolling when modal is open
                    document.body.style.overflow = 'hidden';
                } else {
                    // Restore scrolling when modal is closed
                    document.body.style.overflow = '';
                }
            },
        },
    },
    created(){
        document.body.style.overflow = 'hidden';
    },
    unmounted() {
        document.body.style.overflow = '';
    },
}
</script>

<style>
/* Style the modal overlay and content */
.modal-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 9000;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    border-radius: 8px;
    z-index: 9100;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
}

/* Style the close button */
.modal-close-button {
    margin-top: 10px;
    padding: 8px 16px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
</style>
