<script setup lang="ts">
import IconLinkedin from "@/components/icons/IconLinkedin.vue"
import IconGithub from "@/components/icons/IconGithub.vue"
</script>
<template>
    <footer class="bg-slate-300 ">
        <div class="container flex flex-col items-center justify-between p-6 mx-auto space-y-4 sm:space-y-0 sm:flex-row">
            <a href="#">
                <p>Febri Wanda</p>
            </a>
            
            <p class="text-sm text-gray-600 ">&copy; Copyright 2023. All Rights Reserved.</p>

            <div class="flex -mx-2">
                <a href="https://www.linkedin.com/in/febri-wanda/" target="_blank" class="mx-2 text-gray-600 transition-colors duration-300  hover:text-blue-500" aria-label="Linkedin">
                    <IconLinkedin />
                </a>
                <a href="https://github.com/febriW/" target="_blank" class="mx-2 text-gray-600 transition-colors duration-300  hover:text-blue-500 dark:hover:text-blue-400" aria-label="Github">
                    <IconGithub />
                </a>
            </div>
        </div>
    </footer>
</template>