<template>
  <div class="user-panel d-flex">
    <div class="left avatar-box">
      <a :href="user.url"><avatar :user="user" size="medium"></avatar></a>
    </div>
    <div class="right">
      <a :href="user.url"><h4 class="username" v-text="user.name"></h4></a>
      <div class="description" v-text="user.signature"></div>
    </div>
    <button class="follow btn btn-outline-primary btn-sm">关注</button>
  </div>
</template>

<script>
import Avatar from "home/Avatar"

export default {
  components: { Avatar },
  props: {
    user: {
      type: Object
    }
  }
}
</script>

<style lang="scss" scoped>
  .user-panel {
    position: relative;

    .avatar-box {
      margin-right: 10px;
    }

    .username {
      font-weight: 400;
    }

    .follow {
      position: absolute;
      right: 0;
      top: 26.6667px;
    }
  }
</style>
