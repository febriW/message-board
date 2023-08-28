<script setup lang="ts">
import IconMessage from '@/components/icons/IconMessage.vue'
import IconSendMessage from '@/components/icons/IconSendMessage.vue'
</script>
<template>
    <main>
        <div class="grid grid-flow-row gap-x-12">
            <div class="flex items-center justify-center">
                <div>
                    <IconMessage />
                </div>
                <div class="text-4xl text-blue-600">
                    <p>Message Board</p>
                </div>
            </div>
            <div class="pb-6">
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
            <div class="shadow-2xl h-screen">
                   
            </div>
            <button title="Create Message"
                class="fixed z-90 bottom-10 right-8 bg-white shadow-2xl w-20 h-20 rounded-lg flex justify-center
                items-center text-white text-4xl">
                <IconSendMessage />
            </button>
        </div>
    </main>
</template>