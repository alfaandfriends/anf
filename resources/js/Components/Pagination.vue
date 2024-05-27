<template v-if="page_data.data.length">
        <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" :class="computedClass">
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
                            :href="link.url !== null && link.url !== '' ? link.url + (this.url ? '&' + this.url : '') : null"
                            :class="(link.active == false && link.url == null ? 'select-none bg-white border-gray-200 text-gray-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium cursor-not-allowed'
                                                : (link.active ? 'select-none z-10 bg-indgo-i50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium' 
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
    export default {
        data(){
            return{
                url: ''
            }
        },  
        props:{
            page_data: Object,
            params: Object,
            class: String
        },
        methods: {
            objectToQueryString(obj, parentKey = '') {
                const queryString = [];

                for (const key in obj) {
                    if (obj.hasOwnProperty(key)) {
                    const value = obj[key];
                    const paramKey = parentKey ? `${parentKey}[${key}]` : key;

                    if (typeof value === 'object' && !Array.isArray(value)) {
                        // If the value is an object, recursively convert it to a query string
                        queryString.push(this.objectToQueryString(value, paramKey));
                    } else {
                        // Otherwise, encode the key and value and add to the query string
                        queryString.push(`${encodeURIComponent(paramKey)}=${encodeURIComponent(value)}`);
                    }
                    }
                }

                return queryString.join('&');
            },
            generateQueryString() {
                this.url    =   this.objectToQueryString(this.params);
            }
        },
        mounted() {
            // Call the function to generate the query string when the component is mounted
            this.generateQueryString();
        },
        // created(){
        //     this.url    =   Object.keys(this.params).map(key => key + '=' + this.params[key]).join('&')
        // },
        updated(){
            this.generateQueryString();
        },
        computed: {
            computedClass() {
                return {
                    [this.class]: this.class,
                    'bg-gray-200': !this.class
                }
            }
        }
    }
</script>