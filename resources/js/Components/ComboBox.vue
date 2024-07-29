<template>
  <Popover v-model:open="isOpen">
    <PopoverTrigger as-child>
      <Button
        variant="outline"
        class="w-full justify-between"
        @click="togglePopover"
      >
        {{ selectedItem ? (isObjectItems ? selectedItem[labelProperty] : selectedItem) : selectPlaceholder }}
        <CaretSortIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
      </Button>
    </PopoverTrigger>
    <PopoverContent class="flex w-full p-0 min-w-[var(--radix-popover-trigger-width)]">
      <Command>
        <CommandInput class="h-9" :placeholder="searchPlaceholder" v-model="searchQuery" />
        <CommandEmpty class="py-4">{{ loading ? 'Searching...' : 'No results found.' }}</CommandEmpty>
        <CommandList>
          <CommandGroup>
            <CommandItem
              v-for="item in filteredItems"
              :key="isObjectItems ? item[valueProperty] : item"
              :value="isObjectItems ? item[labelProperty] : item"
              @select="selectItem(item)"
            >
              {{ isObjectItems ? item[labelProperty] : item }}
              <CheckIcon
                :class="[
                  'ml-auto h-4 w-4',
                  {
                    'opacity-100': isObjectItems ? selectedItem?.[valueProperty] === item[valueProperty] : selectedItem === item,
                    'opacity-0': !(isObjectItems ? selectedItem?.[valueProperty] === item[valueProperty] : selectedItem === item),
                  },
                ]"
              />
            </CommandItem>
          </CommandGroup>
        </CommandList>
      </Command>
    </PopoverContent>
  </Popover>
</template>

<script>
import { CaretSortIcon, CheckIcon } from '@radix-icons/vue'
import { Command, CommandDialog, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList, CommandSeparator, CommandShortcut } from '@/Components/ui/command'
import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover'

export default {
  components: { 
    CaretSortIcon, CheckIcon, Command, CommandDialog, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList, CommandSeparator, CommandShortcut,
    Popover, PopoverContent, PopoverTrigger
  },
  props: {
    items: {
      type: Array,
      required: true,
    },
    modelValue: {
      type: [String, Number, Object],
      required: false,
    },
    labelProperty: {
      type: String,
      default: 'name',
    },
    valueProperty: {
      type: String,
      default: 'id',
    },
    placeholder: {
      type: String,
      default: 'Select Country',
    },
    selectPlaceholder: {
      type: String,
      default: 'Select Option',
    },
    searchPlaceholder: {
      type: String,
      default: 'Search option...',
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      isOpen: false,
      searchQuery: '',
    };
  },
  computed: {
    isObjectItems() {
      return this.items.length > 0 && typeof this.items[0] === 'object';
    },
    selectedItem() {
      if (this.isObjectItems) {
        return this.items.find(item => item[this.valueProperty] === this.modelValue);
      }
      return this.modelValue;
    },
    filteredItems() {
      if (this.isObjectItems) {
        return this.items.filter(item =>
          item[this.labelProperty].toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }
      return this.items.filter(item =>
        item.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  methods: {
    togglePopover() {
      this.isOpen = true;
    },
    selectItem(item) {
      this.$emit('update:modelValue', this.isObjectItems ? item[this.valueProperty] : item);
      this.isOpen = false;
    },
  },
};
</script>

<style>
.popover-content-width-same-as-its-trigger{
  width: "var(--radix-popover-trigger-width)";
  max-height: "var(--radix-popover-content-available-height)";
}
</style>
