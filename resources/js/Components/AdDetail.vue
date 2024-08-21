<template>
    <div class="ad-detail">
      <div v-if="ad">
        <h1>{{ ad.title }}</h1>
        <img v-if="ad.main_image" :src="ad.main_image" alt="Main Image" class="main-image" />
        <p class="price">Price: ${{ ad.price }}</p>
        
        <div v-if="ad.description">
          <h3>Description</h3>
          <p>{{ ad.description }}</p>
        </div>
  
        <div v-if="ad.images && ad.images.length > 1">
          <h3>Additional Images</h3>
          <div class="additional-images">
            <img v-for="(image, index) in ad.images" :key="index" :src="image" alt="Additional Image" />
          </div>
        </div>
      </div>
      <div v-else>
        <p>Loading ad details...</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'AdDetail',
    data() {
      return {
        ad: null,
        fields: 'description,images',
      };
    },
    created() {
      this.fetchAdDetail();
    },
    methods: {
      async fetchAdDetail() {
        const adId = this.$route.params.id;
        try {
          const response = await axios.get(`http://localhost:8000/api/ads/${adId}`, {
            params: {
              fields: this.fields
            }
          });
          this.ad = response.data;
        } catch (error) {
          console.error('Failed to fetch ad details:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .ad-detail {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .main-image {
    width: 100%;
    height: auto;
    margin-bottom: 20px;
  }
  
  .price {
    font-size: 1.5em;
    color: #333;
    margin-bottom: 20px;
  }
  
  .additional-images {
    display: flex;
    flex-wrap: wrap;
  }
  
  .additional-images img {
    width: 100px;
    height: auto;
    margin-right: 10px;
    margin-bottom: 10px;
  }
  </style>
  