<template>
    <div>
        <button v-if="buttonType == 'success'" :type="type" class="shadow-md inline-flex items-center bg-green-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : 'px-4 py-2'">
            <slot />
        </button>
        <button v-if="buttonType == 'info'" :type="type" class="shadow-md inline-flex items-center bg-indigo-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : 'px-4 py-2'">
            <slot />
        </button>
        <button v-if="buttonType == 'warning'" :type="type" class="shadow-md inline-flex items-center bg-yellow-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : ' px-2 py-1'">
            <slot />
        </button>
        <button v-if="buttonType == 'danger'" :type="type" class="shadow-md inline-flex items-center bg-red-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : ' px-2 py-1'">
            <slot />
        </button>
        <button v-if="buttonType == 'blue'" :type="type" class="shadow-md inline-flex items-center bg-blue-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : ' px-2 py-1'">
            <slot />
        </button>
        <button v-if="buttonType == 'gray'" :type="type" class="shadow-md inline-flex items-center bg-gray-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : 'px-4 py-2'">
            <slot />
        </button>
    </div>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia'
    export default{
        props:{
            type: {
                type: String,
                default: 'button',
            },
            buttonType: {
                type: String,
                default: 'info',
            },
            route: {
                type: String,
                default: '',
            },
            class: {
                type: String,
                default: '',
            }
        },
    }
</script>




