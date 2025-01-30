import { defineStore } from 'pinia';
import axios from 'axios';

export const useLinksStore = defineStore('links', {
    state: () => ({
        links: [],
        currentLink: null,
        statistics: null,
        loading: false,
        error: null
    }),

    actions: {
        async fetchLinks() {
            try {
                this.loading = true;
                const response = await axios.get('/api/links');
                this.links = response.data.links;
            } catch (error) {
                this.error = error.message;
                console.error('Error fetching links:', error);
            } finally {
                this.loading = false;
            }
        },
        async fetchLink(id) {
            try {
                this.loading = true;
                const response = await axios.get(`/api/links/${id}`)

                this.currentLink = response.data.link;
                this.statistics = response.data.statistics;
            } catch (error) {
                this.error = error.message;
                console.error('Error fetching link details:', error);
            } finally {
                this.loading = false;
            }
        },
        clearCurrentLink() {
            this.currentLink = null;
            this.statistics = null;
            this.error = null;
        }
    }
});
