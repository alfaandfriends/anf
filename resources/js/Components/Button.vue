<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    buttonType: {
        buttonType: String,
        default: 'info',
    },
    route: {
        route: String,
        default: '',
    },
    class: {
        class: String,
        default: '',
    }
});
</script>

<template> 
    <button v-if="buttonType == 'success'" :type="type" class="shadow-md inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="class" @click="setAction">
        <slot />
    </button>
    <button v-if="buttonType == 'info'" :type="type" class="shadow-md inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="class" @click="setAction">
        <slot />
    </button>
    <button v-if="buttonType == 'warning'" :type="type" class="shadow-md inline-flex items-center px-2 py-1 bg-yellow-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="class" @click="setAction">
        <slot />
    </button>
    <button v-if="buttonType == 'danger'" :type="type" class="shadow-md inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="class" @click="setAction">
        <slot />
    </button>
    <button v-if="buttonType == 'blue'" :type="type" class="shadow-md inline-flex items-center px-2 py-1 bg-blue-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="class" @click="setAction">
        <slot />
    </button>
    <button v-if="buttonType == 'gray'" :type="type" class="shadow-md inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="class" @click="setAction">
        <slot />
    </button>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia'
    export default{
        methods: {
            setAction(){
                if(!this.route){
                    this.$emit('click')
                }
                else{
                    Inertia.visit(this.route)
                }
            }
        }
    }
</script>




