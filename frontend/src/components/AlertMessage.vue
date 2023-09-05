<script setup lang="ts">
import { ref, computed } from 'vue'
import { useMessageStore } from '@/stores/message'

const messageStore = useMessageStore()

interface AlertMessage {
    status: Number,
    data: String
}

const props = ref<AlertMessage>({
    status: 0,
    data: ''
})

computed(()=> messageStore.axios)

messageStore.$subscribe((mutations, state) => {
    if(state.axios != null)
        props.value.status = state.axios.status
        props.value.data = state.axios.data
})





</script>

<template>
    <div class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-md text-yellow-700 bg-yellow-100 border border-yellow-300 ">
        <div slot="avatar">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info w-5 h-5 mx-2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
        </div>
        <div class="text-xl font-normal  max-w-full flex-initial">
            <div class="py-2">{{ props.status }}
                <div class="text-sm font-base">{{ props.data }}</div>
            </div>
        </div>
        <div class="flex flex-auto flex-row-reverse">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-yellow-400 rounded-full w-5 h-5 ml-2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </div>
        </div>
    </div>
</template>