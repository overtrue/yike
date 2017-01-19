<template>
  <div class="container-fulid">
    <div class="bitmap" v-if="post.cover">
      <div id="bitdim"></div>
    </div>
    <div class="row">
      <div class="col-md-8 offset-md-4">
        <div class="title">
          <h3>{{ post.title }}</h3>
        </div>
        <div class="content" v-html="post.content"></div>
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
export default {
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
  methods: {
    ...mapActions(['loadPost'])
  }
}
</script>

<style lang="scss" scoped>
  .row > div {
    display: block;
  }
  .title {
    margin-top: 30px;
    margin-bottom: 30px;

    h3 {
      font-weight: 300;
    }
  }
  .content {
    font-weight: 200;
    margin-bottom: 60px;
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
