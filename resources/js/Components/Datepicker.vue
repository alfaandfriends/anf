<template>
    <Popover v-model:open="isOpen">
      <PopoverTrigger as-child @click="togglePopover">
        <Button variant="outline" class="px-2 w-full justify-between">
          <div class="flex space-x-2">
            <CalendarIcon class="ml-2 h-5 w-5 shrink-0 opacity-50" />
            <span class="truncate">{{ formattedLabel }}</span>
          </div>
          <Cross1Icon class="ml-2 h-3.5 w-3.5 shrink-0 opacity-50 hover:opacity-80" @click="clearDate" v-if="date" />
        </Button>
      </PopoverTrigger>
      <PopoverContent class="p-0 min-w-[var(--radix-popover-trigger-width)]">
        <Calendar v-model="date" mode="date" @click="formatDate" />
      </PopoverContent>
    </Popover>
  </template>
  
  <script>
  import moment from 'moment'
  import { Calendar } from '@/Components/ui/v-calendar'
  import { CalendarIcon, Cross1Icon } from '@radix-icons/vue'
  import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover'
  
  export default {
    emits: ['change'],
    props: {
      format: {
        type: String,
        default: 'YYYY-MM-DD'
      },
      labelFormat: {
        type: String,
        default: 'DD/MM/YYYY'
      }
    },
    components: {
      Calendar, CalendarIcon, Cross1Icon, Popover, PopoverContent, PopoverTrigger
    },
    data() {
      return {
        isOpen: false,
        date: ''
      }
    },
    computed: {
      formattedLabel() {
        return this.date ? moment(this.date).format(this.labelFormat) : 'Date'
      }
    },
    methods: {
      formatDate() {
        this.date = moment(this.date).format(this.format)
        this.isOpen = false
        this.$emit('change', this.date) // Emit change event with formatted date
      },
      clearDate() {
        this.date = ''
        this.$emit('change', '') // Emit empty value when clearing the date
      },
      togglePopover() {
        this.isOpen = !this.isOpen
      }
    }
  }
  </script>
  