<script setup>
import { Button } from '@/Components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu'
import { Sheet, SheetContent, SheetTrigger } from '@/Components/ui/sheet'
import { Bot, BotIcon, BrushIcon, Calculator, CalculatorIcon, User, LayoutTemplateIcon, LightbulbIcon, ListCheck, Menu, NotebookPen, Paperclip, PlusCircle, SendHorizonal, Trash2, BabyIcon, Undo } from 'lucide-vue-next'
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
		student_id: '',
		student_name: '',
        program: '',
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
      if(!this.form.messages || (this.$page.props.chat_data && this.$page.props.chat_data[this.$page.props.chat_data.length - 1]?.status != 'completed')){
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
	  this.focusInput()

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
	selectName(id, name){
		this.form.student_id = id
		this.form.student_name = name
	},
	selectProgram(program){
		this.form.program = program
	},
    doExercise(){
      	this.form.messages = "Do an exercise"
        axios.post(route('ai.store'), this.form)
        .then((response) => {
          if(response.data.chat_id){
            this.$inertia.get(route('chat.edit', response.data.chat_id))
          }
        })
    },
    generateQuiz(){
      	this.form.messages = 'Generate a quiz'
        axios.post(route('ai.store'), this.form)
        .then((response) => {
          if(response.data.chat_id){
            this.$inertia.get(route('chat.edit', response.data.chat_id))
          }
        })
    },
    performAssessment(){
      	this.form.messages = 'Perform an assessment'
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
	},
	focusInput(){
		if(this.$refs.prompt_input){
			this.$refs.prompt_input.focus();
		}
	}
  },
  mounted(){
	this.scrollToBottom()
	this.focusInput()

	window.Echo.private("ai_response_stream."+this.$page.props.auth.user.ID)
	.stopListening("AiResponseStream")
	.listen("AiResponseStream", (event) => {
		if(event){
			if(event[0].thread_id){
				this.form.thread_id = event[0].thread_id
			}
			if(event[0].status == 'created'){
				this.$page.props.chat_data[this.$page.props.chat_data.length - 1].status = 'created'
				this.$page.props.chat_data[this.$page.props.chat_data.length - 1].response = ''
			}
			if(event[0].status == 'processing' && this.$page.props.chat_data[this.$page.props.chat_data.length - 1].status == 'created'){
				this.$page.props.chat_data[this.$page.props.chat_data.length - 1].response += event[0].text
			}
			if(event[0].status == 'completed'){
				this.$page.props.chat_data[this.$page.props.chat_data.length - 1].status = event[0].status
				this.$page.props.chat_data[this.$page.props.chat_data.length - 1].response = event[0].text
			}
			this.scrollToBottom()
		}
	});
	
  }
}
</script>

