<script setup lang="ts">
import IconPaperPin from '@/components/icons/IconPaperPin.vue'
import type MessageType from '@/types/MessageType'

defineProps<MessageType>()

</script>
<template>
        <div class="block bg-[#fafa69] p-6 
        shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)]
        h-[20em] w-[20em] relative">
            <div class="absolute top-[-0.7em] right-[-0.7em]">
                <IconPaperPin class="w-[2em] h-[2em]"/>
            </div>
            <div>
                <h5>{{ name }}</h5>
                <p>{{ email }}</p>
            </div>
            <div class="py-3 break-all">
                <p>{{ message }}</p>
            </div>
        </div>
    
</template>