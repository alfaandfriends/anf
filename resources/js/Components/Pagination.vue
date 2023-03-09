<template v-if="page_data.data.length">
        <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gray-300">
            <div class="flex-1 flex justify-between sm:hidden">
                <a :href="page_data.prev_page_url" v-if="page_data.prev_page_url" @click="handleClick($event, page_data.prev_page_url)" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                <a :href="page_data.next_page_url"  v-if="page_data.next_page_url" @click="handleClick($event, page_data.prev_page_url)" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">{{ page_data.from }}</span>
                        to
                        <span class="font-medium">{{ page_data.to }}</span>
                        of
                        <span class="font-medium">{{ page_data.total }}</span>
                        results
                    </p>
                </div>
                <div>
                    <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                        <a v-for="(link, key) in page_data.links"
                            :key="key"
                            :href="link.url !== null && link.url !== '' ? link.url + (params ? params : '') : null"
                            :class="(link.active == false && link.url == null ? 'select-none bg-white border-gray-200 text-gray-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium cursor-not-allowed'
                                                : (link.active ? 'select-none z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium' 
                                                                                        : ('select-none bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium')))"  
                            v-html="link.label"
                        >
                        </a>
                    </nav>
                </div>
            </div>
        </div>
</template>

<script>
    export default{
        props:{
            page_data: Object,
            params: String
        }
    }
</script>