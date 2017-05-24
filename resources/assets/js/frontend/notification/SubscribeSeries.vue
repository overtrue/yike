<template>
  <div class="d-flex justify-content-between">
    <div class="content">
      <router-link :to="notification.data.user.username">
        <img class="rounded-circle mr-2" width="30" :src="notification.data.user.avatar">
        {{ notification.data.user.name }}
      </router-link>
      <span class="mx-2" style="color: #888;">订阅了你的专栏 <router-link :to="'series/' + notification.data.series.slug">《{{ notification.data.series.title }}》</router-link></span>
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
