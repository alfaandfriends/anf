<script setup>
</script>
<template>
    <Card>
        <template #title>
            <div class="flex justify-between items-center">
                Answers
                <Button @click="addAnswer()">
                    <PlusCircle class="h-4 w-4" />
                    <span class="ml-1 hidden sm:block">Add</span>
                </Button>
            </div>  
        </template>
        <template #content>
            <div class="grid grid-cols-1 gap-4 divide-y">
                <div class="flex items-start space-x-6 pt-6" v-for="(answer, index) in answers">
                    <div class="flex space-x-2 items-center mt-3">
                        <Label :for="index" class="flex items-center space-x-1 cursor-pointer">
                            <Checkbox class="mr-1" :id="index" :value="index" :checked="verifyChecked(index)" v-model="correct_answer"/>
                            Correct
                        </Label>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <Textarea cols="1000" v-model="answers[index].answer" @input="sendDataToParent"></Textarea>
                        <div class="flex">
                            <input type="file" :ref="'file_'+index" class="hidden" @change="(event) => handleFile(event, index)">
                            <Button variant="secondary" @click="openFileModal('file_'+index)" v-if="!answer.image_file && !answer.image_name">Upload Image</Button>
                        </div>
                        <div class="flex" v-if="answer.image_file || answer.image_name">
                            <Badge class="space-x-1">
                                <span>{{ answer.image_name }}</span>
                                <MinusCircle class="h-4 w-4 text-red-500 cursor-pointer" @click="removeImage(index)"></MinusCircle>
                            </Badge>
                        </div>
                    </div>
                    <Button variant="destructive" @click="deleteAnswer(index)">Delete</Button>
                </div>
            </div>
        </template>
    </Card>
</template>

<script>
import Card from '@/Components/Card.vue'
import { PlusCircle, MinusCircle } from 'lucide-vue-next';
import { Badge } from '@/Components/ui/badge'

export default {
    components: {
        Card, PlusCircle, Badge, MinusCircle
    },
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
            correct_answer:  Array.isArray(this.prop_answers.correct_answer) ? this.prop_answers.correct_answer : [],
        }
    },
    watch:{
        'correct_answer': {
            handler(){
                this.sendDataToParent()
            },
             immediate: true
        },
    },
    methods: {
        init(){
            if(this.action === 'edit' && this.prop_answers.answers){
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
            this.correct_answer = [];
            this.sendDataToParent()
        },
        sendDataToParent(){
            this.$emit('receivedData', {
                'question_type': 2,
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
        },
        removeImage(index){
            this.correct_answer = [];
            this.$refs['file_' + index][0].value = null
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
            if(prop_answers.length > 0){
                Object.keys(prop_answers).forEach((index) => {
                    this.answers.push(
                        prop_answers[index]
                    )
                });
            }
        },
        verifyChecked(index){
            return this.correct_answer.includes(index)
        }
    }
}
</script>