<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Math Manipulatives" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>
                <div class="flex justify-between items-center">
                    Resource Information
                    <Button @click="$inertia.get(route('math_manipulatives.configuration'))">
                        <Cog class="h-4 w-4" />
                        <span class="ml-1 hidden sm:block">Configuration</span>
                    </Button>
                </div>
            </template>
            <template #content>
                <div class="grid grid-cols-1 px-11">
                    <Carousel
                    class="relative w-full"
                    :opts="{
                        align: 'start',
                    }"
                    >
                    <CarouselContent>
                        <CarouselItem v-for="item, index in $page.props.math_manipulatives" :key="index" class="sm:basis-1/2 lg:basis-1/3 xl:basis-1/4 2xl:basis-1/5">
                            <Card>
                                <template #content>
                                    <div class="flex flex-col items-center select-none hover:scale-105 duration-150 cursor-pointer min-h-48" @click="openNewTab(item.folder_name)">
                                        <img :src="'/math_manipulatives/thumbnails/'+item.thumbnail" class="w-36 h-36">
                                        <div class="mt-2 font-medium text-center text-sm">{{ item.name }}</div>
                                    </div>
                                </template>
                            </Card>
                        </CarouselItem>
                    </CarouselContent>
                    <CarouselPrevious />
                    <CarouselNext />
                    </Carousel>
                </div>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious, } from '@/Components/ui/carousel'
import Card from '@/Components/Card.vue'
import { Cog } from 'lucide-vue-next';

export default {
    components: {
        Head, Link,
    },
    methods: {
        openNewTab(folder_name){
            window.open(route('math_manipulatives.play', {name: folder_name}), '_blank')
        }
    }
}
</script>