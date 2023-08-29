<script setup lang="ts">
import IconMessage from '@/components/icons/IconMessage.vue'
import IconSendMessage from '@/components/icons/IconSendMessage.vue'
import StickyNote from '@/components/StickyNote.vue'
import type MessageType from '@/types/MessageType'
import { useMessageStore } from '@/stores/message'
import { onMounted, toRefs, computed, ref } from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

const messageStore = useMessageStore()

onMounted(async ()=>{
    await messageStore.fetchData() 
})

const { message } = toRefs(messageStore)
const isOpen = ref(false)
  
const  closeModal = () => {
    isOpen.value = false
}
const openModal = () => {
    isOpen.value = true
}

const form = ref<MessageType>({
    name: '',
    email: '',
    message: ''
})

const sendCreateMessage = async () => {
    await messageStore.createMessage(form.value)
}

</script>
<template>
    <main>
        <div class="grid gap-x-12">
            <div class="sm:flex grid items-center justify-center">
                <div>
                    <IconMessage />
                </div>
                <div class="sm:show text-xl sm:text-4xl text-blue-600">
                    <p>Message Board</p>
                </div>
            </div>
            <div class="p-6">
                <form>   
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" id="default-search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search Messages, Name, Email..." required>
                        <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="h-[36em] sm:h-[38em] overflow-y-auto p-6">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 items-center justify-center">
                    <div v-for="data in message" :key="data.id">
                        <StickyNote
                            :id = data.id
                            :name= data.name
                            :email= data.email
                            :message= data.message />
                    </div>
                </div>
            </div>
            <button title="Create Message" @click="openModal"
                class="fixed z-90 bottom-10 right-8 bg-white shadow-2xl w-20 h-20 rounded-lg flex justify-center
                items-center text-white text-4xl">
                <IconSendMessage />
            </button>
        </div>
        <template>
            <TransitionRoot appear :show="isOpen" as="template">
                <Dialog as="div" @close="closeModal" class="relative z-10">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                    </TransitionChild>
            
                    <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                        >
                            <DialogTitle
                                as="h3"
                                class="text-lg font-medium leading-6 text-gray-900 text-center pb-4"
                            >
                            Create New Message
                            </DialogTitle>
                            <form>
                                <div class="mt-2">
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                                Name
                                            </label>
                                            <input v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 
                                            text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                            id="name" type="text" placeholder="Name" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                                Email
                                            </label>
                                            <input v-model="form.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                                            leading-tight focus:outline-none focus:shadow-outline" 
                                            id="email" 
                                            type="text" 
                                            placeholder="Email" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="message">
                                                Message
                                            </label>
                                            <textarea v-model="form.message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                                            leading-tight focus:outline-none focus:shadow-outline" 
                                            id="message"  
                                            placeholder="Message" required></textarea>
                                        </div>
                                </div>
                                <div class="mt-4 grid grid-flow-col gap-6">
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 
                                        py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 
                                        focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="sendCreateMessage"
                                    >
                                        Send Message
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm 
                                        font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 
                                        focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="closeModal"
                                    >
                                        Close
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                        </TransitionChild>
                    </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </template>
    </main>
</template>