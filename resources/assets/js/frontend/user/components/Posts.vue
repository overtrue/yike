<template>
  <div class="user-articles row">
    <div class="container">
      <div class="col-md-12 offset-md-2">
        <div class="card" v-for="post in posts">
          <img class="card-img-top" :src="post.cover" :alt="post.title">
          <div class="card-block">
            <div class="card-title">{{ post.title }}</div>
            <div class="extras">
              <img class="avatar img-circle" :src="post.user.data.avatar">
              <div class="user-info">
                <span class="username">{{ post.user.data.username }}</span>
                <span class="times">{{ post.created_at.substr(5, 5) }}</span>
              </div>
              <div class="actions">
                <div class="favour">
                  <i class="fa fa-heart-o"></i>
                  <span v-text="post.vote_count"></span>
                </div>
                <div class="collect">
                  <i class="fa fa-bookmark-o"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions,mapGetters } from 'vuex'

export default {
  created() {
    this.loadIntervieweePosts()
  },
  computed: {
  ...mapGetters({
      posts: 'getIntervieweePosts'
    })
  },
  methods: {
    ...mapActions(['getIntervieweePosts', 'loadIntervieweePosts'])
  }
}
</script>

<style lang="scss" scoped>
  .user-articles {
    margin-bottom: 50px;
  }
  .card {
    width:32%;
    margin-right:.6666%;
    margin-left:.6666%;
    margin-top: 30px;
    display:inline-block;
  }
  .card-img-top {
    width: 100%;
    height: 160px;
  }
  .extras{
    margin-top: 15px;
    position: relative;

    img {
      float: left;
    }
    .avatar {
      width: 39px;
    }
    .actions {
      display: inline-block;
      font-size: 16px;
      position: absolute;
      bottom: 0;
      right: 0;

      .favour, .collect{
        position: relative;
        padding: 0 5px;
        cursor: pointer;
        display: inline-block;
        opacity: .6;

        span {
          font-size: 14px;
          font-weight: 200;
        }
      }
      .favour i {
        color: #7ED321;
      }
      .favour:not(:last-child):after {
        content: '';
        position: absolute;
        left: 100%;
        top: 50%;
        width: 1px;
        height: 1em;
        background-color: #2b445d;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        opacity: .1;
      }
    }
  }
  .extras .user-info {
    display: inline-block;
    margin-left: 10px;

    span {
      display: block;
      padding: 0;
      font-size: 13px;
      font-weight: 200;
    }
    .times {
      font-size: 11px;
    }
  }
  .card-block {
    padding: 1rem;
  }
  .card {
    border-radius: 4px;
    background-color: #fff;
    border: 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);

    .card-title {
      font-size: 13px;
      font-weight: 400;
    }
    .card-body {
      font-size: 13px;
      font-weight: 200;
      padding: 10px;

      .content {
        margin-top: 8px;

        .user, .user-info {
          display: inline-block;
        }
        .user-info {
          padding-top: 8px;
        }
      }
    }
  }
</style>
