<template>
    <div>
        <button v-if="buttonType == 'blue'" :type="type" class="rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-blue-500 text-blue-600 focus:outline-none" @click="goTo">
            <span class="rounded absolute inset-0 border border-current"></span>
            <span class="flex space-x-1 rounded border border-current bg-blue-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : ' px-4 py-1'">
                <slot />
            </span>
        </button>
        <button v-if="buttonType == 'warning'" :type="type" class="rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-yellow-500 text-yellow-600 focus:outline-none" @click="goTo">
            <span class="rounded absolute inset-0 border border-current"></span>
            <span class="flex space-x-1 rounded border border-current bg-yellow-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : ' px-4 py-1'">
                <slot />
            </span>
        </button>
        <button v-if="buttonType == 'danger'" :type="type" class="rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-red-500 text-red-600 focus:outline-none" @click="goTo">
            <span class="rounded absolute inset-0 border border-current"></span>
            <span class="flex space-x-1 rounded border border-current bg-red-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : ' px-4 py-1'">
                <slot />
            </span>
        </button>
        <button v-if="buttonType == 'info'" :type="type" class="rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-indigo-500 text-indigo-600 focus:outline-none" @click="goTo">
            <span class="rounded absolute inset-0 border border-current"></span>
            <span class="flex space-x-1 items-center rounded border border-current bg-indigo-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : 'px-4 py-2'">
                <slot />
            </span>
        </button>
        <button v-if="buttonType == 'success'" :type="type" class="rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-green-500 text-green-600 focus:outline-none" @click="goTo">
            <span class="rounded absolute inset-0 border border-current"></span>
            <span class="flex space-x-1 rounded border border-current bg-green-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : 'px-4 py-2'">
                <slot />
            </span>
        </button>
        <button v-if="buttonType == 'gray'" :type="type" class="rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-gray-500 text-gray-600 focus:outline-none" @click="goTo">
            <span class="rounded absolute inset-0 border border-current"></span>
            <span class="flex space-x-1 rounded border border-current bg-gray-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : 'px-4 py-2'">
                <slot />
            </span>
        </button>
        <!-- <button v-if="buttonType == 'success'" :type="type" class="inline-flex items-center bg-green-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : 'px-4 py-2'" @click="goTo">
            <slot />
        </button> -->
        <!-- <button v-if="buttonType == 'info'" :type="type" class="inline-flex items-center bg-indigo-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : 'px-4 py-2'" @click="goTo">
            <slot />
        </button> -->
        <!-- <button v-if="buttonType == 'warning'" :type="type" class="inline-flex items-center bg-yellow-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : ' px-2 py-1'" @click="goTo">
            <slot />
        </button> -->
        <!-- <button v-if="buttonType == 'danger'" :type="type" class="inline-flex items-center bg-red-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : ' px-2 py-1'" @click="goTo">
            <slot />
        </button> -->
        <!-- <button v-if="buttonType == 'blue'" :type="type" class="inline-flex items-center bg-blue-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : ' px-2 py-1'" @click="goTo">
            <slot />
        </button> -->
        <!-- <button v-if="buttonType == 'gray'" :type="type" class="inline-flex items-center bg-gray-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="this.class ? this.class : 'px-4 py-2'" @click="goTo">
            <slot />
        </button> -->
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
        methods: {
            goTo(){
                this.route ? this.$inertia.visit(this.route) : ''
            }
        }
    }
</script>




