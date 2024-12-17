<script setup>
import { Badge } from '@/Components/ui/badge'
import { Button } from '@/Components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu'
import { Input } from '@/Components/ui/input'
import { Sheet, SheetContent, SheetTrigger } from '@/Components/ui/sheet'
import { Inertia } from '@inertiajs/inertia'
import { Bot, BotIcon, CircleUser, Home, LightbulbIcon, LineChart, ListCheck, Menu, NotebookPen, Package, Package2, Paperclip, PlusCircle, SendHorizonal, ShoppingCart, Trash2, Users } from 'lucide-vue-next'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';   
import { VMarkdownView } from 'vue3-markdown'
import 'vue3-markdown/dist/style.css'
import { LightBulbIcon } from '@heroicons/vue/solid'
import { ScrollArea } from '@/Components/ui/scroll-area'
</script>

<script>
export default {
  data(){
    return {
      confirmation: {
        id: '',
        route_name: '',
        is_open: false
      },
      processing: false,
      form: {
        chat_id: this.$page.props?.chat_id || '',
        thread_id: this.$page.props?.thread_id || '',
        messages: ''
      },
    }
  },
  methods: {
    updateChat(event){
      this.form.messages = event.target.innerText;
    },
    submit(){
      if(!this.form.messages || (this.$page.props.chat_data && this.$page.props.chat_data[this.$page.props.chat_data.length - 1]?.status != 'finished')){
          return
      }

      this.$refs.prompt_input.innerText = ''

      if(!this.form.chat_id){
        axios.post(route('ai.store'), this.form)
        .then((response) => {
          if(response.data.chat_id){
            this.$inertia.get(route('chat.edit', response.data.chat_id))
          }
        })
      }
      else{
		this.$page.props.chat_data.push({
			prompt: this.form.messages,
			status: 'processing'
		})
        axios.patch(route('ai.update', this.form.chat_id), this.form)
		.then((response) => {
			this.form.messages = ''
		})
      }
	  this.scrollToBottom()
	  this.$refs.prompt_input.focus();

    },
    onKeydown(event){
      if (event.ctrlKey && event.key === 'Enter') {
          this.submit()
      }
    },
    deleteChat(chat_id){
      this.confirmation.route_name    = 'ai.destroy'
      this.confirmation.id            = chat_id
      this.confirmation.is_open       = true
    },
    generateQuiz(){
      	this.form.messages = 'Generate a random quiz'
        axios.post(route('ai.store'), this.form)
        .then((response) => {
          if(response.data.chat_id){
            this.$inertia.get(route('chat.edit', response.data.chat_id))
          }
        })
    },
    performEvaluation(){
      	this.form.messages = 'Perform an evaluation'
        axios.post(route('ai.store'), this.form)
        .then((response) => {
          if(response.data.chat_id){
            this.$inertia.get(route('chat.edit', response.data.chat_id))
          }
        })
    },
	scrollToBottom(){
		this.$nextTick(() => {
			if(this.$refs.chatbox){
				this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight;
			}
		});
	}
  },
  mounted(){
	this.scrollToBottom()
    this.$refs.prompt_input.focus();

    window.Echo.private("ai_response_stream."+this.$page.props.auth.user.ID)
    .stopListening("AiResponseStream")
    .listen("AiResponseStream", (event) => {
		if(event){
			if(event[0].thread_id){
				this.form.thread_id = event[0].thread_id
			}
			this.$page.props.chat_data[this.$page.props.chat_data.length - 1].response = event[0].text
			this.$page.props.chat_data[this.$page.props.chat_data.length - 1].status = 'finished'
	  		this.scrollToBottom()
		}
    });
  }
}
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
            <div class="space-y-1" v-for="chat in $page.props.chats">
                <a
                    @click.once="chat.id != form.chat_id ? $inertia.get(route('chat.edit', chat.id)) : ''"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-primary transition-all hover:bg-zinc-800 hover:text-white cursor-pointer"
                    :class="{'bg-zinc-800 text-white': chat.id == form.chat_id}"
                >
                    <span class="truncate w-52">{{ chat.name }}</span>
                    <Trash2 class="w-4 text-red-500" @click.stop="deleteChat(chat.id)"/>
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
      <main class="flex flex-1 flex-col items-center justify-between gap-4 p-4 lg:gap-6 lg:p-6 h-svh overflow-hidden -mt-16 bg-white">
			<ScrollArea class="max-w-3xl max-h-[36rem] w-full mt-16 px-4" asDiv ref="chatbox">
				<div class="flex flex-col px-3 gap-10 py-2">
					<template v-if="$page.props.chat_data" v-for="message in $page.props.chat_data">
						<span class="flex items-center justify-end space-x-2 ml-20" v-if="message.prompt">
							<span class="rounded-xl border bg-zinc-800 px-4 py-1.5">{{ message.prompt }}</span>
						</span>
						<span class="flex items-start space-x-2 " v-if="message.response && message.status != 'processing'">
							<BotIcon class="min-h-6 min-w-6 text-zinc-900"/>
							<VMarkdownView class="px-3"
								mode="light"
								:content="message.response"
							></VMarkdownView>
						</span>
						<span class="flex items-start space-x-2 " v-else>
							<BotIcon class="min-h-6 min-w-6 text-zinc-900"/>
							<div class="px-2">
								<Label class="flex items-center space-x-0.5 text-slate-800 text-base animate-pulse">
									<LightBulbIcon class="text-slate-500 w-5 h-5"/>
									<span>Thinking...</span>
								</Label>
							</div>
						</span>
					</template>
				</div>
			</ScrollArea>
			<div class="flex flex-col justify-center" v-if="!$page.props.chat_data">
				<span
					class="animate-typing text-slate-600 text-2xl font-semibold overflow-hidden font-nunito whitespace-nowrap inline-block text-center" style="width: 100%">
					Hello there, what can I do for you?
				</span>
				<div class="">
					<ScrollArea class="max-w-3xl max-h-[36rem] w-full mt-16 px-4" asDiv ref="chatbox">
						<div class="flex justify-center px-3 pb-3 gap-1" v-if="!$page.props.chat_data">
							<div class="flex gap-1 items-center select-none font-medium cursor-pointer shadow shadow-slate-400 bg-gradient-to-r from-violet-200 to-pink-200 hover:scale-95 transition-all duration-150 text-sm text-zinc-700 rounded-lg px-4 py-2" @click.once="generateQuiz">
								<NotebookPen class="h-4 w-4"/>
								<span>Do Exercises</span>
							</div>
							<div class="flex gap-1 items-center select-none font-medium cursor-pointer shadow shadow-slate-400 bg-gradient-to-r from-blue-200 to-cyan-200 hover:scale-95 transition-all duration-150 text-sm text-zinc-700 rounded-lg px-4 py-2" @click.once="generateQuiz">
								<LightbulbIcon class="h-4 w-4"/>
								<span>Generate a Quiz</span>
							</div>
							<div class="flex gap-1 items-center select-none font-medium cursor-pointer shadow shadow-slate-400 bg-gradient-to-r from-teal-200 to-teal-500 hover:scale-95 transition-all duration-150 text-sm text-zinc-700 rounded-lg px-4 py-2" @click.once="performEvaluation">
								<ListCheck class="h-4 w-4"/>
								<span>Perform an Assessment</span>
							</div>
						</div>
					</ScrollArea>
				</div>
			</div>
            <div class="relative bottom-0 w-full max-w-3xl">
				<form @keydown="onKeydown">
                    <div class="relative rounded-2xl bg-zinc-800 p-5 max-h-52">
                        <div class="max-h-28 overflow-auto border-none focus:outline-none focus:ring-none mb-12 px-2" contenteditable="true" @input="updateChat" ref="prompt_input"></div>
                    </div>
                    <div class="absolute bottom-0 w-full px-5 py-3 pt-">
                        <div class="flex items-center justify-between">
                            <Paperclip class="h-9 w-9 rounded-full cursor-pointer hover:bg-zinc-700 p-2"/>
                            <SendHorizonal class="h-10 w-10 rounded-full cursor-pointer hover:bg-zinc-700 p-2" @click="submit"/>
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