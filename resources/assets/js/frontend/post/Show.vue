<template>
  <div class="post-show bg-white">
    <navbar :toleranceOffset="320">
      <div class="page-actions" slot="page-actions" v-if="canEdit">
        <a href="#" class="nav-item text-success" @click="handleEdit()">编辑</a>
        <a href="#" class="nav-item text-danger" @click="handleDelete()">删除</a>
      </div>
    </navbar>
    <div class="post-cover" v-if="post.cover">
      <image-box :src="post.cover" :alt="post.title" @loadFail="post.cover=null"></image-box>
    </div>
    <div class="bg-white" :class="{'with-cover': post.cover}">
      <div class="w760">
        <article class="post-container">
          <header>
            <div class="post-title">
              <h1>{{ post.title }}</h1>
            </div>
            <div class="post-meta">
              <div class="user-panel d-flex">
                <div class="avatar-box">
                  <a :href="user.url"><avatar :user="user" size="xs"></avatar></a>
                </div>
                <div class="d-flex flex-column justify-content-around">
                  <div class="author">
                    <a :href="user.url">
                      <h5 class="username d-inline-block" v-text="user.name"></h5>
                    </a>
                    <follow-button :item="user" class="d-inline-block btn-xs"></follow-button>
                  </div>
                  <div><small><relative-time :datetime="post.created_at" v-text="post.created_at"></relative-time></small></div>
                </div>
              </div>
            </div>
          </header><!-- /header -->
          <section class="post-body" v-html="post.content"></section>
        </article>
        <div class="footer">
          <div class="post-actions">
            <div class="d-flex justify-content-between">
              <div class="left-actions">
                <a href="#" class=""><i class="material-icons">favorite</i> 0</a>
              </div>
              <div class="right-actions d-flex justify-content-end">
                <a href="#"><i class="material-icons">share</i> 分享</a>
                <a href="#"><i class="material-icons">report</i> 举报</a>
              </div>
            </div>
          </div>
          <div class="post-author">
            <user-card :user="user"></user-card>
          </div>
        </div>
        <comment-list :list="comments"></comment-list>
      </div>
    </div>
    <back-top></back-top>
  </div>
</template>

<script>
import FollowButton from "home/FollowButton"
import Navbar from "home/Navbar"
import Avatar from "home/Avatar"
import UserCard from "home/UserCard"
import ImageBox from "home/ImageBox"
import RelativeTime from "home/RelativeTime"
import { getData } from 'utils/get'
import { mapGetters } from "vuex"
import Prism from "../../plugins/prism"
import CommentList from "./comment/List"
import Emojione from "emojione"
import BackTop from "home/BackTop"

require("clipboard")
require("./theme/github.css")
require("../../plugins/prism.css")

export default {
  name: 'post-show',
  components: { Navbar, Avatar, ImageBox, FollowButton, UserCard, RelativeTime, CommentList, BackTop },
  data() {
    return {
      post: {},
      user: {},
      comments: []
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
      return this.currentUser.is_admin || this.post.user_id == this.currentUser.id
    }
  },
  methods: {
    loadPost: function(slug) {
      let that = this
      this.$http.get(this.$endpoints.posts + slug + '?include=comments')
              .then((post) => {
                this.post = getData(post).data
                this.post.content = Emojione.shortnameToUnicode(this.post.content)
                this.user = this.post.user.data
                this.comments = this.post.comments.data

                this.$nextTick(() => {
                  if (window.location.hash) {
                    setTimeout(function () {
                      $('html,body').animate({
                        scrollTop: that.getElementTop(document.querySelector(window.location.hash))
                      }, 1500)
                    }, 500);
                  }
                })
              }).catch(function(err){
                console.log(err)
              });
    },
    handleDelete() {
      console.log('deleting')
    },
    handleEdit() {
      this.$router.push({name: 'post.edit', params: {username: this.user.username, slug: this.post.slug}})
    },
    getElementTop(element){
      let actualTop = element.offsetTop;
      let current = element.offsetParent;
      let elementScrollTop = 0

      while (current !== null){
      　actualTop += current.offsetTop;
      　current = current.offsetParent;
      }

      elementScrollTop = document.compatMode == 'BackCompat'
                          ? document.body.scrollTop
                          : document.documentElement.scrollTop;

      return actualTop-elementScrollTop;
    }
  }
}
</script>

<style lang="scss" scoped>
$cover-height: 400px;

.post-show {

  .post-container {
    padding: 20px;
  }

  .post-title {
    margin-top: 30px;
    margin-bottom: 10px;

    h3 {
      font-weight: 300;
    }
  }

  .post-meta {
    padding: 25px 0 30px;
    vertical-align: middle;
    line-height:1;

    .username {
      margin:0;
    }
  }
  .with-cover {
    margin-top: $cover-height;
    position: relative;
    z-index: 2;
    height: 100%;
  }
  .post-actions {
    margin-top: 2em;
    padding: 20px;
    border-bottom: 1px solid rgba(0,0,0,.05);

    a {
      color: #444;
      padding: 0 10px;
    }

    i {
      font-size: 20px;
      line-height: 20px;
    }
  }

  .user-panel {
    position: relative;

    .avatar-box {
      margin-right: 10px;
    }

    .username {
      font-weight: 400;
    }

    .btn-follow {
      margin-left: .5em;
      vertical-align: text-bottom;
      font-size: 0.775em;
    }
  }

  .post-cover {
    width: 100%;
    height: $cover-height;
    position: fixed;
    top: 70px;
    z-index: 0;
    background-attachment: fixed;
    background-size: cover;
    background-position: 50% 100%;
    -webkit-animation: article-bg 8s ease-in;
    -moz-animation: article-bg 8s ease-in;
    -o-animation: article-bg 8s ease-in;
    animation: article-bg 8s ease-in;
    overflow: hidden;

    img {
      width: 100%;
    }
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

}

</style>
