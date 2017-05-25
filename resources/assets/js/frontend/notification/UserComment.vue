<template>
  <div class="d-flex justify-content-between">
    <div class="content">
      <router-link :to="notification.data.user.username">
        <img class="rounded-circle mr-2" width="30" :src="notification.data.user.avatar">
        {{ notification.data.user.name }}
      </router-link>
      <span class="mx-2" style="color: #888;">评论了你的文章 <router-link :to="url">《{{ notification.data.post.title }}》</router-link></span>
    </div>
    <div class="date">{{ notification.created_at }}</div>
  </div>
</template>

<script>
export default {
  props: {
    notification: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      url: this.notification.data.user.username + '/' + this.notification.data.post.slug + '#comment-' + this.notification.data.comment.id
    }
  },
}
</script>
