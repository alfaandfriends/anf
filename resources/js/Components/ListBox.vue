<template>
    <div class="w-full">
        <Listbox 
            v-model="selectedItem" 
            :disabled="disable_options" 
            :default-value="$emit('update:modelValue', selectedItem.id)" 
            @update:modelValue="value => $emit('update:modelValue', selectedItem.id)"
        >
        <div class="relative mt-1">
            <ListboxButton
                class="cursor-pointer relative w-full rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-left shadow-md focus:outline-none focus-visible:border-indigo-500 focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-orange-300 sm:text-sm"
                :class="disable_options ? 'bg-gray-300' : ' bg-white'"
                >
                <span class="block truncate text-indigo-700 font-semibold">{{ selectedItem.name }}</span>
                <span
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                >
                    <ChevronDownIcon
                        class="h-5 w-5 text-gray-400"
                        aria-hidden="true"
                    />
                </span>
            </ListboxButton>

            <transition
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    class="z-10 absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                >
                    <ListboxOption
                        v-slot="{ active, selected }"
                        v-for="item in lists"
                        :key="item.id"
                        :value="item"
                        as="template"
                    >
                    <li
                        :class="[
                            active ? 'bg-indigo-100 text-indigo-900' : 'text-indigo-800',
                            'relative cursor-pointer select-none py-2 pl-10 pr-4 text-left',
                        ]"
                    >
                        <span
                            :class="[
                                selected ? 'font-medium' : 'font-normal',
                                'block truncate',
                            ]"
                        >{{ item.name }}</span
                        >
                        <span
                            v-if="selected"
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-indigo-600"
                        >
                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                        </span>
                    </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
        </Listbox>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import {
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import { CheckIcon, ChevronDownIcon } from '@heroicons/vue/solid'

const defaultOptions = [
    { id: '', name: 'Select an option' }
]

const props = defineProps({
    lists: {
        default: [],
        type: Object,
    },
    disable_options: {
        default: false,
        type: Boolean,
    },
});

const selectedItem = ref(props.lists.length ? props.lists[0] : defaultOptions[0])

</script>
