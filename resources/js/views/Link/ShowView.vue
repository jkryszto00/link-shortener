<script setup>
import PrimaryButton from "@/components/PrimaryButton.vue";
import Authenticated from "@/layouts/Authenticated.vue";
import { useLinksStore } from "@/stores/links";
import { onMounted, computed, onUnmounted } from "vue";
import { useRoute } from "vue-router";
import DoughnutChart from "@/components/Charts/DoughnutChart.vue";

const route = useRoute();
const linksStore = useLinksStore();

onMounted(async () => {
    await linksStore.fetchLink(route.params.id);
});

onUnmounted(() => {
    linksStore.clearCurrentLink();
});

const link = computed(() => linksStore.currentLink || {});
const statistics = computed(() => linksStore.statistics || {
    total_clicks: 0,
    clicks_by_period: { today: 0, last_7_days: 0, last_30_days: 0 },
    clicks_by_country: [],
    clicks_by_device: [],
    clicks_by_browser: []
});
</script>

<template>
    <Authenticated>
        <template #header>
            <div class="w-full inline-flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ link.title }}
                </h2>

                <RouterLink :to="`/links/${link.id}/edit`">
                    <PrimaryButton>Edit link</PrimaryButton>
                </RouterLink>
            </div>
        </template>

        <div v-if="linksStore.loading" class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center text-gray-800 dark:text-gray-200">Loading...</div>
            </div>
        </div>

        <div v-else-if="linksStore.error" class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-red-50 dark:bg-red-900 text-red-500 dark:text-red-200 p-4 rounded">{{ linksStore.error }}</div>
            </div>
        </div>

        <div v-else class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-200">Total Clicks</h3>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ statistics.total_clicks }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-200">Click Periods</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div v-for="(value, key) in statistics.clicks_by_period" :key="key">
                                <div class="text-gray-500 dark:text-gray-400">{{ key.replace('_', ' ') }}</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ value }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-200">Clicks by Country</h3>
                        <table class="w-full text-gray-900 dark:text-gray-200">
                            <thead>
                            <tr>
                                <th class="text-left">Country</th>
                                <th class="text-right">Clicks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="country in statistics.clicks_by_country" :key="country.country">
                                <td>{{ country.country || 'Unknown' }}</td>
                                <td class="text-right">{{ country.click_count }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-200">Clicks by Device</h3>
                            <table class="w-full text-gray-900 dark:text-gray-200">
                                <thead>
                                <tr>
                                    <th class="text-left">Device</th>
                                    <th class="text-right">Clicks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="device in statistics.clicks_by_device" :key="device.device_type">
                                    <td>{{ device.device_type || 'Unknown' }}</td>
                                    <td class="text-right">{{ device.click_count }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-200">Clicks by Browser</h3>
                            <table class="w-full text-gray-900 dark:text-gray-200">
                                <thead>
                                <tr>
                                    <th class="text-left">Browser</th>
                                    <th class="text-right">Clicks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="browser in statistics.clicks_by_browser" :key="`${browser.browser}-${browser.browser_version}`">
                                    <td>{{ browser.browser }} {{ browser.browser_version }}</td>
                                    <td class="text-right">{{ browser.click_count }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Authenticated>
</template>
