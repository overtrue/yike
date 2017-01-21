<template>
  <div class="post-show">
    <navbar></navbar>
    <div class="container-fulid">
      <div class="bitmap" v-if="post.cover">
        <div id="bitdim"></div>
      </div>
      <div class="post-container">
        <div class="title">
          <h1>{{ post.title }}</h1>
        </div>
        <article class="post-body" v-html="post.content"></article>
        <div class="footer">
          <div class="user">
            <div class="info-left">
              <img class="avatar img-circle" width="60" :src="user.avatar">
            </div>
            <div class="info">
              <p class="username" v-text="user.name"></p>
              <p class="description" v-text="user.signature"></p>
            </div>
            <button class="follow btn btn-outline-secondary btn-sm">关注</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Navbar from "home/Navbar"

require("clipboard")
require("./theme/github.css")
import Prism from "../../plugins/prism"
require("../../plugins/prism.css")

export default {
  name: 'post-show',
  components: { Navbar },
  data() {
    return {
      post: {},
      user: {}
    }
  },
  created() {
    this.loadPost(this.$route.params.slug).then((post) => {
      this.post = post, this.user = post.user.data
    });
  },
  mounted() {
    setTimeout(function(){
      Prism.highlightAll('.post-body');
    }, 500);
  },
  methods: {
    ...mapActions(['loadPost'])
  }
}
</script>

<style lang="scss">
  .title {
    margin-top: 30px;
    margin-bottom: 30px;

    h3 {
      font-weight: 300;
    }
  }
  .post-body {
    color: #333;
    margin-bottom: 60px;

    h1 {
      font-size: 48px;
      font-weight: 200;
    }

    h2 {
      font-size: 30px;
      font-weight: 400;
      margin-top: 55px;
      position: relative;

      &:first-of-type {
          margin-top: 15px;
      }
    }

    h3 {
      font-size: 24px;
      font-weight: 400;
      margin-top: 45px;
    }

    h4 {
      font-size: 16px;
      font-weight: 700;
      margin-top: 35px;
    }

    h5, h6 {
      font-size: 14px;
      font-weight: 700;
      margin-top: 35px;
    }
    p {
      font-size: 14.5px;
      line-height: 1.7;
    }
  }
  .footer {
    height: 80px;
    margin-bottom: 50px;
    border-top: 1px solid rgba(0, 0, 0, 0.04);
  }
  .user {
    position: relative;

    .info-left, .info {
      display: inline-block;
    }
    .info-left {
      position: absolute;
      left: 0;
      display: inline-block;
      margin: 10px 11px;
      line-height: 20px;
    }
    .info {
      position: absolute;
      left: 80px;
      display: inline-block;
      margin: 10px;
      height: 60px;
      line-height: 20px;

      p {
        margin: 9px 0;
      }
      .username {
        font-weight: 200;
      }
      .description {
        font-size: 12px;
        font-weight: 200;
      }
    }
    .follow {
      position: absolute;
      right: 0;
      top: 26.6667px;
    }
  }
  pre.code-toolbar > .toolbar a, pre.code-toolbar > .toolbar button, pre.code-toolbar > .toolbar span {
    border-radius: 1px;
    box-shadow: none;
    margin: 0 3px;
  }
  #bitdim {
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
  .bitmap {
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
