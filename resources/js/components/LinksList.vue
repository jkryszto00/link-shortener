<script setup>
defineProps({
    links: {
        type: Array,
        required: true
    }
})
</script>
<template>
    <div class="border-t pt-4">
        <h2 class="text-lg font-medium mb-4">Ostatnie linki</h2>
        <div class="space-y-3">
            <div
                v-for="link in links"
                :key="link.id"
                class="flex items-center justify-between py-2"
            >
                <div class="flex-1 min-w-0 mr-4">
                    <p class="text-sm text-gray-500 truncate">{{ link.originalUrl }}</p>
                    <a
                        :href="link.shortUrl"
                        target="_blank"
                        class="text-blue-600 hover:underline text-sm"
                    >
                        {{ link.shortUrl }}
                    </a>
                </div>
                <span class="text-sm text-gray-500">
                  {{ link.clicks }} kliknięć
                </span>
            </div>
        </div>
    </div>
</template>
