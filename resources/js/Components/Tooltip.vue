<template>
    <div class="relative flex flex-col items-center group">
        <svg class="w-5 h-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
        </svg>
        <div class="absolute top-[-20px] left-[20px] flex-col items-center hidden mt-6 group-hover:flex">
            <div class="w-3 h-3 rotate-45 bg-gray-800 mr-[18rem]"></div>
            <span class="flex w-[300px] relative z-10 p-2 text-xs leading-none text-white whitespace-no-wrap bg-gray-800 shadow-lg rounded left-[5px] top-[-20px]" v-html="raw_HTML">

            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        raw_HTML: String
    }
};
</script>