<script setup>
import { useAuthStore } from '@/stores/auth'

const store = useAuthStore()
</script>
<template>
  <router-view v-slot="{ Component, route }">
    <div :key="route.name">
      <Component :is="Component" />
    </div>
  </router-view>
</template>
