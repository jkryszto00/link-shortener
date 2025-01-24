<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps<{
    link?: object;
    statistics?: {
        total_clicks: number;
        clicks_by_period: {
            today: number;
            last_7_days: number;
            last_30_days: number;
        };
        clicks_by_country: Array<{country: string, click_count: number}>;
        clicks_by_device: Array<{device_type: string, click_count: number}>;
        clicks_by_browser: Array<{browser: string, browser_version: string, click_count: number}>;
    };
}>();
</script>

<template>
    <Head title="Link Statistics" />

    <AuthenticatedLayout>
        <template #header>
            <div class="w-full inline-flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ link.title }}
                </h2>

                <Link :href="route('links.edit', link.id)">
                    <PrimaryButton>Edit link</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Total Clicks Card -->
                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Total Clicks</h3>
                        <div class="text-3xl font-bold">{{ statistics.total_clicks }}</div>
                    </div>
                </div>

                <!-- Period Statistics -->
                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Click Periods</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <div class="text-gray-500">Today</div>
                                <div class="text-xl font-bold">{{ statistics.clicks_by_period.today }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Last 7 Days</div>
                                <div class="text-xl font-bold">{{ statistics.clicks_by_period.last_7_days }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Last 30 Days</div>
                                <div class="text-xl font-bold">{{ statistics.clicks_by_period.last_30_days }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Country Statistics -->
                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Clicks by Country</h3>
                        <table class="w-full">
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

                <!-- Device and Browser Statistics -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Clicks by Device</h3>
                            <table class="w-full">
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

                    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Clicks by Browser</h3>
                            <table class="w-full">
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
    </AuthenticatedLayout>
</template>
