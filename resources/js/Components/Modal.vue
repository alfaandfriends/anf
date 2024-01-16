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
    <slot name="header"></slot>
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
