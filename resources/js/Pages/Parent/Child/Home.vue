<template>
    <div class="bg-gray-100">
        <div class="grid justify-center max-w-4xl grid-cols-5 gap-8 px-3 py-5 mx-auto">
            <div class="col-span-5 md:col-span-2">
                <ChildAvatar />
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Child Home',
    components: {
        ChildAvatar,
    },
}
</script>
