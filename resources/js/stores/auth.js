import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from "@/lib/axios.js";

export const useAuthStore = defineStore('auth', () => {
    // State
    const user = ref(null)

    // Getters
    const isAuthenticated = computed(() => !!user.value)
    const userEmail = computed(() => user.value?.email)

    // Actions
    const logout = async () => {
        try {
            await axios.post('/logout')
        } catch (error) {
            console.error('Logout error:', error)
        } finally {
            user.value = null
        }
    }

    const fetchUser = async () => {
        try {
            const response = await axios.get('/api/user')
            user.value = response.data
            return response.data
        } catch (error) {
            handleError(error)
            throw error
        }
    }

    const updateProfile = async (profileData) => {
        try {
            const response = await axios.put('/api/auth/profile', profileData)
            user.value = response.data
            return response.data
        } catch (error) {
            handleError(error)
            throw error
        }
    }

    const resetPassword = async (email) => {
        try {
            await axios.post('/api/auth/reset-password', { email })
        } catch (error) {
            handleError(error)
            throw error
        }
    }

    // Helper functions
    const clearAuth = () => {
        user.value = null
        token.value = null
        localStorage.removeItem('token')
        delete axios.defaults.headers.common['Authorization']
    }

    const handleError = (error) => {
        if (error.response?.status === 401) {
            clearAuth()
        }
    }

    // Initialize
    const initialize = async () => {
        if (token.value) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
            try {
                await fetchUser()
            } catch (error) {
                clearAuth()
            }
        }
    }

    return {
        // State
        user,

        // Getters
        isAuthenticated,
        userEmail,

        // Actions
        logout,
        fetchUser,
        updateProfile,
        resetPassword,
        initialize
    }
}, {
    persist: true
})
