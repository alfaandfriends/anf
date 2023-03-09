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
            <div class="flex items-center space-x-6 pt-6" v-for="(answer, index) in answers.criterion">
                <label :for="index" class="block text-sm font-medium text-gray-700">{{index+1}}.</label>
                <label :for="index" class="block text-sm font-medium text-gray-700">
                    Criterion
                    <div class="flex flex-col space-y-1">
                        <textarea cols="1000" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="answers.criterion[index].value" @input="sendDataToParent">{{ answer }}</textarea>
                        <div class="flex">
                            <input type="file" :ref="'criterion_file_'+index" class="hidden" @change="(event) => handleCriterionFile(event, index)">
                            <BreezeButton buttonType="info" @click="openCriterionFileModal('criterion_file_'+index)" class="py-1.5" v-if="!answers.criterion[index].image_file && !answers.criterion[index].image_name">Upload Image</BreezeButton>
                        </div>
                        <div class="flex" v-if="answers.criterion[index].image_file || answers.criterion[index].image_name">
                            <div class="flex items-center px-3 py-1 rounded-md border border-gray-200 bg-indigo-100 drop-shadow-md">
                                <div class="flex flex-1 items-center">
                                    <!-- Heroicon name: mini/paper-clip -->
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 flex-1 text-gray-700 text-md">{{ answers.criterion[index].image_name }}</span>
                                </div>
                                <div class="flex ml-4 flex-shrink-0 items-center">
                                    <button class="text-sm font-medium text-red-500 hover:text-red-600" @click="removeCriterionImage(index)">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
                <label :for="index" class="block text-sm font-medium text-gray-700">
                    Sort Element
                    <div class="flex flex-col space-y-1">
                        <textarea cols="1000" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="answers.element[index].value" @input="sendDataToParent">{{ answer }}</textarea>
                        <div class="flex">
                            <input type="file" :ref="'element_file_'+index" class="hidden" @change="(event) => handleElementFile(event, index)">
                            <BreezeButton buttonType="info" @click="openElementFileModal('element_file_'+index)" class="py-1.5" v-if="!answers.element[index].image_file && !answers.element[index].image_name">Upload Image</BreezeButton>
                        </div>
                        <div class="flex" v-if="answers.element[index].image_file || answers.element[index].image_name">
                            <div class="flex items-center px-3 py-1 rounded-md border border-gray-200 bg-indigo-100 drop-shadow-md">
                                <div class="flex flex-1 items-center">
                                    <!-- Heroicon name: mini/paper-clip -->
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 flex-1 text-gray-700 text-md">{{ answers.element[index].image_name }}</span>
                                </div>
                                <div class="flex ml-4 flex-shrink-0 items-center">
                                    <button class="text-sm font-medium text-red-500 hover:text-red-600" @click="removeElementImage(index)">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
                <BreezeButton buttonType="danger" @click="deleteAnswer(index)">Delete</BreezeButton>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    props:{
        action: String,
        prop_answers: Object
    },
    mounted(){
        this.init()
    },
    data(){
        return{
            images_to_delete: [],
            answers: [],
        }
    },
    methods: {
        init(){
            if(this.action === 'edit'){
                this.answers = this.prop_answers ? this.prop_answers.answers : []
                // this.reconstructCriterionAnswers(this.prop_answers.answers.criterion)
                // this.reconstructElementAnswers(this.prop_answers.answers.element)
            }
            else{
                this.answers = {
                    'criterion' : [{
                        'value': '',
                        'image_name' : '',
                        'image_file' : '',
                    }],
                    'element' : [{
                        'value': '',
                        'image_name' : '',
                        'image_file' : '',
                    }]
                }
            }
        },
        addAnswer(){
            this.answers.criterion.push({
                'value': '',
                'image_name' : '',
                'image_file' : '',
            })
            this.answers.element.push({
                'value': '',
                'image_name' : '',
                'image_file' : '',
            })
        },
        deleteAnswer(index){
            this.pushCriterionImageToDelete(index)
            this.pushElementImageToDelete(index)
            this.answers.criterion.splice(index, 1)
            this.answers.element.splice(index, 1)
            this.sendDataToParent()
        },
        sendDataToParent(){
            this.$emit('receivedData', {
                'question_type': 3,
                'answers': this.answers,
                'images_to_delete': this.images_to_delete
            });
        },
        openCriterionFileModal(file_number) {
            this.$refs[file_number][0].click();
        },
        openElementFileModal(file_number) {
            this.$refs[file_number][0].click();
        },
        handleCriterionFile(event, index) {
            if (event.target.files[0] && event.target.files[0].type.match(/^image\/(jpeg|png)$/)) {
                const file_ext      =   event.target.files[0].name.split(".").pop()
                const unique_id     =   Date.now().toString() + Math.floor(Math.random() * 100000).toString()
                const new_file_name =   unique_id + '.' + file_ext

                this.answers.criterion[index].image_file = new File([event.target.files[0]], new_file_name, { type: event.target.files[0].type });
                this.answers.criterion[index].image_name = this.answers.criterion[index].image_file.name
                this.answers.criterion[index].value = '<img src="/storage/diagnostic_test_photo/'+this.answers.criterion[index].image_file.name+'">'
            } 
            else{
                alert('Only images are allowed!')
            }
        },
        handleElementFile(event, index) {
            if (event.target.files[0] && event.target.files[0].type.match(/^image\/(jpeg|png)$/)) {
                const file_ext      =   event.target.files[0].name.split(".").pop()
                const unique_id     =   Date.now().toString() + Math.floor(Math.random() * 100000).toString()
                const new_file_name =   unique_id + '.' + file_ext

                this.answers.element[index].image_file = new File([event.target.files[0]], new_file_name, { type: event.target.files[0].type });
                this.answers.element[index].image_name = this.answers.element[index].image_file.name
                this.answers.element[index].value = '<img src="/storage/diagnostic_test_photo/'+this.answers.element[index].image_file.name+'">'
            } 
            else{
                alert('Only images are allowed!')
            }
        },
        removeCriterionImage(index){
            this.correct_answer = [];
            this.pushCriterionImageToDelete(index)
            this.clearCriterionAnswerData(index)
            this.sendDataToParent(index)
        },
        removeElementImage(index){
            this.correct_answer = [];
            this.pushElementImageToDelete(index)
            this.clearElementAnswerData(index)
            this.sendDataToParent(index)
        },
        clearCriterionAnswerData(index){
            this.answers.criterion[index].image_file = ''
            this.answers.criterion[index].image_name = ''
            this.answers.criterion[index].value = ''
        },
        clearElementAnswerData(index){
            this.answers.element[index].image_file = ''
            this.answers.element[index].image_name = ''
            this.answers.element[index].value = ''
        },
        pushCriterionImageToDelete(index){
            if(this.answers.criterion[index] && this.answers.criterion[index].image_name){
                if(this.answers.criterion[index].image_name != '' && !this.answers.criterion[index].image_file){
                    this.images_to_delete.push(this.answers.criterion[index].image_name)
                }
            }
        },
        pushElementImageToDelete(index){
            if(this.answers.element[index] && this.answers.element[index].image_name){
                if(this.answers.element[index].image_name != '' && !this.answers.element[index].image_file){
                    this.images_to_delete.push(this.answers.element[index].image_name)
                }
            }
        },
        reconstructCriterionAnswers(criterion_answers){
            criterion_answers.forEach((index) => {
            console.log(index)
                // this.answers.criterion.push(
                //     criterion_answers[index]
                // )
            });
        },
        reconstructElementAnswers(element_answers){
            Object.keys(element_answers).forEach((index) => {
                this.answers.element.push(
                    element_answers[index]
                )
            });
        },
    }
}
</script>