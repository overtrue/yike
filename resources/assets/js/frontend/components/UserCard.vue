<template>
  <div class="user-card d-flex justify-content-between">
    <div class="user-info d-flex">
      <div class="left avatar-box">
        <a :href="user.url"><avatar :user="user" size="sm"></avatar></a>
      </div>
      <div class="right">
        <a :href="user.url">
          <h5 class="username" v-text="user.name"></h5>
        </a>
        <div class="description" v-text="user.signature"></div>
      </div>
    </div>
    <div class="user-card-actions d-flex justify-content-end align-items-center">
      <follow-button :item="user"></follow-button>
    </div>
  </div>
</template>

<script>
import Avatar from "home/Avatar"
import FollowButton from "home/FollowButton"

export default {
  components: { Avatar, FollowButton },
  props: {
    user: {
      type: Object
    }
  }
}
</script>

<style lang="scss" scoped>
  .user-card {
    padding: 20px;

    .avatar-box {
      margin-right: 10px;
    }

    .username {
      font-weight: 400;
    }
  }
</style>
