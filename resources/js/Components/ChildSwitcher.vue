<template>
    <!-- Mobile -->
    <div class="flex justify-center md:hidden">
        <button class="relative">
            <!-- Profile Image -->
            <img class="w-16 h-16 mr-3 rounded-full shadow-md" src="https://images.unsplash.com/photo-1603545723222-704768ce6193?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=472&q=80" />
            <!-- New Notification Alert -->
            <div class="absolute top-0 w-4 h-4 bg-green-300 rounded-full right-3 animate-ping" />
            <div class="absolute top-0 w-4 h-4 bg-green-500 rounded-full right-3" />
        </button>

        <!-- Add a Child Button -->
        <button class="w-16 h-16 text-gray-700 border-2 border-gray-300 border-dashed rounded-full">
            <PlusIcon class="mx-auto text-gray-400 w-7 h-7" />
        </button>
    </div>

    <!-- Desktop and Tablet -->
    <div class="hidden md:inline">
        <!-- Child List -->
        <div class="bg-white border-2 border-gray-200 rounded-xl">
            <button type="button" class="flex justify-between items-center w-full py-4 px-10 border-b hover:bg-indigo-50 space-x-2" v-if="$page.props.user_has_children.length" v-for="info in $page.props.user_has_children" @click="switchChild(info.child_id, info.student_id)">
                <!-- Profile Image -->
                <!-- <img class="w-12 h-12 mr-3 rounded-full" src="https://images.unsplash.com/photo-1603545723222-704768ce6193?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=472&q=80" /> -->
                <!-- Name -->
                <div class="text-lg font-bold text-gray-700 text-left">{{ info.name }}</div>
                <div class="flex items-center " v-if="info.child_id == $page.props.current_active_child.child_id">
                    <div class="w-4 h-4 bg-green-500 rounded-full">
                        <div class="w-4 h-4 bg-green-300 rounded-full animate-ping"></div>
                    </div>
                </div>
            </button>
            <div class="flex justify-between items-center w-full py-4 px-10 border-b" v-else>
                <span class="text-gray-400">No children added</span>
            </div>
        </div>

        <!-- Add a Child Button -->
        <div class="mt-3 bg-indigo-700 border-b-8 border-indigo-800 rounded-xl hover:bg-indigo-600">
            <button type="button" class="flex items-center justify-center w-full p-3 font-semibold text-white">Add a child</button>
        </div>
    </div>
</template>

<script>
import { PlusIcon } from '@heroicons/vue/solid'

export default {
    name: 'ChildList',
    components: {
        PlusIcon,
    },
    data(){
        return{
            switching: false
        }
    },
    methods: {
        switchChild(child_id, student_id){
            if(this.switching){
                return
            }
            this.switching = true
            this.$inertia.post(route('parent.switch_child'), {child_id: child_id, student_id: student_id},{
                onFinish: visit => {
                    this.switching = false
                },
            })
        }
    }
}
</script>
