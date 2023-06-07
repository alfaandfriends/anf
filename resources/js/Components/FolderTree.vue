<script setup>
</script>

<template>
    <div>
        <ul class="menu-items">
            <li v-for="(folder, index) in folders" :key="folder.id">
                <template v-if="!folder[0]">
                    <span class="flex items-center space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5 text-blue-600" viewBox="0 0 16 16">
                            <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                        </svg>
                        <span>{{ index }}</span>
                    </span>
                </template>
                <template v-else>
                    <span class="flex items-center space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-4 w-4" viewBox="0 0 16 16">
                            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                        </svg>
                        <span>{{ index }}</span>
                    </span>
                </template>
                <folder-tree v-if="!folder[0]" :folders="folder" />
            </li>
        </ul>
    </div>
  </template>
  
  <script>
  export default {
    name: "FolderTree",
    props: {
        folders: {
            type: Array,
            required: true,
        },
    },
  };
  </script>
  
  <style>
    .menu-items li {
        position: relative;
        padding-left: 20px;
    }
  
    .menu-items li:before {
        content: "";
        position: absolute;
        top: 0;
        left: 10px;
        border-left: 1px solid #ddd;
        height: 100%;
    }
</style>
  