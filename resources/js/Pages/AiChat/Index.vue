<script setup lang="ts">
import { Badge } from '@/Components/ui/badge'

import { Button } from '@/Components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu'
import { Input } from '@/Components/ui/input'
import { Sheet, SheetContent, SheetTrigger } from '@/Components/ui/sheet'
import { useForm } from '@inertiajs/inertia-vue3'
import { Bell, Bot, BotIcon, BotMessageSquare, CircleUser, File, Home, LineChart, Menu, Package, Package2, Paperclip, Plus, PlusCircle, Search, Send, ShoppingCart, Users } from 'lucide-vue-next'
import { onMounted } from 'vue'

const form = useForm({
    id: '',
    message: ''
})

const updateChat = ((event) => {
    form.message = event.target.innerText;
})
</script>

<template>
  <div class="grid min-h-screen h-full w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr]">
    <div class="hidden border-r border-zinc-700 bg-muted/40 md:block bg-zinc-900">
      <div class="flex flex-col gap-2">
        <!-- <div class="flex-1"> -->
          <nav class="grid items-start px-2 text-sm font-medium lg:px-4 text-zinc-950 fixed">
            <div class="flex w-full h-14 items-center justify-center border-b border-zinc-700 px-4 lg:h-[60px] lg:px-6 text-white">
                <a href="/" class="flex items-center gap-2 font-semibold">
                    <Bot class="h-6 w-6" />
                    <span class="">ALFA and Friends AI</span>
                </a>
            </div>
            <Button variant="outline"
              href="/"
              class="mt-3"
            >
              <PlusCircle class="h-5 w-5 mr-1" />
              <span class="font-medium">New Chat</span>
            </Button>
            <span class="pl-1 mt-5 mb-2 text-white">Sessions</span>
            <div class="space-y-1">
                <a
                href="#"
                class="flex items-center gap-3 rounded-lg bg-muted px-3 py-2 text-primary transition-all bg-zinc-800 text-white"
                >
                <span class="truncate w-52">Clarification RequestEnable windows environment</span>
                </a>
                <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:bg-zinc-800 text-white"
                >
                <span class="truncate w-52">Let me know whenever you're ready to share or ask something!</span>
                </a>
            </div>
          </nav>
        <!-- </div> -->
      </div>
    </div>
    <div class="flex flex-col bg-zinc-900 text-white">
      <header class="flex justify-between md:justify-end h-14 items-center gap-4 bg-muted/40 px-4 lg:h-[60px] lg:px-6 bg-zinc-950 text-white sticky top-0">
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
      <main class="flex flex-1 flex-col items-center justify-between gap-4 p-4 lg:gap-6 lg:p-6 bg-zinc-950 max-h-svh overflow-hidden -mt-16">
            <div class="flex flex-col w-full max-w-3xl px-3 gap-10 overflow-auto scroll max-h-[36rem] mt-16">
                <span class="flex items-center space-x-2">
                    <BotIcon class="h-6 w-6"/>
                    <span>Hi, how can I help you?</span>
                </span>
                <span class="flex items-center justify-end space-x-2 ml-20">
                    <span class="rounded-xl border bg-zinc-800 px-4 py-1.5"> Hi, can you help me with math question?Hi, can you help me with math question?Hi, can you help me with math question?Hi, can you help me with math question?</span>
                </span>
            </div>
            <div class="relative bottom-0 w-full max-w-3xl">
                <form>
                    <div class="relative rounded-2xl bg-zinc-800 p-5 max-h-52">
                        <div class="max-h-28 min-h-20 overflow-auto border-none focus:outline-none focus:ring-none mb-10" contenteditable="true" @input="updateChat"></div>
                    </div>
                    <div class="absolute bottom-0 w-full px-5 py-5 pt-5">
                        <div class="flex justify-between">
                            <Paperclip class="h-5 w-5 cursor-pointer"/>
                            <Send class="h-5 w-5 cursor-pointer" @click="form.post(route('ai.store'))"/>
                        </div>
                    </div>
                </form>
            </div>
      </main>
    </div>
  </div>
</template>