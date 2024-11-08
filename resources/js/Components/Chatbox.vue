<script setup>
import { ref } from 'vue';
import { BotMessageSquareIcon, Send, X } from 'lucide-vue-next';
import { VMarkdownView } from 'vue3-markdown'
import 'vue3-markdown/dist/style.css'
</script>

<script>
import Groq from 'groq-sdk';

export default {
    data() {
        return {
            open: false,
            client: null,
            user_input: '',
            chatCompletion: '',
            response: '',
            post_prompt: `
                Please greet the user by name and remain focused on lesson-related inquiries only, 
                Only respond to questions related directly to the lesson plan topic or content,
                Do not answer any unrelated questions. Do not solve math problem. If an unrelated question is asked, remind the user, "I am here to assist with lesson plan questions only."
            `
            ,
            conversation: [{ 
                role:   'system', 
                content:`
                    You are an AI assistant dedicated solely to answering questions related to the current lesson plan. 
                    Your task is to help ${this.$page.props.auth.user.display_name} by providing clear, concise information that is relevant only to the lesson plan topic.
                `
            }]
        }
    },
    methods: {
        async submit() {
            if (!this.client) {
                this.client = new Groq({
                    apiKey: import.meta.env.VITE_GROQ_API_KEY,
                    dangerouslyAllowBrowser: true,
                });
            }

            this.conversation.push({
                role: 'user', 
                content: this.user_input
            },{
                role: 'system', 
                content: this.post_prompt
            });

            this.user_input = '';

            const assistantIndex = this.conversation.push({
                role: 'assistant', 
                content: ''
            }) - 1;

            this.chatCompletion = await this.client.chat.completions.create({
                messages: this.conversation,
                frequency_penalty: 1.0,
                model: 'llama-3.1-70b-versatile',
                temperature: 0.4,
                max_tokens: 1024,
                top_p: 1,
                stream: true,
            });

            for await (const chunk of this.chatCompletion) {
                const content = chunk.choices[0]?.delta?.content || '';
                this.conversation[assistantIndex].content += content;

                this.scrollToBottom();
            }
            
            this.response = '';
        },

        scrollToBottom() {
            const container = this.$refs.chatbox;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
    },
}
</script>

<template> 
    <div class="fixed bottom-5 right-5 z-50">
        <div v-if="open" class="flex flex-col bg-background border sm:rounded-lg shadow-md overflow-hidden transition-all duration-250 ease-out sm:absolute sm:w-[90vw] sm:h-[80vh] fixed inset-0 w-full h-full sm:inset-auto sm:bottom-[calc(100%+10px)] sm:right-0 sm:max-w-lg sm:max-h-[700px] pointer-events-auto opacity-100 visible scale-100 translate-y-0">
            
            <div class="flex items-center p-4 border-b flex-col text-center justify-center">
                <h1 class="text-base font-semibold">ALFA and Friends AI ✨</h1>
                <p class="text-xs">Ask any question for our AI to answer</p>
                <span class="md:hidden fixed top-6 right-4 cursor-pointer" @click="open = false"><X/></span>
                
                <!-- Buttons -->
                <!-- <div class="flex gap-2 items-center pt-2">
                    <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-secondary text-secondary-foreground shadow-sm hover:bg-secondary/80 h-9 px-4 py-2">
                        New Chat
                    </button>
                    <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-secondary text-secondary-foreground shadow-sm hover:bg-secondary/80 h-9 px-4 py-2">
                        See FAQ
                    </button>
                </div> -->
            </div>

            <div class="flex-grow overflow-y-auto text-sm">
                <div class="flex flex-col h-full p-4 gap-6 overflow-y-auto dark:bg-muted/40" ref="chatbox">
                    <div class="flex flex-col gap-2" style="opacity: 1; transform: none; transform-origin: 50% 50% 0px;" v-if="conversation.length > 1" v-for="chat in conversation">
                        <div class="flex items-start group self-start relative group" v-if="chat.role == 'assistant'">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-full">
                                <span class="flex h-full text-base w-full items-center justify-center rounded-full bg-muted"><BotMessageSquareIcon class="h-4 w-4"/></span>
                            </span>
                            <div class="px-4 text-secondary-foreground rounded-r-lg rounded-tl-lg break-words w-full">
                                <VMarkdownView
                                    mode="light"
                                    :content="chat.content"
                                ></VMarkdownView>
                            </div>
                        </div>
                        <div class="flex justify-end" v-if="chat.role == 'user'">
                            <div class="p-4 border border-slate-400 text-secondary-foreground rounded-l-lg rounded-tr-lg break-words max-w-full ml-10">
                                {{ chat.content }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form @submit.prevent="submit">
                <div class="flex items-center gap-2 border-t p-4">
                    <div class="flex-grow">
                        <Input class="flex-grow w-full" type="text" placeholder="Type a message..." v-model="user_input"></Input>
                    </div>
                    <Button @click.prevent="submit" :disabled="!user_input"><Send class="w-5 h-5"/></Button>
                </div>
            </form>
        </div>

        <Button class="flex items-center space-x-1" @click="open = !open">
            <BotMessageSquareIcon/>
            <span>AI Assistant</span>
        </Button>
    </div>
</template>