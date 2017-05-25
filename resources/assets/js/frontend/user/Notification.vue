<template>
  <div class="container">
    <navbar></navbar>
    <div class="notification px-4 pt-1 pb-3 my-4">
      <div class="readable clearfix mb-3 py-2">
        <button class="btn btn-sm btn-outline-primary float-right" @click="markAllRead">全部标记为已读</button>
      </div>
      <ul class="notification-list pl-0 mb-0">
        <template v-if="notifications.length > 0">
          <li class="mb-4" v-for="(notification, index) in notifications" :class="{read: notification.read_at}" @click="markOneRead(notification, index)">
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
import { mapActions, mapGetters } from 'vuex'
import Navbar from 'home/Navbar'
import LikePost from 'app/notification/LikePost'
import UserFollow from 'app/notification/UserFollow'
import UserComment from 'app/notification/UserComment'
import PublishPost from 'app/notification/PublishPost'
import FavoritePost from 'app/notification/FavoritePost'
import SubscribeSeries from 'app/notification/SubscribeSeries'

export default {
  components: {
    Navbar,
    UserFollow,
    LikePost,
    FavoritePost,
    SubscribeSeries,
    UserComment,
    PublishPost,
  },
  data() {
    return {
      notifications: [],
      readApi: this.$endpoints.me + 'notifications/read',
    }
  },
  computed: {
    ...mapGetters(['currentUser']),
  },
  created() {
    this.loadNotifications()
  },
  methods: {
    ...mapActions(['markAllAsRead', 'markOneAsRead']),
    markOneRead(item, index) {
      if (item.read_at == null) {
        this.$http.post(this.readApi + '/' + item.id)
            .then(() => {
              this.notifications[index].read_at = new Date()
              this.markOneAsRead()
            })
      }
    },
    markAllRead() {
      if (this.currentUser.unread_count) {
        this.$http.post(this.readApi)
            .then(() => {
              this.markAllAsRead()
              this.loadNotifications()
            })
      }
    },
    loadNotifications() {
      this.$http.get(this.$endpoints.me + 'notifications')
          .then((response) => {
            this.notifications = response.data.data
          })
    }
  }
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
.read {
  color: #888;
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
