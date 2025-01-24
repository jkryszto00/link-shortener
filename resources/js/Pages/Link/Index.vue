<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import CopyButton from "@/Components/CopyButton.vue";

defineProps<{
    links?: object;
}>();
</script>

<template>
    <Head title="Links" />

    <AuthenticatedLayout>
        <template #header>
            <div class="w-full inline-flex items-center justify-between">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Links
                </h2>

                <Link :href="route('links.create')">
                    <PrimaryButton>
                        Create link
                    </PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl space-y-4 sm:px-6 lg:px-8">
                <template v-for="link in links">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div class="w-full inline-flex items-center justify-between">
                                <div>
                                    <Link :href="route('links.show', link.id)" class="text-xl font-bold">{{ link.title }}</Link>
                                    <div>
                                        <div><a :href="link.short_code.url" target="_blank" class="font-bold text-indigo-700 hover:underline">{{ link.short_code.code }}</a></div>
                                        <div><a :href="link.url" target="_blank" class="hover:underline">{{ link.url }}</a></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="inline-flex items-center gap-x-6">
                                        <CopyButton :url="link.short_code.url" />
                                        <Link :href="route('links.show', link.id)">
                                            <SecondaryButton>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                View details
                                            </SecondaryButton>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Created: </span>
                                    <span class="text-sm">{{ link.created_at.human_diff }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
