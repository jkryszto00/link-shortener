<script setup>
import UrlShortener from '@/components/UrlShortener.vue'
import Guest from "@/layouts/Guest.vue";
import {useAuthStore} from "@/stores/auth.js";

const auth = useAuthStore()
</script>
<template>
    <Guest>
        <main class="max-w-4xl mx-auto py-12 px-4">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-200 mb-4">
                    Skróć swój link w prosty sposób
                </h1>
                <p class="text-gray-600">
                    Wklej długi URL i otrzymaj jego krótką wersję
                </p>
            </div>

            <UrlShortener />

            <div class="text-center">
                <RouterLink
                    v-if="auth.isAuthenticated"
                    to="/dashboard"
                    class="text-sm text-gray-500 font-medium hover:underline"
                >
                    Go to dashboard page
                </RouterLink>
                <RouterLink
                    v-else
                    to="/login"
                    class="text-sm text-gray-500 font-medium hover:underline"
                >
                    Go to login page
                </RouterLink>
            </div>
        </main>
    </Guest>
</template>
