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
            <div class="flex items-start space-x-6 pt-6" v-for="(answer, answer_index) in answers">
                <label class="block text-sm font-medium text-gray-700">
                    Criterion
                    <div class="flex flex-col space-y-2">
                        <textarea cols="1000" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="answers[answer_index].criterion.value" @input="sendDataToParent">{{ answer }}</textarea>
                        <div class="flex" v-if="!answers[answer_index].criterion.image_file && !answers[answer_index].criterion.image_name">
                            <input type="file" :ref="'criterion_file_'+answer_index" class="hidden" @change="(event) => handleCriterionFile(event, answer_index)">
                            <BreezeButton buttonType="info" @click="openCriterionFileModal('criterion_file_'+answer_index)" class="py-1.5 px-2" v-if="!answers[answer_index].criterion.image_file && !answers[answer_index].criterion.image_name">Upload Image</BreezeButton>
                        </div>
                        <div class="flex" v-if="answers[answer_index].criterion.image_file || answers[answer_index].criterion.image_name">
                            <div class="flex items-center px-3 py-1 rounded-md border border-gray-200 bg-indigo-100 drop-shadow-md">
                                <div class="flex flex-1 items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 flex-1 text-gray-700 text-md">{{ answers[answer_index].criterion.image_name }}</span>
                                </div>
                                <div class="flex ml-4 flex-shrink-0 items-center">
                                    <button class="text-sm font-medium text-red-500 hover:text-red-600" @click="removeCriterionImage(answer_index)">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Sort Element
                    <div class="flex flex-col space-y-2">
                        <textarea cols="1000" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="answers[answer_index].element.value" @input="sendDataToParent">{{ answer }}</textarea>
                        <div class="flex flex-wrap gap-2" v-if="answers[answer_index].element.images.length > 0 ">
                            <div class="flex items-center px-3 py-1 rounded-md border border-gray-200 bg-indigo-100 drop-shadow-md" v-for="image, image_index in answers[answer_index].element.images">
                                <div class="flex flex-1 items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 flex-1 text-gray-700 text-md">{{ image.name }}</span>
                                </div>
                                <div class="flex ml-4 flex-shrink-0 items-center">
                                    <button class="text-sm font-medium text-red-500 hover:text-red-600" @click="removeElementImage(answer_index, image_index)">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <input type="file" :ref="'element_file_'+answer_index" class="hidden" @change="(event) => handleElementFile(event, answer_index)">
                            <BreezeButton buttonType="info" @click="openElementFileModal('element_file_'+answer_index)" class="py-1.5 px-2">Upload Image</BreezeButton>
                        </div>
                    </div>
                </label>
                <div class="mt-8">
                    <BreezeButton buttonType="danger" @click="deleteAnswer(answer_index)">Delete</BreezeButton>
                </div>
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
            default_answers: [{
                'criterion' : {
                    'value': '',
                    'image_name' : '',
                    'image_file' : '',
                },
                'element' : {
                    'value': '',
                    'images': []
                }
            }]
        }
    },
    methods: {
        init(){
            if(this.prop_answers.answers){
                if(Array.isArray(this.prop_answers.answers)){
                    this.answers    =   this.prop_answers.answers
                }
                else if(typeof this.prop_answers.answers){
                    const temp_arr  =   []
                    for (let key in this.prop_answers.answers) {
                        temp_arr.push(this.prop_answers.answers[key])
                    }
                    this.answers    =   temp_arr
                }
                else{
                    this.answers    =   this.default_answers
                }
            }
            else{
                this.answers = this.default_answers
            }
        },
        addAnswer(){
            this.answers.push({
                'criterion' : {
                    'value': '',
                    'image_name' : '',
                    'image_file' : '',
                },
                'element' : {
                    'value': '',
                    'images': []
                }
            })
        },
        deleteAnswer(answer_index){
            this.pushCriterionImageToDelete(answer_index)
            this.pushElementImagesToDelete(answer_index)
            this.answers.splice(answer_index, 1)
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
                
                this.answers[index].criterion.image_file = new File([event.target.files[0]], new_file_name, { type: event.target.files[0].type });
                this.answers[index].criterion.image_name = this.answers[index].criterion.image_file.name
                this.answers[index].criterion.value = '<img class="h-24" src="/storage/diagnostic_test_photo/'+this.answers[index].criterion.image_file.name+'">'
            } 
            else{
                alert('Only images are allowed!')
            }
            event.target.value = null
            this.sendDataToParent()
        },
        handleElementFile(event, index) {
            if (event.target.files[0] && event.target.files[0].type.match(/^image\/(jpeg|png)$/)) {
                const file_ext      =   event.target.files[0].name.split(".").pop()
                const unique_id     =   Date.now().toString() + Math.floor(Math.random() * 100000).toString()
                const new_file_name =   unique_id + '.' + file_ext

                this.answers[index].element.images.push({
                    'file' : new File([event.target.files[0]], new_file_name, { type: event.target.files[0].type }),
                    'name' : new_file_name,
                })

                const file_names = this.answers[index].element.images.map(obj => '<img class="h-24" src="/storage/diagnostic_test_photo/'+obj.name+'">');
                const names     =   file_names.join(', ')

                this.answers[index].element.value   =   names
            } 
            else{
                alert('Only images are allowed!')
            }
            event.target.value = null
            this.sendDataToParent()
        },
        removeCriterionImage(index){
            this.correct_answer = [];
            this.pushCriterionImageToDelete(index)
            this.clearCriterionAnswerData(index)
            this.sendDataToParent(index)
        },
        removeElementImage(answer_index, image_index){
            this.correct_answer = [];
            this.pushElementImageToDelete(answer_index, image_index)
            this.answers[answer_index].element.images.splice(image_index, 1)
            this.clearElementAnswerData(answer_index)
            this.sendDataToParent(answer_index)
        },
        clearCriterionAnswerData(index){
            this.answers[index].criterion.image_file = ''
            this.answers[index].criterion.image_name = ''
            this.answers[index].criterion.value = ''
        },
        clearElementAnswerData(index){
            if(this.answers[index].element.images.length > 0){
                const file_names = this.answers[index].element.images.map(obj => '<img class="h-24 w-24" src="/storage/diagnostic_test_photo/'+obj.name+'">');
                const names     =   file_names.join(', ')
                this.answers[index].element.value   =   names
            }
            else{
                this.answers[index].element.value = ''
            }

        },
        pushCriterionImageToDelete(index){
            if(this.answers[index].criterion && this.answers[index].criterion.image_name){
                if(this.answers[index].criterion.image_name != '' && !this.answers[index].criterion.image_file){
                    this.images_to_delete.push(this.answers[index].criterion.image_name)
                }
            }
        },
        pushElementImageToDelete(answer_index, image_index){
            if(this.answers[answer_index].element.images && this.answers[answer_index].element.images.length > 0){
                if(this.answers[answer_index].element.images[image_index] && this.answers[answer_index].element.images[image_index].name != '' && !this.answers[answer_index].element.images[image_index].file){
                    this.images_to_delete.push(this.answers[answer_index].element.images[image_index].name)
                }
            }
        },
        pushElementImagesToDelete(answer_index){
            if(this.answers[answer_index].element.images && this.answers[answer_index].element.images.length > 0){
                this.answers[answer_index].element.images.map((image)=>{
                    this.images_to_delete.push(image.name)
                })
            }
        },
    }
}
</script>