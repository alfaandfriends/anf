<template>
  <Popover v-model:open="isOpen">
    <PopoverTrigger as-child click="togglePopover">
      <Button
        variant="outline"
        class="w-full justify-between"
      >
        {{ multiple ? `${selectedItems.length} selected` : (selectedItem ? (isObjectItems ? selectedItem[labelProperty] : selectedItem) : selectPlaceholder) }}
        <CaretSortIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
      </Button>
    </PopoverTrigger>
    <PopoverContent class="flex w-full p-0 min-w-[var(--radix-popover-trigger-width)]">
      <Command>
        <CommandInput class="h-9" :placeholder="searchPlaceholder" v-model="searchQuery" @input="handleInput" />
        <CommandEmpty class="py-4">{{ loading ? 'Searching...' : 'No results found.' }}</CommandEmpty>
        <CommandList>
          <CommandGroup>
            <!-- Select All Option -->
            <CommandItem @select="selectAll" v-if="multiple" value="null">
              <span class="font-bold">Select All</span>
            </CommandItem>
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
                    'opacity-100': multiple
                      ? this.selectedItems.includes(isObjectItems ? item[this.valueProperty] : item)
                      : (isObjectItems ? selectedItem?.[valueProperty] === item[valueProperty] : selectedItem === item),
                    'opacity-0': !multiple
                      ? !(isObjectItems ? selectedItem?.[valueProperty] === item[valueProperty] : selectedItem === item)
                      : !this.selectedItems.includes(isObjectItems ? item[this.valueProperty] : item),
                  },
                ]"
              />
            </CommandItem>
          </CommandGroup>
        </CommandList>
      </Command>
    </PopoverContent>
  </Popover>
  <p class="text-sm text-red-500 font-semibold" v-if="typeof error === 'string'">
    {{ error }}
  </p>
  <p class="text-sm text-red-500 font-semibold" v-if="typeof error === 'boolean' && error === true">
    This field is required.
  </p>
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
  emits: ['update:modelValue', 'select', 'search'],
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
    error: { type: [String, Boolean] },
    multiple: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      isOpen: false,
      searchQuery: '',
      selectedItems: this.multiple ? (Array.isArray(this.modelValue) ? this.modelValue : []) : this.modelValue || null, // Initialize based on modelValue
    };
  },
  watch: {
    modelValue(newValue) {
      if (this.multiple) {
        this.selectedItems = Array.isArray(newValue) ? newValue : [];
      } else {
        this.selectedItems = newValue;
      }
    },
  },
  computed: {
    isObjectItems() {
      return this.items.length > 0 && typeof this.items[0] === 'object';
    },
    selectedItem() {
      if (this.multiple) {
        return this.items.filter(item =>
          this.selectedItems.includes(this.isObjectItems ? item[this.valueProperty] : item)
        );
      } else {
        if (this.isObjectItems) {
          return this.items.find(item => item[this.valueProperty] === this.modelValue);
        }
        return this.modelValue;
      }
    },
    filteredItems() {
      const searchQuery = this.searchQuery.toLowerCase();
      if (this.isObjectItems) {
        return this.items.filter(item =>
          item[this.labelProperty].toLowerCase().includes(searchQuery) ||
          this.selectedItems.includes(item[this.valueProperty])
        );
      }
      return this.items.filter(item =>
        item.toLowerCase().includes(searchQuery) ||
        this.selectedItems.includes(item)
      );
    },
    allSelected() {
      return this.filteredItems.length > 0 && this.filteredItems.every(item =>
        this.selectedItems.includes(this.isObjectItems ? item[this.valueProperty] : item)
      );
    },
  },
  methods: {
    togglePopover() {
      this.isOpen = !this.isOpen; // Toggle the state
    },
    selectItem(item) {
      const value = this.isObjectItems ? item[this.valueProperty] : item;
      if (this.multiple) {
        const index = this.selectedItems.indexOf(value);
        if (index === -1) {
          this.selectedItems.push(value);
        } else {
          this.selectedItems.splice(index, 1);
        }
        this.$emit('update:modelValue', this.selectedItems);
      } else {
        this.$emit('update:modelValue', value);
        this.isOpen = false;
      }
      this.$emit('select', item); // Emit the select event with the selected item
    },
    selectAll() {
      if (this.allSelected) {
        this.selectedItems = [];
      } else {
        this.selectedItems = this.filteredItems.map(item =>
          this.isObjectItems ? item[this.valueProperty] : item
        );
      }
      this.$emit('update:modelValue', this.selectedItems);
    },
    handleInput(event) {
      this.$emit('search', event.target.value);
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
