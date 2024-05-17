<script setup>
    import NotificationLayout from '@/Pages/Admin/Notifications/Layout.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <Head title="Notifications" />
    <NotificationLayout>
        <div class="flex-col w-full pt-4 px-4 ">
            <div class="bg-white rounded-lg shadow-xl px-4 py-20">
                <div class="flex flex-col items-center space-y-2">
                    <div class="flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-red-600 w-10 h-10" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                          <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                        </svg>
                        <p class="text-lg font-bold">
                            Sorry, your request to delete <span class="font-bold text-indigo-600 uppercase">ANFC {{ centre_name }} </span> has been <span class="font-bold text-red-500">rejected</span>.</p>
                    </div>
                    <small class="text-[11px]"> Please contact person in charge for more information.</small>
                </div>
            </div>
        </div>
    </NotificationLayout>
</template>
<script>
    export default{
        props:{
            request_data: Object,
        },
        data(){
            return {
                centre_name: this.request_data.centre_name
            }
        },
    }
</script>