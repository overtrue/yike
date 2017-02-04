<template>
  <div class="post-show bg-white full-height">
    <navbar>
      <div class="page-actions" slot="page-actions" v-if="canEdit">
        <a href="#" class="nav-item text-success" @click="handleEdit()">编辑</a>
        <a href="#" class="nav-item text-danger" @click="handleDelete()">删除</a>
      </div>
    </navbar>
    <div class="post-cover" v-if="post.cover">
      <div id="post-cover-img"></div>
    </div>
    <div class="post-container">
      <div class="post-meta">
        <user :user="user"></user>
      </div>
      <div class="post-title">
        <h1>{{ post.title }}</h1>
      </div>
      <article class="post-body" v-html="post.content"></article>
      <div class="footer">
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "home/Navbar"
import User from "./components/User"
import { getData } from 'utils/get'
import { mapGetters } from "vuex"
import Prism from "../../plugins/prism"

require("clipboard")
require("./theme/github.css")
require("../../plugins/prism.css")

export default {
  name: 'post-show',
  components: { Navbar, User },
  data() {
    return {
      post: {},
      user: {}
    }
  },
  created() {
    this.loadPost(this.$route.params.slug)
  },
  mounted() {
    setTimeout(function(){
      Prism.highlightAll('.post-body');
    }, 500);
  },
  computed: {
    ...mapGetters(['currentUser']),
    canEdit: function() {
      return this.post.user_id == this.currentUser.id
    }
  },
  methods: {
    loadPost: function(slug) {
      this.$http.get(this.$config.entrypoints.posts + slug)
              .then((post) => {
                this.post = getData(post).data
                this.user = this.post.user.data
              }).catch(function(err){
                console.log(err)
              });
    },
    handleDelete() {
      console.log('deleting')
    },
    handleEdit() {
      this.$router.push({name: 'post.edit', params: {username: this.user.username, slug: this.post.slug}})
    }
  }
}
</script>

<style lang="scss">
  .post-title {
    margin-top: 30px;
    margin-bottom: 30px;

    h3 {
      font-weight: 300;
    }
  }
  .post-meta {
    padding: 50px 0 10px;
  }

  #post-cover-img {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0px;
    left: 0px;
    background: -moz-radial-gradient(center, ellipse cover, rgba(36,44,51,0) -1%, rgba(36,44,51,0.01) 0%, rgba(32,39,47,0.2) 22%, rgba(19,19,35,0.65) 100%);
    background: -webkit-radial-gradient(center, ellipse cover, rgba(36,44,51,0) -1%,rgba(36,44,51,0.01) 0%,rgba(32,39,47,0.2) 22%,rgba(19,19,35,0.65) 100%);
    background: radial-gradient(ellipse at center, rgba(36,44,51,0) -1%,rgba(36,44,51,0.01) 0%,rgba(32,39,47,0.2) 22%,rgba(19,19,35,0.65) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00242c33', endColorstr='#a6131323',GradientType=1 );
  }
  .post-cover {
    background-attachment: fixed;
    background-size: cover;
    background-position: 50% 100%;
    overflow: hidden;
    padding-top: 30px;
    -webkit-animation: article-bg 8s ease-in;
    -moz-animation: article-bg 8s ease-in;
    -o-animation: article-bg 8s ease-in;
    animation: article-bg 8s ease-in;
    position: relative;
    height: 500px;
    overflow: hidden;
  }
  @-webkit-keyframes article-bg {
    0%   { background-position: 50% 0%; }
    100% { background-position: 50% 100%; }
  }
  @-moz-keyframes article-bg {
    0%   { background-position: 50% 0%; }
    100% { background-position: 50% 100%; }
  }
  @-o-keyframes article-bg {
    0%   { background-position: 50% 0%; }
    100% { background-position: 50% 100%; }
  }
  @keyframes article-bg {
    0%   { background-position: 50% 0%; }
    100% { background-position: 50% 100%; }
  }
</style>
