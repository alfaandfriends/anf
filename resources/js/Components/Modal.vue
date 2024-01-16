<script setup>
import BreezeButton from '@/Components/Button.vue';
</script>

<style scoped>
:deep(.modal-container){
  display: flex;
  justify-content: center;
  align-items: center;
  overflow-y: auto;
  margin-top: 10px;
  margin-bottom: 10px;
}
</style>

<template>
<VueFinalModal v-model="show_modal" :click-to-close="false" classes="modal-container" :content-class="checkClasses">
    <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
        <slot name="header"></slot>
        <button type="button" @click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
    <slot name="content"></slot>
    <slot name="footer"></slot>
</VueFinalModal>
</template>

<script>
    import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal'
    export default {

        components: {
            VueFinalModal, ModalsContainer
        },
        data(){
            return{
                show_modal: this.showModal
            }
        },
        watch: {
            showModal: {
                handler(){
                    this.show_modal = this.showModal
                },
                immediate: true
            },
        },
        props: {
            classes: String,
            showModal: Boolean,
            modalType: String,
        },
        methods: {
            closeModal(){
                this.$emit('hideModal')
            }
        },
        computed: {
            checkClasses() {
                if (this.modalType === 'xs') {
                    return 'my-auto h-auto w-11/12 sm:w-7/12 md:w-6/12 lg:w-5/12 xl:w-4/12 2xl:w-3/12 bg-white rounded overflow-y-auto';
                } 
                else if (this.modalType === 'sm') {
                    return 'my-auto h-auto w-11/12 sm:w-8/12 md:w-7/12 lg:w-6/12 xl:w-5/12 2xl:w-4/12 bg-white rounded overflow-y-auto';
                } 
                else if (this.modalType === 'md') {
                    return 'my-auto h-auto w-11/12 sm:w-9/12 md:w-8/12 lg:w-7/12 xl:w-6/12 2xl:w-5/12 bg-white rounded overflow-y-auto';
                } 
                else if (this.modalType === 'lg') {
                    return 'my-auto h-auto w-11/12 sm:w-10/12 md:w-9/12 lg:w-8/12 xl:w-7/12 2xl:w-6/12 bg-white rounded overflow-y-auto';
                } 
                else if (this.modalType === 'xl') {
                    return 'my-auto h-auto w-11/12 sm:w-11/12 md:w-10/12 lg:w-9/12 xl:w-8/12 2xl:w-7/12 bg-white rounded overflow-y-auto';
                } 
                else {
                    return 'my-auto h-auto w-11/12 sm:w-9/12 md:w-8/12 lg:w-7/12 xl:w-6/12 2xl:w-5/12 bg-white rounded overflow-y-auto';
                }
            },
        },
    }
</script>
