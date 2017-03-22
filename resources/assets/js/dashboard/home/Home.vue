<template>
  <div class="container">
    <div class="row pt-4">
      <div class="col-sm-4" v-for="card in cards">
        <card :icon="card.icon" :total="card.total" :description="card.description"></card>
      </div>
    </div>
  </div>
</template>

<script>
import Card from 'dashboard/components/Card'

export default {
  components: { Card },
  data() {
    return {
      cards: {
        user: { icon: 'people', total: 0, description: 'users' },
        post: { icon: 'description', total: 0, description: 'posts' },
        series: { icon: 'featured_play_list', total: 0, description: 'series' },
        tag: { icon: 'label', total: 0, description: 'tags' },
      },
    }
  },
  created() {
    this.$http.get(this.$endpoints.statistics)
        .then((response) => {
          this.cards.user.total = response.data.users
          this.cards.post.total = response.data.posts
          this.cards.series.total = response.data.series
          this.cards.tag.total = response.data.tags
        })
  },
}
</script>
