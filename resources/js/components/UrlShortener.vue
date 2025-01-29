<script setup>
import { ref } from 'vue';
import LinksList from './LinksList.vue';
import { useUrlStore } from '@/stores/urls';

const store = useUrlStore();
const url = ref('');
const shortUrl = ref('');
const isLoading = ref(false);
const copied = ref(false);
const links = ref([]);

const shortenUrl = async () => {
    if (!url.value) return;

    isLoading.value = true;
    try {
        const result = await store.shortenUrl(url.value);
        shortUrl.value = result.shortUrl;
        links.value.unshift(result);
        url.value = '';
    } catch (error) {
        console.error('Error:', error);
    } finally {
        isLoading.value = false;
    }
};

const copyToClipboard = async () => {
    try {
        await navigator.clipboard.writeText(shortUrl.value);
        copied.value = true;
        setTimeout(() => copied.value = false, 2000);
    } catch (error) {
        console.error('Copy failed:', error);
    }
};
</script>

<template>
    <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Skracanie URL</h2>

        <form @submit.prevent="shortenUrl" class="mb-6">
            <div class="flex gap-2">
                <input
                    v-model="url"
                    type="url"
                    required
                    placeholder="Wklej długi URL tutaj..."
                    class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2"
                />
                <button
                    type="submit"
                    :disabled="isLoading"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50"
                >
                    {{ isLoading ? 'Skracanie...' : 'Skróć URL' }}
                </button>
            </div>
        </form>

        <div v-if="shortUrl" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md mb-6">
            <div class="flex items-center justify-between">
                <a :href="shortUrl" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ shortUrl }}
                </a>
                <button
                    @click="copyToClipboard"
                    class="text-sm px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded hover:bg-gray-300 dark:hover:bg-gray-500"
                >
                    {{ copied ? 'Skopiowano!' : 'Kopiuj' }}
                </button>
            </div>
        </div>

        <LinksList v-if="links.length" :links="links"/>
    </div>
</template>
