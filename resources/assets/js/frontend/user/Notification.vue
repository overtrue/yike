<template>
  <div class="container">
    <navbar></navbar>
    <div class="notification px-4 pt-1 pb-3 my-4">
      <div class="readable clearfix mb-3 py-2">
        <button class="btn btn-sm btn-outline-primary float-right">全部标记为已读</button>
      </div>
      <ul class="notification-list pl-0 mb-0">
        <template v-if="notifications.length > 0">
          <li class="mb-4" v-for="notification in notifications">
            <keep-alive>
              <component :is="notification.type.split('_').join('-')" :notification="notification"></component>
            </keep-alive>
          </li>
        </template>
        <h6 v-else class="text-center">无新的通知</h6>
      </ul>
    </div>
  </div>
</template>

<script>
import Navbar from 'home/Navbar'
import UserFollow from 'app/notification/UserFollow'
import LikePost from 'app/notification/LikePost'
import FavoritePost from 'app/notification/FavoritePost'
import SubscribeSeries from 'app/notification/SubscribeSeries'

export default {
  components: {
    Navbar,
    UserFollow,
    LikePost,
    FavoritePost,
    SubscribeSeries,
  },
  data() {
    return {
      notifications: []
    }
  },
  created() {
    this.$http.get(this.$endpoints.me + 'notifications')
        .then((response) => {
          this.notifications = response.data.data
        })
  },
}
</script>

<style lang="scss" scoped>
h6 {
  color: #999;
}
.notification {
  width: 767px;
  margin: 0 auto;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
}
.readable {
  border-bottom: 1px solid #f8f8f8;
}
ul.notification-list {
  font-size: .8rem;
  line-height: 30px;

  li {
    list-style: none;

    .content a {
      color: #666;
      font-size: .9rem;
      font-weight: 500;
    }

    &:last-child {
      margin-bottom: 0 !important;
    }
  }
}
</style>
