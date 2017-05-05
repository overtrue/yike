<template>
  <div class="home">
    <navbar></navbar>
    <!-- Banner -->
    <div class="banner">
      <carousel :interval="4000" indicator-position="none" @change="changeCarousel" type="card" height="260px" v-if="banners.length > 0">
        <carousel-item v-for="(banner, index) in banners" :key="banner.id">
          <router-link :to="banner.link" v-if="currentCarousel == index">
            <h3><img :src="banner.image.data.url" alt="banner.image.data.title"></h3>
          </router-link>
          <h3 v-else><img :src="banner.image.data.url" alt="banner.image.data.title"></h3>
        </carousel-item>
      </carousel>
    </div>
    <div class="container pt-3">
      <div class="row">
        <div class="col-md-12">
          <div class="post-box">
            <!-- Host Post -->
            <div class="box-title">
              <h5>热门文章</h5>
            </div>
            <div class="row" v-for="items in posts">
              <div class="card col-md-5 mx-2 px-0" v-for="post in items">
                <router-link :to="post.url" class="card-img-top">
                  <img :src="post.cover" :alt="post.title">
                </router-link>
                <div class="card-block">
                  <router-link :to="post.url" class="card-title" v-text="post.title"></router-link>
                  <div class="extras">
                    <router-link :to="post.user.data.username"><img class="avatar" :src="post.user.data.avatar"></router-link>
                    <div class="user-info">
                      <span class="username" v-text="post.user.data.name"></span>
                      <relative-time class="times" :datetime="post.created_at" v-text="post.created_at"></relative-time>
                    </div>
                    <div class="actions">
                      <icon-button :item="post" api="post" show-statistics></icon-button>
                      <icon-button
                        :item="post"
                        api="post"
                        type="favorite"
                        :icons="{positive: 'turned_in', negative: 'turned_in_not'}"
                        button-class="collect"></icon-button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <!-- Ranking -->
          <div class="ranking">
            <div class="box-title">
              <h5>排行榜</h5>
            </div>
            <ol>
              <li v-for="user in ranks">
                <img class="avatar" :src="user.avatar">
                <router-link :to="{ name:'user.show', params: { username: user.username }}">
                  {{ user.username }}
                </router-link>
                <span class="float-right">{{ user.credit_count }}</span>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Carousel from "home/Carousel"
import CarouselItem from "home/CarouselItem"
import RelativeTime from "home/RelativeTime"
import "element-ui/lib/theme-default/carousel.css"
import "element-ui/lib/theme-default/carousel-item.css"
import Navbar from "home/Navbar"
import IconButton from "home/IconButton"

export default {
  name: 'home',
  components: {
    Navbar,
    Carousel,
    CarouselItem,
    RelativeTime,
    IconButton,
  },
  data() {
    return {
      banners: [],
      ranks: [],
      posts: [],
      currentCarousel: 0,
    }
  },
  methods: {
    loadBanners() {
      let vm = this
      this.$http.get(this.$endpoints.banners).then((response) => {
        vm.banners = response.data.data
      })
    },
    loadRanks() {
      this.$http.get(this.$endpoints.ranks).then((response) => {
        this.ranks = response.data.data
      })
    },
    loadPosts() {
      this.$http.get(this.$endpoints.posts, { params: {sort_by: 'hot'} }).then((response) => {
        this.posts = this.list(response.data.data)
      })
    },
    list(list) {
      let items = []
      let index = 0
      let section = 3

      for (let i = 0; i < list.length; i++) {
        index = parseInt(i / section);
        if (items.length <= index) {
            items.push([])
        }
        items[index].push(list[i])
      }
      return items
    },
    changeCarousel(val, oldVal) {
      this.currentCarousel = val
    }
  },
  created() {
    this.loadBanners()
    this.loadPosts()
    this.loadRanks()
  }
}
</script>

<style lang="scss" scoped>
.banner {
  margin-top: 5px;
}
.el-carousel__item h3 {
  color: #475669;
  font-size: 14px;
  opacity: 0.75;
  line-height: 260px;
  margin: 0;
  text-align: center;

  img {
    width: 100%;
  }
}
.el-carousel__item:nth-child(2n) {
  background-color: #99a9bf;
}
.el-carousel__item:nth-child(2n+1) {
  background-color: #d3dce6;
}
.box-title {
  margin-top: 20px;
  margin-bottom: 20px;
}
.post-box {
  margin-bottom: 30px;
  padding-bottom: 50px;
  border-bottom: 1px solid rgba(49, 43, 43, 0.04);
}
.card-title {
  color: #464a4c;
}
.ranking {
  margin-left: 10px;

  ol {
    font-size: 14px;
    padding-left: 30px;

    li {
      margin-bottom:10px;
      color:#666
    }
  }
  .avatar {
    width: 30px;
    margin-left: 5px;
    margin-right: 10px;
  }
}
</style>
