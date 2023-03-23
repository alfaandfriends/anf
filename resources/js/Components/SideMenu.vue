<template>
    <li class="py-2" v-for="item, index in items">
        <a v-if="item.name" :href="item.link" class="flex items-center">
            <span :class="item.name"></span>
            <span class="ml-3">{{ item.name }}</span>
        </a>
        <a v-else class="flex items-center cursor-pointer" @click="toggleSubmenu(index)">
            
            <SideMenu v-if="item.sub_menu" :items="item.children"/>
            <!-- <span :class="item.icon"></span>
            <span class="ml-3">{{ item.label }}</span>
            <span class="ml-auto" v-if="item.submenu"><i class="fa fa-chevron-down" :class="{ 'fa-rotate-180': item.expanded }"></i></span> -->
        </a>
        <!-- <ul v-if="item.submenu && item.expanded" class="pl-6 py-2 space-y-1">
            <li v-for="(subitem, subindex) in item.submenu" :key="subindex">
                <a :href="subitem.link" class="flex items-center">
                    <span :class="subitem.icon"></span>
                    <span class="ml-3">{{ subitem.label }}</span>
                </a>
            </li>
        </ul> -->
    </li>
</template>
  
  <script>
//   import SideMenu from '@/Components/SideMenu.vue'
  export default {
    name: 'SideMenu',
    components: {
        // SideMenu,
    },
    props: {
      items: {
        type: Array,
        required: true,
      },
    },
    methods: {
      handleClick(item) {
        console.log('Clicked:', item.title);
      },
        toggleSubmenu(index) {
      this.menuItems[index].expanded = !this.menuItems[index].expanded;
    }
    },
  };
  </script>