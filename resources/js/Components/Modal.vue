<script setup>
import BreezeButton from '@/Components/Button.vue';
</script>

<style scoped>
:deep(.modal-container){
  display: flex;
  justify-content: center;
  align-items: center;
}
:deep(.modal-content-sm) {
  position: relative;
  display: flex;
  flex-direction: column;
  margin: 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.25rem;
  background: #fff;
  min-width: 25%;
  max-width: 30%;
  max-height: 90%;
}
:deep(.modal-content) {
  position: relative;
  display: flex;
  flex-direction: column;
  margin: 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.25rem;
  background: #fff;
  width: 45%;
  max-height: 90%;
}
:deep(.modal-content-lg) {
  position: relative;
  display: flex;
  flex-direction: column;
  margin: 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.25rem;
  background: #fff;
  width: 80%;
  max-height: 90%;
}
</style>

<template>
    <VueFinalModal v-if="modalType=='sm'" v-model="show_modal" :click-to-close="false" classes="modal-container" content-class="modal-content-sm">
        <div class="flex items-start justify-between py-3 px-4 border-b rounded-t">
            <slot name="header"></slot>
            <button type="button" @click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
            </button>
        </div>
        <slot name="content"></slot>        
        <slot name="footer"></slot>
    </VueFinalModal>
    <VueFinalModal v-else-if="modalType=='lg'" v-model="show_modal" :click-to-close="false" classes="modal-container" content-class="modal-content-lg">
        <div class="flex items-start justify-between py-3 px-5 border-b rounded-t">
            <slot name="header"></slot>
            <button type="button" @click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
            </button>
        </div>
        <slot name="content"></slot>        
        <slot name="footer"></slot>
    </VueFinalModal>
    <VueFinalModal v-else v-model="show_modal" :click-to-close="false" classes="modal-container" content-class="modal-content">
        <div class="flex items-start justify-between py-3 px-5 border-b rounded-t">
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
                }
            },
            immediate: true
        },
        props: {
            showModal: Boolean,
            modalType: String,
        },
        methods: {
            closeModal(){
                this.$emit('hideModal')
            }
        }
    }
</script>