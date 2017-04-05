<template>
  <div class="series-show">
    <navbar></navbar>
    <div class="wrapper">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 offset-lg-1">
            <div class="text-center py-2">
              <img :src="series.image_url" alt="" width="100" height="100" class="avatar">
            </div>
          </div>
          <div class="col-lg-9">
            <div class="user-info">
              <h3 class="username">{{ series.title }} <follow-button :item="series" api="series"></follow-button></h3>
              <p class="description" v-text="series.description"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-10 offset-lg-1">
          <template v-if="posts.length > 0">
            <post-card v-for="post in posts" :key="post.id" :post="post" class="mt-3"></post-card>
          </template>
          <template v-else>
            <h4 class="text-center mt-4">该专栏没有文章</h4>
          </template>
        </div>
        <div class="col-lg-4">
          <section class="section mt-3 p-2">
            <div class="title">专栏统计</div>
            <p><small>关注数：</small>{{ series.follower_cache }}</p>
            <p><small>文章数：</small>{{ series.post_cache }}</p>
          </section>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from 'home/Navbar'
import PostCard from 'home/PostCard'
import { getData } from 'utils/get'
import FollowButton from 'home/FollowButton'

export default {
  components: { Navbar, PostCard, FollowButton },
  data() {
    return {
      series: {},
      posts: [],
    }
  },
  created() {
    this.loadSeries(this.$route.params.slug)
  },
  methods: {
    loadSeries(slug) {
      let query = Object.assign({})

      query['include'] = 'posts'

      this.$http.get(this.$endpoints.series + slug, { params: query }).then((series) => {
        this.series = getData(series).data
        this.posts = this.series.posts.data
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.series-show {
  padding-bottom: 50px;
}
.wrapper {
  background-color: #fff;
  padding: 40px 0 20px;
}
h4 {
  color: #ccc;
}
.section {
  background-color: #fff;
  box-shadow: 0 1px 2px 0 rgba(0,0,0,.05);
  border-radius: 2px;
  margin-bottom: 1.3rem;
  font-size: 1.16rem;
  line-height: 1.29;
  color: #333;

  .title {
    font-size: 16px;
    border-bottom: 1px solid #f8f8f8;
    padding: 5px;
  }
  p {
    font-size: 16px;
    margin: 10px 5px;
  }
}
</style>
