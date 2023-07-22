<template>
    <Authenticated>
        <div class="grid justify-center max-w-4xl grid-cols-5 gap-8 px-3 py-5 mx-auto">
            <!-- Child Switcher -->
            <div class="col-span-5 md:col-span-2">
                <ChildSwitcher />
            </div>
            <!-- Parent Feeds -->
            <div class="col-span-5 md:col-span-3">
                <ParentFeeds />
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import ChildSwitcher from '@/Components/ChildSwitcher.vue'
import ParentFeeds from '@/Components/Story.vue'
</script>
