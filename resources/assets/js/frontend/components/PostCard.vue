<template>
  <div class="post-card">
    <div class="card card-block">
      <div class="author">
        <div class="user-panel d-flex">
          <div class="left">
            <a :href="user.url"><avatar :user="user"></avatar></a>
          </div>
          <div class="post-meta-heading pl-2">
            <a :href="user.url" class="author" v-text="user.name"></a>
            <div class="post-published-at small text-gray-lighter" v-text="post.created_at"></div>
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
export default {
  components: { Avatar },
  props: {
    post: {
      type: Object
    }
  },
  computed: {
    user: function() {
      return this.post.user.data
    }
  }
}
</script>

<style lang="scss" scoped>
  .post-meta-heading {
    line-height: 1.3;
    font-weight: 300;
  }
</style>
