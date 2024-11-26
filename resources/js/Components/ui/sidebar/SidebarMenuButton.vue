<script setup lang="ts">
import { computed, HTMLAttributes } from 'vue'
import { TooltipContent, TooltipTrigger } from 'radix-vue'
import { useSidebar } from './utils'
import { Tooltip } from '@/Components/ui/tooltip'
import SidebarMenuButtonChild from './SidebarMenuButtonChild.vue'

// SidebarMenuButtonProps with `as` restricted to string
interface SidebarMenuButtonProps {
  isActive?: boolean
  class?: HTMLAttributes['class']
  asChild?: boolean
  as?: string // Narrow `as` to `string` only to match `SidebarMenuButtonChild` requirements
  variant?: 'default' | 'outline'
  size?: 'default' | 'sm' | 'lg'
}

const props = withDefaults(defineProps<SidebarMenuButtonProps & {
  tooltip?: string
}>(), {
  as: 'button',
  variant: 'default',
  size: 'default',
})

const { isMobile, state } = useSidebar()

// Type the computed property to Partial<SidebarMenuButtonProps>
const delegatedProps = computed(() => {
  const { tooltip, ...delegated } = props
  return delegated as Partial<SidebarMenuButtonProps>
})
</script>

<template>
  <SidebarMenuButtonChild v-if="!tooltip" v-bind="{ ...delegatedProps, ...$attrs }">
    <slot />
  </SidebarMenuButtonChild>

  <Tooltip v-else>
    <TooltipTrigger as-child>
      <SidebarMenuButtonChild v-bind="{ ...delegatedProps, ...$attrs }">
        <slot />
      </SidebarMenuButtonChild>
    </TooltipTrigger>
    <TooltipContent
      side="right"
      align="center"
      :hidden="state !== 'collapsed' || isMobile"
    >
      <template v-if="typeof tooltip === 'string'">
        {{ tooltip }}
      </template>
      <component :is="tooltip" v-else />
    </TooltipContent>
  </Tooltip>
</template>
