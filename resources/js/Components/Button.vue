<template>
<div>
    <button v-if="buttonType == 'blue'" :type="type" class="hs-tooltip hs-tooltip-toggle rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-blue-500 text-blue-600 focus:outline-none" @click="goTo">
        <span class="rounded absolute inset-0 border border-current"></span>
        <span class="flex space-x-1 rounded border border-current bg-blue-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : ' px-4 py-1'">
            <slot />
        </span>
        <span v-if="tooltip" class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 z-50 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm dark:bg-neutral-700" role="tooltip" style="position: fixed; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(322px, -50.8px, 0px);" data-popper-placement="top">
            {{ tooltip }}
        </span>
    </button>
    <button v-if="buttonType == 'warning'" :type="type" class="hs-tooltip hs-tooltip-toggle rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-yellow-500 text-yellow-600 focus:outline-none" @click="goTo">
        <span class="rounded absolute inset-0 border border-current"></span>
        <span class="flex space-x-1 rounded border border-current bg-yellow-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : ' px-4 py-1'">
            <slot />
        </span>
        <span v-if="tooltip" class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 z-50 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm dark:bg-neutral-700" role="tooltip" style="position: fixed; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(322px, -50.8px, 0px);" data-popper-placement="top">
            {{ tooltip }}
        </span>
    </button>
    <button v-if="buttonType == 'danger'" :type="type" class="hs-tooltip hs-tooltip-toggle rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-red-500 text-red-600 focus:outline-none" @click="goTo">
        <span class="rounded absolute inset-0 border border-current"></span>
        <span class="flex space-x-1 rounded border border-current bg-red-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : ' px-4 py-1'">
            <slot />
        </span>
        <span v-if="tooltip" class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 z-50 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm dark:bg-neutral-700" role="tooltip" style="position: fixed; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(322px, -50.8px, 0px);" data-popper-placement="top">
            {{ tooltip }}
        </span>
    </button>
    <button v-if="buttonType == 'info'" :type="type" class="hs-tooltip hs-tooltip-toggle rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-indigo-500 text-indigo-600 focus:outline-none" @click="goTo">
        <span class="rounded absolute inset-0 border border-current"></span>
        <span class="flex space-x-1 items-center rounded border border-current bg-indigo-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : 'px-4 py-2'">
            <slot />
        </span>
        <span v-if="tooltip" class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 z-50 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm dark:bg-neutral-700" role="tooltip" style="position: fixed; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(322px, -50.8px, 0px);" data-popper-placement="top">
            {{ tooltip }}
        </span>
    </button>
    <button v-if="buttonType == 'success'" :type="type" class="hs-tooltip hs-tooltip-toggle rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-green-500 text-green-600 focus:outline-none" @click="goTo">
        <span class="rounded absolute inset-0 border border-current"></span>
        <span class="flex space-x-1 rounded border border-current bg-green-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : 'px-4 py-2'">
            <slot />
        </span>
        <span v-if="tooltip" class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 z-50 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm dark:bg-neutral-700" role="tooltip" style="position: fixed; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(322px, -50.8px, 0px);" data-popper-placement="top">
            {{ tooltip }}
        </span>
    </button>
    <button v-if="buttonType == 'gray'" :type="type" class="hs-tooltip hs-tooltip-toggle rounded capitalize tracking-normal group relative inline-block text-sm font-medium bg-gray-500 text-gray-600 focus:outline-none" @click="goTo">
        <span class="rounded absolute inset-0 border border-current"></span>
        <span class="flex space-x-1 rounded border border-current bg-gray-50 transition-transform -translate-x-0.5 -translate-y-0.5  group-hover:-translate-x-0 group-hover:-translate-y-0" :class="this.class ? this.class : 'px-4 py-2'">
            <slot />
        </span>
        <span v-if="tooltip" class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 z-50 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm dark:bg-neutral-700" role="tooltip" style="position: fixed; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(322px, -50.8px, 0px);" data-popper-placement="top">
            {{ tooltip }}
        </span>
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
            },
            tooltip: {
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




