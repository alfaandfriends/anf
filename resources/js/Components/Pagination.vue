<template v-if="page_data.data.length">
    <div class="text-center">
        <Pagination v-slot="{ page }" :total="page_data.total" :sibling-count="1" show-edges :default-page="page_data.current_page">
            <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                <PaginationFirst />
            
                <template v-for="(item, index) in items">
                    <PaginationListItem v-if="item.type === 'page'" :key="index" :value="item.value" as-child @click="$inertia.get(page_data.path + '?page=' + item.value)">
                        <Button class="w-10 h-10 p-0" :variant="item.value === page_data.current_page ? 'default' : 'outline'">
                            {{ item.value }}
                        </Button>
                    </PaginationListItem>
                    <PaginationEllipsis v-else :key="item.type" :index="index" />
                </template>
            
                <PaginationLast />
            </PaginationList>
        </Pagination>
    </div>
</template>

<script>
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from '@/Components/ui/pagination'

import {
    Button,
} from '@/components/ui/button'
    export default {
    components: {
        Pagination,
        PaginationEllipsis,
        PaginationFirst,
        PaginationLast,
        PaginationList,
        PaginationListItem,
        PaginationNext,
        PaginationPrev, Button
    },
        data(){
            return{
                url: ''
            }
        },  
        props:{
            page_data: Object,
            params: Object
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
    }
</script>