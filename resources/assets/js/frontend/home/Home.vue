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
                      <div class="favour">
                        <i class="material-icons">favorite_border</i>
                        <span>123</span>
                      </div>
                      <div class="collect">
                        <i class="material-icons">turned_in_not</i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Weekly Host Post -->
          <div class="post-box">
            <div class="box-title">
              <h5>本周热门</h5>
            </div>
            <div class="card-deck">
              <div class="card" v-for="n in 3">
                <div class="card-img-top">
                  <img src="https://dn-phphub.qbox.me/uploads/banners/Ltw9l2xdkQX2gEv63sUG.jpg?imageView2/1/w/424/h/212" alt="">
                </div>
                <div class="card-block">
                  <div class="card-title">This is a test</div>
                  <div class="extras">
                    <img class="avatar" src="https://pigjian.com/images/default_avatar.png">
                    <div class="user-info">
                      <span class="username">Jiajian Chan</span>
                      <span class="times">3 minute ago</span>
                    </div>
                    <div class="actions">
                      <div class="favour">
                        <i class="material-icons">favorite_border</i>
                        <span>123</span>
                      </div>
                      <div class="collect">
                        <i class="material-icons">turned_in_not</i>
                      </div>
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
              <li v-for="n in 10">
                <img class="avatar" src="https://pigjian.com/images/default_avatar.png">
                <a href="/u/xiaoming_5835ca0462b83">
                  Jiajian Chan
                </a>
                <span class="float-right">+62</span>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Carousel from '../components/Carousel'
import CarouselItem from '../components/CarouselItem'
import RelativeTime from "home/RelativeTime"
import 'element-ui/lib/theme-default/carousel.css'
import 'element-ui/lib/theme-default/carousel-item.css'
import Navbar from "home/Navbar"

export default {
  name: 'home',
  components: {
    Navbar,
    Carousel,
    CarouselItem,
    RelativeTime,
  },
  data() {
    return {
      banners: [],
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
