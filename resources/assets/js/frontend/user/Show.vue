<template>
  <div class="user-show">
    <navbar></navbar>
    <div class="wrapper">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="user-info d-flex justify-content-start">
              <div class="user-avatar"><avatar :user="user" size="large"></avatar></div>
              <div class="user-info">
                <h3 class="username">{{ user.name }}</h3>
                <p class="description">{{ user.signature }}</p>
                <div class="place">
                  北京
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-github"></i></a>
                    <a href=""><i class="fa fa-skype"></i></a>
                  </div>
                </div>
              </div>
              <div class="ml-auto text-right">
                <a href="#" class="btn btn-outline-primary">关注</a>
              </div>
            </div>
            <div class="post-menus mt-5 pt-3">
              <div class="d-flex justify-content-center">
                <a  href="#" @click="loadPosts('hot')" :class="{active: sortBy == 'hot'}">热门</a>
                <a href="#" @click="loadPosts('latest')" :class="{active: sortBy == 'latest'}">最新</a>
                <a href="#" @click="loadPosts('featured')" :class="{active: sortBy == 'featured'}">置顶</a>
                <a href="#" @click="loadPosts('recommends')" :class="{active: sortBy == 'recommends'}">推荐</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-lg-10" v-for="post in posts">
          <post-card :post="post" class="mt-3"></post-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { http } from 'plugins/http'
import Navbar from 'home/Navbar'
import Avatar from 'home/Avatar'
import PostCard from "home/PostCard"

export default {
  name: 'user-show',
  components: { Navbar, Avatar, PostCard },
  data() {
    return {
      user: {},
      posts: [],
      sortBy: 'hot'
    }
  },
  created() {
    http.get(this.$endpoints.users+this.$route.params.username).then((data) => {
      this.user = data.data.data
    })

    this.loadPosts(this.sortBy)
  },
  methods: {
    loadPosts(sortBy) {
      this.sortBy = sortBy
      http.get(this.$endpoints.posts, {params:{user_id: this.user.id, sort_by: this.sortBy}}).then((data) => {
        this.posts = data.data.data
      })
    }
  }
}
</script>

<style lang="scss" scoped>
  .user-show {
    padding-bottom: 50px;
  }
  .wrapper {
    background-color: #fff;
    padding: 40px 0 20px;
  }
  .user-info {
    padding-left: 20px;

    .username {
      margin:10px 0 20px;
    }
  }
  .post-menus {
    border-top: 1px solid #eee;
    a {
      font-size: 16px;
      padding: 0 20px;
      color: #ccc;

      &.active {
        color: #444;
      }
    }
  }
  .social {
    display: inline-block;
    margin-left: 20px;

    a {
      font-size: 18px;
      margin-right: 10px;
    }
  }
</style>

