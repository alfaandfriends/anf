<script setup>
import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
        <div class="flex justify-between mb-2">
            <h1 class="text-indigo-800 font-bold">Answers</h1>
            <BreezeButton @click="addAnswer">
                Add Answer
            </BreezeButton>
        </div>
        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
        <div class="py-5 space-y-6 divide-y divide-gray-500">
            <div class="flex items-start space-x-6 pt-6" v-for="(answer, index) in answers">
                <div class="flex space-x-2 items-center mt-5">
                    <input :id="index" name="single-choice" type="radio" class="focus:ring-0 focus:border-white h-4 w-4 text-indigo-600 border-indigo-300 active:ring-0" :value="index" v-model="correct_answer"/>
                    <label :for="index" class="select-none block text-sm font-medium text-gray-700 cursor-pointer">
                        Correct
                    </label>
                </div>
                <div class="flex flex-col space-y-1">
                    <textarea cols="1000" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="answers[index].answer" @input="sendDataToParent(index)"></textarea>
                    <div class="flex">
                        <input type="file" :ref="'file_'+index" class="hidden" @change="(event) => handleFile(event, index)">
                        <BreezeButton buttonType="info" @click="openFileModal('file_'+index)" class="py-1.5 px-2" v-if="!answer.image_file && !answer.image_name">Upload Image</BreezeButton>
                    </div>
                    <div class="flex" v-if="answer.image_file || answer.image_name">
                        <div class="flex items-center px-3 py-1 rounded-md border border-gray-200 bg-indigo-100 drop-shadow-md">
                            <div class="flex flex-1 items-center">
                                <!-- Heroicon name: mini/paper-clip -->
                                <svg class="h-5 w-5 flex-shrink-0 text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                </svg>
                                <span class="ml-2 flex-1 text-gray-700 text-md">{{ answer.image_name }}</span>
                            </div>
                            <div class="flex ml-4 flex-shrink-0 items-center">
                                <button class="text-sm font-medium text-red-500 hover:text-red-600" @click="removeImage(index)">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <BreezeButton buttonType="danger" @click="deleteAnswer(index)" class="mt-4 py-1 px-2">Delete</BreezeButton>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive } from "@vue/reactivity";

export default {
    props:{
        action: String,
        prop_answers: Object
    },
    mounted(){
        console.log(this.prop_answers)
        this.init()
    },
    data(){
        return{
            images_to_delete: [],
            answers: [],
            correct_answer: this.prop_answers ? this.prop_answers.correct_answer : '',
        }
    },
    watch:{
        correct_answer(data){
            this.sendDataToParent()
        },
        immediate: true
    },
    methods: {
        init(){
            if(this.action === 'edit'){
                this.reconstructAnswers(this.prop_answers.answers)
            }
            else{
                this.answers.push({
                    'answer' : '',
                    'image_name' : '',
                    'image_file' : '',
                })
            }
        },
        addAnswer(){
            this.answers.push({
                'answer' : '',
                'image_name' : '',
                'image_file' : '',
            })
        },
        deleteAnswer(index){
            this.pushImageToDelete(index)
            this.answers.splice(index, 1);
            this.correct_answer = '';
            this.sendDataToParent(index)
        },
        sendDataToParent(index){
            this.$emit('receivedData', {
                'question_type': 1,
                'answers': this.answers,
                'correct_answer': this.correct_answer,
                'images_to_delete': this.images_to_delete
            });
        },
        openFileModal(file_number) {
            this.$refs[file_number][0].click();
        },
        handleFile(event, index) {
            if (event.target.files[0] && event.target.files[0].type.match(/^image\/(jpeg|png)$/)) {
                const file_ext              =   event.target.files[0].name.split(".").pop()
                const timestampInSeconds    =   Math.floor(Date.now() / 1000);
                const unique_id             =   timestampInSeconds.toString()
                const new_file_name         =   unique_id + '.' + file_ext

                this.answers[index].image_file = new File([event.target.files[0]], new_file_name, { type: event.target.files[0].type });
                this.answers[index].image_name = this.answers[index].image_file.name
                this.answers[index].answer = '<img src="/storage/diagnostic_test_photo/'+this.answers[index].image_file.name+'">'
            } 
            else{
                alert('Only images are allowed!')
            }
            this.sendDataToParent(index)
        },
        removeImage(index){
            this.correct_answer = '';
            this.pushImageToDelete(index)
            this.clearAnswerData(index)
            this.sendDataToParent(index)
        },
        clearAnswerData(index){
            this.answers[index].image_file = ''
            this.answers[index].image_name = ''
            this.answers[index].answer = ''
        },
        pushImageToDelete(index){
            if(this.answers[index] && this.answers[index].image_name){
                if(this.answers[index].image_name != '' && !this.answers[index].image_file){
                    this.images_to_delete.push(this.answers[index].image_name)
                }
            }
        },
        reconstructAnswers(prop_answers){
            if(prop_answers){
                Object.keys(prop_answers).forEach((index) => {
                    this.answers.push(
                        prop_answers[index]
                    )
                });
            }
            else{
                this.answers.push({
                    'answer' : '',
                    'image_name' : '',
                    'image_file' : '',
                })
            }
        }
    }
}
</script>