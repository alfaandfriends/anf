<script>
    import TimeAgo from 'javascript-time-ago';
    import en from 'javascript-time-ago/locale/en';
    import moment from 'moment';
    
    TimeAgo.addDefaultLocale(en)
    const timeAgo = new TimeAgo('en-US')

    export default {
        created(){
            var original_datetime = new Date(this.datetime)
            this.convertDateTime(original_datetime)
            window.setInterval(() => {
                this.convertDateTime(original_datetime)
            }, 60000)
        },
        props:{
            class: String,
            prefix: String,
            datetime: String,
            suffix: String,
        },
        data(){
            return{
                formatted_datetime: ''
            }
        },
        methods: {
            convertDateTime(original_datetime){
                this.formatted_datetime  =  timeAgo.format(original_datetime)
            }
        }
    }
</script>

<template>
    <span class="text-[10px]" :class="class">{{ prefix }} {{ formatted_datetime }} {{ suffix }}</span>
</template>
