<template>
  <div>
    <h1>Ad List</h1>
    <ul>
      <li v-for="ad in ads" :key="ad.id">
        <h2>{{ ad.title }}</h2>
        <img :src="ad.main_image" alt="Ad image">
        <p>{{ ad.price }}</p>
      </li>
    </ul>
    <button @click="fetchAds(page - 1)" :disabled="page <= 1">Previous</button>
    <button @click="fetchAds(page + 1)" :disabled="!hasMore">Next</button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      ads: [],
      page: 1,
      hasMore: true,
    };
  },
  methods: {
    async fetchAds(page = 1) {
      try {
        const response = await axios.get(`/api/ads?page=${page}`);
        this.ads = response.data.data;
        this.page = page;
        this.hasMore = response.data.next_page_url !== null;
      } catch (error) {
        console.error('Failed to fetch ads:', error);
      }
    }
  },
  mounted() {
    this.fetchAds();
  }
};
</script>
