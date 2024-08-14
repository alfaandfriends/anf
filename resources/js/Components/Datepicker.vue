<template>
    <Popover v-model:open="isOpen">
      <PopoverTrigger as-child @click="togglePopover">
        <Button variant="outline" class="px-2 w-full justify-between">
          <div class="flex space-x-2">
            <CalendarIcon class="ml-2 h-5 w-5 shrink-0 opacity-50" />
            <span class="truncate font-normal">{{ formattedLabel }}</span>
          </div>
          <!-- <Cross1Icon class="ml-2 h-3.5 w-3.5 shrink-0 opacity-50 hover:opacity-80" @click="clearDate" v-if="date" /> -->
        </Button>
      </PopoverTrigger>
      <PopoverContent class="p-0">
        <Calendar class="" v-model="date" :mode="mode" @dayclick="formatDate"/>
      </PopoverContent>
    </Popover>
  </template>
  
  <script>
  import moment from 'moment-timezone';
  import { Calendar } from '@/Components/ui/v-calendar'
  import { CalendarIcon, Cross1Icon } from '@radix-icons/vue'
  import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover'
  
  export default {
    emits: ['change', 'update:modelValue'],
    props: {
      dateLabelFormat: {
        type: String,
        default: 'DD/MM/YYYY'
      },
      timeFormat: {
        type: String,
        default: ''
      },
      timeLabelFormat: {
        type: String,
        default: 'h:mm A'
      },
      modelValue: {
        type: [String, Date],
        default: ''
      },
      mode: {
        type: String,
        default: 'mode'
      }
    },
    components: {
      Calendar, CalendarIcon, Cross1Icon, Popover, PopoverContent, PopoverTrigger
    },
    data() {
      return {
        isOpen: false,
        date: new Date(),
      }
    },
    watch: {
      date: {
        handler(){
          this.formatDate()
        },
        immediate: true
      }
    },
    computed: {
      formattedLabel() {
        const date = this.date
        if(!date){
          return this.mode == 'date' ? 'Select Date' : 'Select Time'
        }
        return this.mode == 'date' ? moment(date).format(this.dateLabelFormat) : moment(date).format(this.timeLabelFormat)
      }
    },
    methods: {
      formatDate() {
        this.$emit('update:modelValue', this.date); // Emit the formatted date with update:modelValue
        this.isOpen = false
      },
      clearDate() {
        this.date = ''
        this.$emit('update:modelValue', this.date); // Emit the formatted date with update:modelValue
      },
      togglePopover() {
        this.isOpen = !this.isOpen
      }
    },
    created(){
      if(this.modelValue){
        this.date = new Date(this.modelValue)
      }
      else{
          this.date = new Date()
      }

      this.$emit('update:modelValue', this.date); // Emit the formatted date with update:modelValue

    }
  }
  </script>
  