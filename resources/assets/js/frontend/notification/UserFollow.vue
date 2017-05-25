<template>
  <div class="d-flex justify-content-between">
    <div class="content">
      <router-link :to="notification.data.username">
        <img class="rounded-circle mr-2" width="30" :src="notification.data.avatar">
        {{ notification.data.name }}
      </router-link>
      <span class="mx-2" style="color: #888;">关注了你</span>
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
