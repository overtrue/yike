<template>
  <div class="series-list">
    <navbar></navbar>
    <div class="container pt-3">
      <div class="row">
        <template v-for="item in series">
          <router-link :to="{ name: 'series.show', params: { slug: item.slug } }" class="card col-md-5 mx-2">
            <div class="d-flex align-items-center card-block">
              <img :src="item.image_url" class="rounded-circle mr-3">
              <div class="content">
                <h3 class="card-title">{{ item.title }}</h3>
                <p class="card-text">{{ item.description | filterDescription }}</p>
              </div>
            </div>
          </router-link>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from 'home/Navbar'

export default {
  components: { Navbar },
  data() {
    return {
      series: [],
    }
  },
  created() {
    this.loadSeries()
  },
  filters: {
    filterDescription(value) {
      return value.slice(0, 20) + (value.length > 20 ? '...' : '')
    },
  },
  methods: {
    loadSeries() {
      this.$http.get(this.$endpoints.series)
          .then((response) => {
            this.series = response.data.data
          })
    },
  }
}
</script>

<style lang="scss" scoped>
.card {
  img {
    display: block;
    width: 60px;
    height: 60px;
  }
  .card-text {
    font-size: 14px;
  }
}
</style>
