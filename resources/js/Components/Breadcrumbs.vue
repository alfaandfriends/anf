<template>
    <Breadcrumb class="mb-1 shadow p-3 rounded-md bg-white">
        <BreadcrumbList v-if="breadcrumbs">
            <template v-for="(breadcrumb, index) in breadcrumbs" :key="index">
                <BreadcrumbSeparator v-if="index >= 1"/>
                <template v-if="index == 0 && breadcrumbs.length <= 1">
                    <BreadcrumbItem>
                        <BreadcrumbItem>
                            <BreadcrumbPage>{{ breadcrumb.title }}</BreadcrumbPage>
                        </BreadcrumbItem>
                    </BreadcrumbItem>
                </template>
                <template v-else-if="index == 0 && breadcrumbs.length > 1 || (index+1) < breadcrumbs.length">
                    <BreadcrumbItem>
                        <BreadcrumbLink :href="breadcrumb.url">
                            {{ breadcrumb.title }}
                        </BreadcrumbLink>
                    </BreadcrumbItem>
                </template>
                <template v-else>
                    <BreadcrumbItem>
                        <BreadcrumbPage>{{ breadcrumb.title }}</BreadcrumbPage>
                    </BreadcrumbItem>
                </template>
            </template>
        </BreadcrumbList>
        <BreadcrumbList v-else>
            <BreadcrumbItem>
                <BreadcrumbPage>Please set breadcrumbs at routes/breadcrumbs.php</BreadcrumbPage>
            </BreadcrumbItem>
        </BreadcrumbList>
    </Breadcrumb>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator } from '@/Components/ui/breadcrumb'

export default {
    components: {
        Link, Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator,
    },
    props: {
        breadcrumbs: Object
    }
}
</script>
