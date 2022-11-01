<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-6 px-6">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full py-12 px-36 shadow-md bg-white rounded text-center" v-if="result_score != ''">
                    <span class="text-2xl font-bold capitalize leading-loose">{{ result.message }}</span>
                    <div class="py-4">
                        <Bar
                            :chart-options="chartOptions"
                            :chart-data="chartData"
                            :width="100"
                            :height="500"
                        />
                    </div>
                    <div class="pt-6">
                        <BreezeButton class="px-6 py-2 bg-indigo-500 hover:bg-indigo-600 rounded text-white shadow-md" @click="restartDT">Re-run Diagnostic Test</BreezeButton>
                    </div>
                </div>
                <div class="inline-block min-w-full p-12 shadow-md bg-white rounded text-center" v-else>
                    <div class="px-6 pb-8">
                        <span class="text-3xl font-bold uppercase">Question {{ count }}</span>
                    </div>
                    <div class="px-6 pb-8" v-if="diagnostic_test_list[index].remarks">
                        <span class="font-bold uppercase italic text-red-500">* {{ diagnostic_test_list[index].remarks }} *</span>
                    </div>
                    <div class="flex flex-col place-items-center">
                        <img :src="'/storage/' + diagnostic_test_list[index].image_location" class="select-none w-1/2 h-1/3 bg-green-200 rounded-lg" alt="">
                        <div class="flex flex-row justify-between pt-4 w-1/2 space-x-2">
                            <button class="grow uppercase px-32 py-6 bg-blue-500 hover:bg-blue-600 rounded text-white text-lg font-extrabold shadow-md" @click="nextTrue(diagnostic_test_list[index].id)">1</button>
                            <button class="grow uppercase px-32 py-6 bg-red-500 hover:bg-red-600 rounded text-white text-lg font-extrabold shadow-md" @click="nextFalse(diagnostic_test_list[index].id)">0</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

var final_data          =   [];

export default defineComponent({
    components: {
        Head, Link, Bar
    },
    props: {
        diagnostic_test_list: Object,
        diagnostic_test_categories_label: Object,
        diagnostic_test_categories: Object,
        result: Object,
        result_score: String,
    },
    data() {
        return {
            count: 1,
            index: 0,
            score: 0,
            final_score: '',
            chartData: {
                labels: this.diagnostic_test_categories_label ? this.diagnostic_test_categories_label : [],
                datasets: [ { 
                    label: 'Score',
                    backgroundColor: '#f87979', 
                    data: this.final_data ? this.final_data : [],
                    barThickness: 100,
                    yAxisID: 'y',
                } ]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y:{
                        min: 0,
                        max: 10,
                        stepSize: 1,
                        ticks: {
                            beginAtZero: true
                        },
                    }
                }
            }
        }
    },
    watch: {
        final_score: {
            handler(){
                this.$inertia.get(route('diagnostic_test.run'), {'final_score': this.final_score, 'dt_id': this.$page.props.dt_id})
            }
        }
    },
    methods: {
        nextTrue(){
            var current_category_id =   this.diagnostic_test_list[this.index].category_id

            if(this.diagnostic_test_categories[current_category_id]){
                var category_text    =   this.diagnostic_test_categories[current_category_id]

                this.diagnostic_test_categories_label.filter(function(elem, index){
                    if(elem == category_text){
                        final_data[index] += 1
                    }
                    else if(!final_data[index]){
                        final_data[index] = 0
                    }
                })
            }

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
        },
        restartDT(){
            final_data = []
            this.$inertia.get(route('diagnostic_test'))
        },
        chartInit(){
            this.diagnostic_test_categories_label.filter(function(elem, index){
                final_data[index] = 0
            })
        }
    },
    mounted(){
        if(this.result_score == ''){
            this.chartInit()
        }
    }
})
</script>
                                