<script setup>
import { Badge } from '@/Components/ui/badge'

import { Button } from '@/Components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu'
import { Input } from '@/Components/ui/input'
import { Sheet, SheetContent, SheetTrigger } from '@/Components/ui/sheet'
import { Inertia } from '@inertiajs/inertia'
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3'
import { Bot, BotIcon, CircleUser, Home, LightbulbIcon, LineChart, Menu, Package, Package2, Paperclip, PlusCircle, Search, SendHorizonal, ShoppingCart, Trash, Trash2, Users } from 'lucide-vue-next'
import { ref } from 'vue'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';   
import { onMounted } from 'vue'
import { VMarkdownView } from 'vue3-markdown'
import 'vue3-markdown/dist/style.css'


const sending_reply = ref(false)
const prompt_input = ref(null)
const chatbox = ref(null)

const props = usePage().props.value
const messages = props.chat_data ? JSON.parse(props.chat_data.messages) : ''

window.Echo.private("ai_response_stream."+props.auth.user.ID)
.listen("AiResponseStream", (event) => {
  if(event[0] == 'done'){
    location.href = location.href;
  }
  // if(event[0] == 'running_response' && event[0] == 'finished_response'){
  //   messages.data.push({
  //     role: 'user',
  //     content: [{
  //       text: {
  //         value: ''
  //       }
  //     }]
  //   })
  // }
  // const lastIndex = messages.data.length - 1; // Index of the last element
  // messages.data[lastIndex].content[0].text.value += event[0];
});


const form = useForm({
    chat_id: props.chat_data?.id || '',
    thread_id: props.chat_data?.thread_id || '',
    run_id: props.chat_data?.run_id || '',
    messages: ''
})

const updateChat = ((event) => {
    form.messages = event.target.innerText;
})
const submit = async () => {
    if(sending_reply.value || !form.messages){
        return
    }

    sending_reply.value = true

    const response = await axios.post(route('ai.store'), {form});
    form.messages = ''
    prompt_input.value.innerText = ''
    sending_reply.value = false
}

