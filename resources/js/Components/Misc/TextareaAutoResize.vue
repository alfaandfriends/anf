<template>
    <textarea :name="name" class="textarea" @input="$emit('input', $event.target.value), resize($event)" :value="value" placeholder="Write a comment..." rows="1"> </textarea>
</template>

<script>
export default {
    props: {
        name: {
            required: true,
            type: String,
        },
        value: {
            required: false,
        },
    },
    methods: {
        resize(e) {
            e.target.style.height = 'auto'
            e.target.style.height = `${e.target.scrollHeight}px`
        },
    },
}
</script>

<style scoped>
.textarea {
    width: 100%;
    border: 2px solid #ddd;
    border-radius: 0.75rem;
    font-size: inherit;
    outline: none;
    padding: 12px;
    box-sizing: border-box;
    overflow: hidden;
    resize: none;
}
</style>
