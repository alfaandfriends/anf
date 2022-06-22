<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Diagnostic Test
            </h2>
        </template>
        <div class="py-6 px-6">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full py-12 px-36 shadow-md bg-white rounded text-center" v-if="result_score != ''">
                    <span class="text-2xl font-bold capitalize leading-loose">{{ result.message }}</span>
                    <div class="pt-6">
                        <Link :href="route('diagnostic_test')" class="px-6 py-4 bg-indigo-500 hover:bg-indigo-600 rounded text-white shadow-md">Restart Diagnostic Test</Link>
                    </div>
                </div>
                <div class="inline-block min-w-full p-12 shadow-md bg-white rounded text-center" v-else>
                    <div class="px-6 pb-8">
                        <span class="text-2xl font-bold uppercase">Question {{ count }}</span>
                    </div>
                    <div class="flex justify-center">
                        <img :src="'/storage/' + diagnostic_test_list[index].image_location" class="select-none w-1/2 h-1/3 bg-green-200 rounded-lg" alt="">
                    </div>
                    <div class="flex justify-center pt-12 space-x-16">
                        <button class="uppercase px-12 py-3 bg-blue-500 hover:bg-blue-600 rounded text-white text-lg font-extrabold shadow-md" @click="nextTrue(diagnostic_test_list[index].id)">1</button>
                        <button class="uppercase px-12 py-3 bg-red-500 hover:bg-red-600 rounded text-white text-lg font-extrabold shadow-md" @click="nextFalse(diagnostic_test_list[index].id)">0</button>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Head, Link
    },
    props: {
        diagnostic_test_list: Object,
        result: Object,
        result_score: String
    },
    data() {
        return {
            count: 1,
            index: 0,
            score: 0,
            final_score: '',
        }
    },
    watch: {
        final_score: {
            handler(){
                this.$inertia.get(route('diagnostic_test'), {'final_score': this.final_score})
            }
        }
    },
    methods: {
        nextTrue(){
            if(this.diagnostic_test_list[this.index].redirect_yes_id != null){
                var redirect_index      =  0
                const redirect_id       =  this.diagnostic_test_list[this.index].redirect_yes_id 

                this.diagnostic_test_list.filter(function(elem, index){
                    if(elem.id == redirect_id){
                        redirect_index = index
                    }
                });

                this.index = redirect_index
                this.score += 1
                this.count += 1
            }
            else if(this.diagnostic_test_list[this.index + 1]){
                this.index++
                this.score += 1
                this.count += 1
            }
            else if(this.diagnostic_test_list[this.index]){
                (this.count + 1)
                this.final_score = this.final_score == null ? 0 : (this.score + 1)
            }
        },
        nextFalse(){
            if(this.diagnostic_test_list[this.index].redirect_no_id != null){
                var redirect_index      =  0
                const redirect_id       =  this.diagnostic_test_list[this.index].redirect_no_id 

                this.diagnostic_test_list.filter(function(elem, index){
                    if(elem.id == redirect_id){
                        redirect_index = index
                    }
                });

                this.index = redirect_index
                this.count += 1
            }
            else if(this.diagnostic_test_list[this.index + 1]){
                this.index++
                this.count += 1
            }
            else if(this.diagnostic_test_list[this.index]){
                (this.count + 1)
                this.final_score = this.final_score == null ? 0 : (this.score + 0)
            }
        }
    }
})
</script>
                                