<template>
  <div class="grid h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr] font-nunito bg-gradient-to-r from-rose-100 to-teal-100">
    <div class="hidden border-r border-zinc-500 md:block">
      <div class="flex flex-col gap-2">
        <!-- <div class="flex-1"> -->
          <nav class="grid items-start px-2 text-sm font-medium lg:pl-2.5 text-zinc-950">
            <div class="flex w-full h-14 items-center justify-center border-b border-zinc-700 px-4 lg:h-[60px] lg:px-6">
                <div class="flex items-center gap-2 font-semibold">
                    <Bot class="h-6 w-6" />
                    <span class="mt-0.5 font-semibold">ALFA and Friends AI</span>
                </div>
            </div>
			<Button
				@click.once.prevent="$inertia.get(route('ai.index'))"
				class="mt-3 w-full"
				>
				<PlusCircle class="h-5 w-5 mr-1" />
				<span class="font-medium">New Chat</span>
			</Button>
			<span class="pl-1 mt-5 mb-2 font-semibold">Sessions</span>
			<div class="space-y-1" v-for="chat in $page.props.chats">
				<a
					@click.once="chat.id != form.chat_id ? $inertia.get(route('chat.edit', chat.id)) : ''"
					class="flex items-center justify-between gap-3 rounded-lg px-3 py-2 text-primary transition-all hover:bg-zinc-800 hover:text-white cursor-pointer"
					:class="{'bg-zinc-800 text-white': chat.id == form.chat_id}"
				>
					<span class="truncate md:max-w-36 lg:max-w-48 xl:max-w-52">{{ chat.name }}</span>
					<Trash2 class="w-4 text-red-500" @click.stop="deleteChat(chat.id)"/>
				</a>
			</div>
			<!-- <div class="flex w-full flex-col">
			</div> -->
          </nav>
        <!-- </div> -->
      </div>
    </div>
    <div class="flex flex-col text-white">
      <header class="flex justify-between md:justify-end h-14 items-center gap-4 px-4 lg:h-[60px] lg:px-6 sticky top-0 bg-gradient-to-r from-rose-100 to-teal-100">
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
			<Button
				@click.once.prevent="$inertia.get(route('ai.index'))"
				class="mt-8"
				>
				<PlusCircle class="h-5 w-5 mr-1" />
				<span class="font-medium">New Chat</span>
			</Button>
            <nav class="grid gap-2 text-lg font-medium">
				<span class="pl-1 mt-2 text-sm">Sessions</span>
				<div class="space-y-1" v-for="chat in $page.props.chats">
					<a
						@click.once="chat.id != form.chat_id ? $inertia.get(route('chat.edit', chat.id)) : ''"
						class="flex items-center justify-between gap-3 rounded-lg px-3 py-2 text-primary transition-all hover:bg-zinc-800 hover:text-white cursor-pointer"
						:class="{'bg-zinc-800 text-white': chat.id == form.chat_id}"
					>
						<span class="truncate md:max-w-36 max-w-36 lg:max-w-48 xl:max-w-52 text-sm">{{ chat.name }}</span>
						<Trash2 class="w-4 text-red-500" @click.stop="deleteChat(chat.id)"/>
					</a>
				</div>
            </nav>
          </SheetContent>
        </Sheet>
        <DropdownMenu>
          <DropdownMenuTrigger as-child>
            <Button size="icon" class="bg-inherit hover:bg-transparent border-2 border-zinc-900 shadow-none rounded-full">
              <User class="h-5 w-5 text-zinc-800" />
              <span class="sr-only">Toggle user menu</span>
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end">
            <DropdownMenuLabel>{{ $page.props.auth.user.display_name }}</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <!-- <DropdownMenuItem>Settings</DropdownMenuItem>
            <DropdownMenuItem>Support</DropdownMenuItem>
            <DropdownMenuSeparator /> -->
            <DropdownMenuItem @click="$inertia.post(route('logout'))">Logout</DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </header>
      <main class="flex flex-1 flex-col items-center gap-4 p-4 lg:gap-6 lg:px-6 lg:py-3 max-h-[calc(100vh-60px)]" :class="{'justify-between': $page.props.chat_data, 'justify-center': !$page.props.chat_data}">
		<div class="name_section" v-if="!form.student_id && !form.program && !$page.props.chat_data">
			<div class="flex flex-col items-center mt-16 text-slate-900">
				<span
					class="md:animate-typing text-2xl font-semibold oveflow-auto xl:overflow-hidden font-nunito xl:whitespace-nowrap inline-block text-center" style="width: 100%">
					Before we get started, could you please tell me your name?
				</span>
				<div class="flex flex-col md:flex-row justify-center px-3 pb-3 gap-2 mt-8">
					<template v-for="child in $page.props.user_has_children">
						<div class="flex flex-col bg-white" v-if="child?.student_id" @click.once="selectName(child.student_id, child.child_name)">
							<a class="px-5 py-2 w-full relative rounded-lg group overflow-hidden text-lg font-medium border-2 cursor-pointer border-black text-black inline-block">
								<span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-black group-hover:h-full opacity-90"/>
								<span class="relative group-hover:text-white">
									<div class="flex gap-2 items-center ">
										<BabyIcon class="h-5 w-5"/>
										<span class="select-none">{{ child.child_name }}</span>
									</div>
								</span>
							</a>
						</div>
					</template>
				</div>
			</div>
		</div>
		<div class="program_section" v-else-if="!form.program && !$page.props.chat_data">
			<div class="flex flex-col items-center mt-16 text-slate-900">
				<span
					class="md:animate-typing text-2xl font-semibold oveflow-auto xl:overflow-hidden font-nunito xl:whitespace-nowrap inline-block text-center" style="width: 100%">
					Which program would you like me to assist you on?
				</span>
				<div class="flex flex-col md:flex-row justify-center md:items-center px-3 pb-3 gap-2 mt-8">
					<a class="flex px-5 py-2 w-full relative rounded-lg group text-lg font-medium border-2 cursor-pointer border-black text-black bg-white" v-for="programme in $page.props.programmes" v-if="$page.props.children_classes.find((programme) => programme.student_id === form.student_id && programme.programme_name === 'ANFC Maths')" @click.once="selectProgram('maths')">
						<span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-black group-hover:h-full opacity-90"/>
						<span class="relative group-hover:text-white">
							<div class="flex gap-2 items-center ">
								<CalculatorIcon class="h-5 w-5"/>
								<span class="select-none whitespace-nowrap">{{ programme.name }}</span>
							</div>
						</span>
					</a>
					<!-- <a class="flex px-5 py-2 w-full relative rounded-lg group text-lg font-medium border-2 cursor-pointer border-black text-black bg-white" v-if="$page.props.children_classes.find((programme) => programme.student_id === form.student_id && programme.programme_name === 'ANFC Coding & Robotics')" @click.once="selectProgram('coding_robotics')">
						<span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-black group-hover:h-full opacity-90"/>
						<span class="relative group-hover:text-white">
							<div class="flex gap-2 items-center ">
								<LayoutTemplateIcon class="h-5 w-5"/>
								<span class="select-none whitespace-nowrap">Coding & Robotics</span>
							</div>
						</span>
					</a>
					<a class="px-5 py-2 w-full relative rounded-lg group text-lg font-medium border-2 cursor-pointer border-black text-black bg-white" v-if="$page.props.children_classes.find((programme) => programme.student_id === form.student_id && programme.programme_name === 'ANFC Digital Art')" @click.once="selectProgram('digital_art')">
						<span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-black group-hover:h-full opacity-90"/>
						<span class="relative group-hover:text-white">
							<div class="flex gap-2 items-center ">
								<BrushIcon class="h-5 w-5"/>
								<span class="select-none whitespace-nowrap">Digital Art</span>
							</div>
						</span>
					</a> -->
				</div>
				<div class="flex items-center mt-5 gap-1 hover:underline cursor-pointer" @click="form.student_id = ''">
					<Undo class="w-4 h-4"/>
					<span class="font-sm font-semibold text-slate-800">Back</span>
				</div>
			</div>
		</div>
		<div class="flex flex-col px-3 gap-10 py-2 max-w-3xl max-h-[36rem] md:max-h-[100%] w-full overflow-auto text-slate-900" ref="chatbox" v-else>
			<span v-if="!$page.props.chat_data"
				class="md:animate-typing self-center text-center text-2xl font-semibold oveflow-auto xl:overflow-hidden font-nunito xl:whitespace-nowrap inline-block" style="width: 100%">
				What would you like to do today?
			</span>
			<template v-if="$page.props.chat_data" v-for="message in $page.props.chat_data">
				<span class="flex items-center justify-end space-x-2 ml-20 text-white" v-if="message.prompt">
					<span class="rounded-xl border bg-zinc-800 px-4 py-1.5">{{ message.prompt }}</span>
				</span>
				<span class="flex items-start space-x-2 " v-if="message.response || message.status == 'created' || message.status == 'completed'">
					<BotIcon class="min-h-6 min-w-6 text-zinc-900"/>
					<VMarkdownView class="px-3" style="background-color: transparent !important;"
						:content="message.response"
					></VMarkdownView>
				</span>
				<span class="flex items-start space-x-2 " v-else>
					<BotIcon class="min-h-6 min-w-6 text-zinc-900"/>
					<div class="px-2">
						<Label class="flex items-center space-x-0.5 text-slate-800 text-base animate-pulse">
							<LightBulbIcon class="text-slate-500 w-5 h-5"/>
							<span>Just a moment...</span>
						</Label>
					</div>
				</span>
			</template>
		</div>
		<div class="relative w-full max-w-3xl" v-if="form.program == 'maths' || form.program == 'coding_robotics' || form.program == 'digital_art' || $page.props.chat_data">
			<div class="" v-if="!$page.props.chat_data && form.program == 'maths'">
				<ScrollArea class="max-w-3xl md:max-h-[36rem] w-full mt-16 px-4" asDiv ref="chatbox">
					<div class="flex flex-col xl:flex-row justify-center px-3 pb-3 gap-2">
						<div class="flex flex-col bg-white" @click.once="doExercise">
							<a class="rounded w-full relative inline-flex group items-center justify-left hover:justify-center px-4 py-2 cursor-pointer border-2 border-black text-lg font-medium transition-all ease-out overflow-hidden text-black hover:text-white">
								<span class="absolute w-0 h-0 transition-all duration-300 ease-out bg-black rounded-full group-hover:w-96 group-hover:h-32"/>
								<div class="relative flex gap-1 items-center">
									<NotebookPen class="h-4 w-4"/>
									<span class="text-sm select-none">Do an Exercise</span>
								</div>
							</a>
						</div>
						<div class="flex flex-col bg-white" @click.once="generateQuiz">
							<a class="rounded w-full relative inline-flex group items-center justify-left hover:justify-center px-4 py-2 cursor-pointer border-2 border-black text-lg font-medium transition-all ease-out overflow-hidden text-black hover:text-white">
								<span class="absolute w-0 h-0 transition-all duration-300 ease-out bg-black rounded-full group-hover:w-96 group-hover:h-32"/>
								<div class="relative flex gap-1 items-center">
									<LightbulbIcon class="h-4 w-4"/>
									<span class="text-sm select-none">Generate a Quiz</span>
								</div>
							</a>
						</div>
						<div class="flex flex-col bg-white" @click.once="performAssessment">
							<a class="rounded w-full relative inline-flex group items-center justify-left hover:justify-center px-4 py-2 cursor-pointer border-2 border-black text-lg font-medium transition-all ease-out overflow-hidden text-black hover:text-white">
								<span class="absolute w-0 h-0 transition-all duration-300 ease-out bg-black rounded-full group-hover:w-96 group-hover:h-32"/>
								<div class="relative flex gap-1 items-center">
									<ListCheck class="h-4 w-4"/>
									<span class="text-sm select-none">Perform an Assessment</span>
								</div>
							</a>
						</div>
					</div>
				</ScrollArea>
			</div>
			<form @keydown="onKeydown" class="text-center px-2">
				<div class="relative rounded-2xl bg-zinc-800 max-h-52 mb-2">
					<div class="max-h-28 overflow-auto border-none focus:outline-none focus:ring-none text-left mb-3 px-5 pt-5" contenteditable="true" @input="updateChat" ref="prompt_input"></div>
					<div class="bottom-0 w-full pb-2 px-3">
						<div class="flex items-center justify-between">
							<Paperclip class="h-9 w-9 rounded-full cursor-pointer hover:bg-zinc-700 p-2"/>
							<div class="flex items-center gap-2">
								<span class="text-xs text-zinc-400">Ctrl + Enter</span>
								<SendHorizonal class="h-9 w-9 rounded-full cursor-pointer hover:bg-zinc-700 p-1.5" @click="submit"/>
							</div>
						</div>
					</div>
				</div>
				<small class="mb-3 font-semibold text-zinc-700">AI can make mistakes. Any feedback is appreciated.</small>
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
	pre {
		background-color: transparent !important; /* Equivalent to bg-black */
	}
</style>