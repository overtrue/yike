<template>
  <div class="post-card">
    <div class="card card-block">
      <div class="author">
        <div class="user-panel d-flex">
          <div class="left">
            <a :href="user.url"><avatar :user="user" size="xxs"></avatar></a>
          </div>
          <div class="post-meta-heading pl-2">
            <a :href="user.url" class="author" v-text="user.name"></a>
            <div><small><relative-time :datetime="post.created_at"></relative-time></small></div>
          </div>
        </div>
      </div>
      <div class="post">
        <div class="post-title">
          <router-link :to="post.url"><img v-if="post.cover" :src="post.cover" :alt="post.title" class="post-cover-img w-100"></router-link>
          <router-link :to="post.url"><h2 v-text="post.title" class="mt-2"></h2></router-link>
        </div>
      </div>
      <div class="post-actions d-flex pt-2">
        <div class="left-actions"></div>
        <div class="right-actions text-right"></div>
      </div>
    </div>
  </div>
</template>

<script>
import Avatar from "home/Avatar"
import RelativeTime from "home/RelativeTime"

export default {
  components: { Avatar, RelativeTime },
  props: {
    post: {
      type: Object
    }
  },
  computed: {
    user: function() {
      return this.post.creator.data
    }
  }
}
</script>

<style lang="scss" scoped>
  .post-meta-heading {
    line-height: 1.3;
    font-weight: 300;
  }
  .post-title, .post-title a {
    color: #4a4a4a;
  }
</style>
