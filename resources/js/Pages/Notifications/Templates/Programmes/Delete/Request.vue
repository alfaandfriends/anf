<script setup>
    import NotificationLayout from '@/Pages/Notifications/Layout.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <Head title="Notifications" />
    <NotificationLayout>
        <div class="flex-col w-full pt-4 px-4">
            <div class="pb-3 px-2 space-y-2">
                <div class="bg-white rounded-lg shadow-xl p-4" v-if="show">
                    <div class="flex">
                        <div>
                          <svg class="w-6 h-6 fill-current text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                        </div>
                  
                        <div class="ml-3">
                          <h2 class="font-semibold text-gray-800">Request to remove <span class="text-bold text-indigo-600 uppercase"> {{ form.programme_name }}</span> programme.</h2>
                          <p class="mt-2 text-sm text-gray-600 leading-relaxed">Please be informed that this action is irreversible.</p>
                        </div>
                      </div>
                  
                      <div class="flex items-center mt-3">
                        <button class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md" @click="reject">
                          Reject
                        </button>
                  
                        <button class="flex-1 px-4 py-2 ml-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md" @click="approve">
                          Approve
                        </button>
                      </div>
                </div>
            </div>
        </div>
    </NotificationLayout>
</template>
<script>
    export default{
        props:{
            request_data: Object,
            created_by: String,
            notification_data: Object
        },
        data(){
            return{
                show: false,
                centre_info: [],
                form: {
                    notification_id: this.notification_data.id,
                    programme_id: this.request_data ? this.request_data.programme_id : '',
                    programme_name: '',
                    created_by: this.created_by ? this.created_by : '',
                },
            }
        },
        mounted(){
            axios.get(route('get_programme_name', this.form.programme_id))
            .then((res) => {
                this.form.programme_name = res.data
            })
            .finally(()=>{
                this.show = true
            });
        },
        methods: {
            approve() {
                this.$inertia.post(route('approve_programme_delete'), this.form, { preserveState: true})
            },
            reject() {
                this.$inertia.post(route('reject_programme_delete'), this.form, { preserveState: true})
            },
        }
    }
</script>