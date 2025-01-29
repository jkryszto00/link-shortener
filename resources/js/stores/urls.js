import { defineStore } from 'pinia'

export const useUrlStore = defineStore('urls', {
    state: () => ({
        urls: []
    }),

    actions: {
        async shortenUrl(url) {
            const response = await fetch('/api/shorten', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ url })
            })

            if (!response.ok) {
                throw new Error('Nie udało się skrócić URL')
            }

            const data = await response.json()
            this.urls.unshift(data)
            return data
        }
    }
})
