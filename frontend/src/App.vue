<script setup lang="ts">
import Base from '@/views/Base.vue'
import AlertMessage from './components/AlertMessage.vue';
</script>

<template>
  <component :is="Base"></component>
  <AlertMessage />
</template>