const onKeydown = async (event) => {
    try {
        if (event.ctrlKey && event.key === 'Enter') {
            submit()
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

const confirmation = useForm({
    id: '',
    route_name: '',
    is_open: false
})
const deleteThread = async (thread_id) => {
    confirmation.route_name    = 'ai.destroy'
    confirmation.id            = thread_id
    confirmation.is_open       = true
}

const generateQuiz = async () => {
    form.messages = {role: 'user', content: 'Generate a random quiz.'}
    try {
        
        const response = await axios.post(route('ai.generate_quiz'), {form});
        Inertia.get(route('chat.edit', response.data))
        
    } catch (error) {
        console.log(error)
    }
}

onMounted(()=>{
    if (chatbox.value) {
        chatbox.value.scrollTop = chatbox.value.scrollHeight;
    }
})
</script>

<template>
  <div class="grid min-h-screen h-full w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr]">
    <div class="hidden border-r border-zinc-700 bg-muted/40 md:block">
      <div class="flex flex-col gap-2">
        <!-- <div class="flex-1"> -->
          <nav class="grid items-start px-2 text-sm font-medium lg:pl-2.5 text-zinc-950 fixed">
            <div class="flex w-full h-14 items-center justify-center border-b border-zinc-700 px-4 lg:h-[60px] lg:px-6">
                <a href="/" class="flex items-center gap-2 font-semibold">
                    <Bot class="h-6 w-6" />
                    <span class="">ALFA and Friends Assistant</span>
                </a>
            </div>
            <Button
              @click.once.prevent="$inertia.get(route('ai.index'))"
              class="mt-3"
            >
              <PlusCircle class="h-5 w-5 mr-1" />
              <span class="font-medium">New Chat</span>
            </Button>
            <span class="pl-1 mt-5 mb-2">Sessions</span>
            <div class="space-y-1" v-for="thread in props.threads">
                <a
                    @click.once="thread.id != form.chat_id ? $inertia.get(route('chat.edit', thread.id)) : ''"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-primary transition-all hover:bg-zinc-800 hover:text-white cursor-pointer"
                    :class="{'bg-zinc-800 text-white': thread.id == form.chat_id}"
                >
                    <span class="truncate w-52">{{ thread.name }}</span>
                    <Trash2 class="w-4 text-red-500" @click="deleteThread(thread.id)"/>
                </a>
            </div>
          </nav>
        <!-- </div> -->
      </div>
    </div>
    <div class="flex flex-col bg-zinc-900 text-white">
      <header class="flex justify-between md:justify-end h-14 items-center gap-4 px-4 lg:h-[60px] lg:px-6 sticky top-0 bg-white">
        <Sheet>
          <SheetTrigger as-child>
            <Button
              variant="outline"
              size="icon"
              class="shrink-0 md:hidden bg-zinc-800"
            >
              <Menu class="h-5 w-5 dark:text-white" />
              <span class="sr-only">Toggle navigation menu</span>
            </Button>
          </SheetTrigger>
          <SheetContent side="left" class="flex flex-col">
            <nav class="grid gap-2 text-lg font-medium">
              <a
                href="#"
                class="flex items-center gap-2 text-lg font-semibold"
              >
                <Package2 class="h-6 w-6" />
                <span class="sr-only">Acme Inc</span>
              </a>
              <a
                href="#"
                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
              >
                <Home class="h-5 w-5" />
                Dashboard
              </a>
              <a
                href="#"
                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl bg-muted px-3 py-2 text-foreground hover:text-foreground"
              >
                <ShoppingCart class="h-5 w-5" />
                Orders
                <Badge class="ml-auto flex h-6 w-6 shrink-0 items-center justify-center rounded-full">
                  6
                </Badge>
              </a>
              <a
                href="#"
                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
              >
                <Package class="h-5 w-5" />
                Products
              </a>
              <a
                href="#"
                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
              >
                <Users class="h-5 w-5" />
                Customers
              </a>
              <a
                href="#"
                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
              >
                <LineChart class="h-5 w-5" />
                Analytics
              </a>
            </nav>
          </SheetContent>
        </Sheet>
        <DropdownMenu>
          <DropdownMenuTrigger as-child>
            <Button variant="secondary" size="icon" class="rounded-full">
              <CircleUser class="h-5 w-5" />
              <span class="sr-only">Toggle user menu</span>
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end">
            <DropdownMenuLabel>My Account</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem>Settings</DropdownMenuItem>
            <DropdownMenuItem>Support</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem>Logout</DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </header>
      <main class="flex flex-1 flex-col items-center justify-between gap-4 p-4 lg:gap-6 lg:p-6 max-h-svh overflow-hidden -mt-16 bg-white">
            <div class="flex flex-col w-full max-w-3xl px-3 gap-10 overflow-auto scroll max-h-[36rem] mt-16 py-2" ref="chatbox">
                <template v-if="messages" v-for="message in messages.data.reverse()">
                    <span class="flex items-start space-x-2 " v-if="message.role == 'assistant'">
                        <BotIcon class="min-h-6 min-w-6 text-zinc-900"/>
                        <VMarkdownView class="px-3"
                            mode="light"
                            :content="message.content[0]?.text?.value"
                        ></VMarkdownView>
                    </span>
                    <span class="flex items-center justify-end space-x-2 ml-20" v-if="message.role == 'user'">
                        <span class="rounded-xl border bg-zinc-800 px-4 py-1.5">{{ message.content[0].text.value }}</span>
                    </span>
                </template>
            </div>
            <div class="relative bottom-0 w-full max-w-3xl">
                <form @keydown="onKeydown">
                    <div class="flex justify-center px-3 pb-3 gap-2" v-if="!props.chat_data">
                        <div class="flex gap-1 items-center cursor-pointer bg-zinc-800 hover:bg-zinc-700 text-sm text-zinc-200 border rounded-xl px-4 py-2" @click.once="generateQuiz">
                            <LightbulbIcon class="h-4 w-4"/>
                            <span>Generate a Quiz</span>
                        </div>
                    </div>
                    <div class="relative rounded-2xl bg-zinc-800 p-5 max-h-52">
                        <div class="max-h-28 overflow-auto border-none focus:outline-none focus:ring-none mb-12 px-2" contenteditable="true" @input="updateChat" ref="prompt_input"></div>
                    </div>
                    <div class="absolute bottom-0 w-full px-5 py-3 pt-">
                        <div class="flex items-center justify-between">
                            <Paperclip class="h-9 w-9 rounded-full cursor-pointer hover:bg-zinc-700 p-2"/>
                            <SendHorizonal class="h-10 w-10 rounded-full cursor-pointer hover:bg-zinc-700 p-2" @click.once="sending_reply == false ? submit() : ''"/>
                        </div>
                    </div>
                </form>
            </div>
      </main>
    </div>
  </div>
    <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
        <template #title>Delete Chat</template>
        <template #description>Are you sure want to delete this chat?</template>
    </DeleteConfirmation>
</template>

<style>
    .markdown-body[data-theme=dark] .highlight pre, .markdown-body[data-theme=dark] pre{
        @apply bg-zinc-800
    }
</style>