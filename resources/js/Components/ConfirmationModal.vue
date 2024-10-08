<template>
  <TransitionRoot :show="open">
    <Dialog as="div" class="fixed z-40 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
          <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10" v-if="confirmationAlert == 'info'">
                  <InformationCircleIcon class="h-6 w-6 text-blue-600" aria-hidden="true"/>
                </div>
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10" v-if="confirmationAlert == 'danger'">
                  <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true"/>
                </div>
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10" v-if="confirmationAlert == 'warning'">
                  <ExclamationCircleIcon class="h-6 w-6 text-yellow-600" aria-hidden="true"/>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> {{ confirmationTitle }} </DialogTitle>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500" v-html="confirmationText"></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed" :class="confirmationClass" :disabled="processing" @click="$emit('close')">
                    Cancel
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-offset-2 focus:ring-0 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed" :disabled="processing" @click="submit">
                    <svg v-if="processing == true" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ processing == false ? confirmationButton : 'Processing'}}
                </button>
            </div>
          </div>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationIcon, InformationCircleIcon, ExclamationCircleIcon } from '@heroicons/vue/outline'

export default {
    components: {
        Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot,
        ExclamationIcon, InformationCircleIcon, ExclamationCircleIcon
    },
    props: {
        open: Boolean,
        confirmationTitle: String,
        confirmationText: String,
        confirmationAlert: String,
        confirmationButton: String,
        confirmationMethod: String,
        confirmationRoute: String,
        confirmationData: [String, Number],
        preserveScroll: {
            type: Boolean,
            default: true,
        },
        preserveState: {
            type: Boolean,
            default: false,
        },
    },
    data(){
      return{
        confirmationClass: '',
        processing: false
      }
    },
    updated(){
      if(this.confirmationAlert == 'info'){
        this.confirmationClass = 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'
      }
      if(this.confirmationAlert == 'warning'){
        this.confirmationClass = 'bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-200'
      }
      if(this.confirmationAlert == 'danger'){
        this.confirmationClass = 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
      }
    },
    methods:{
        submit(){
            if(this.confirmationMethod == 'delete'){
                this.$inertia.delete(this.route(this.confirmationRoute, this.confirmationData), {
                    preserveScroll: this.preserveScroll,
                    preserveState: this.preserveState,
                    onStart: () => this.processing = true,
                    onSuccess: ()  =>  {
                        this.$emit('close'),
                        this.processing = false
                    },
                })
            }
            if(this.confirmationMethod == 'post'){
                this.$inertia.post(this.route(this.confirmationRoute), {data: this.confirmationData},{
                    preserveScroll: this.preserveScroll,
                    preserveState: this.preserveState,
                    onStart: () => this.processing = true,
                    onSuccess: ()  =>  {
                        this.$emit('close'),
                        this.processing = false
                    },
                })
            }
        }
    }
}
</script>
