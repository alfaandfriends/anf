<template>
    <div class="toggle-radio">
        <div v-for="(option, index) in props.options" :key="index" class="toggle-radio-option">
            <input
                type="radio"
                :id="'option-' + index"
                :value="option.value"
                v-model="selectedOption"
                @change="selectOption(selectedOption)"
            />
            <label :for="'option-' + index">{{ option.label }}</label>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    options: {
        type: Array,
        required: true
    },
    value: {
        type: String,
        required: true
    }
});
const emit = defineEmits(['update:value']);

const selectedOption = ref(props.value);

const selectOption = (value) => {
    selectedOption.value = value;
    emit("update:value", value);
};
</script>

<style scoped>
.toggle-radio {
    display: flex;
}

.toggle-radio-option {
    margin-right: 10px;
}

.toggle-radio-option input[type="radio"] {
    display: none;
}

.toggle-radio-option label {
    cursor: pointer;
    padding: 5px 10px;
    border: 1px solid #ccc;
}

.toggle-radio-option input[type="radio"]:checked + label {
    background-color: #ccc;
}
</style>
