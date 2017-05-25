<template>
  <div class="d-flex justify-content-between">
    <div class="content">
      <span class="ml-2">你关注的用户 <router-link :to="notification.data.user.username">{{ notification.data.user.name }}</router-link> </span>
      <span class="mr-2" style="color: #888;">发布了新文章 <router-link :to="notification.data.user.username + '/' + notification.data.post.slug">《{{ notification.data.post.title }}》</router-link></span>
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
  }
}
</script>
