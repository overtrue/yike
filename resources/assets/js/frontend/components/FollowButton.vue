<template>
  <button v-if="enabled" class="btn-follow btn" :class="{'btn-outline-primary': !user.is_following, 'btn-primary': user.is_following}" @click="follow"><slot>{{ label }}</slot></button>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  computed: {
    ...mapGetters(['isLogged', 'currentUser']),
    enabled() {
      return !this.isLogged || this.currentUser.id != this.user.id
    },
    label() {
      return this.user.is_following ? '已关注' : '关注'
    }
  },
  methods: {
    follow() {
      if (!this.isLogged) {
        return this.$router.push({name: 'auth.signin', query: { redirect: window.location.href }})
      }
      this.$http.post(this.$endpoints.followers, {user_id: this.user.id}).then(() => {
        this.toggleStatus()
      }).catch(() => {
        this.$store.dispatch('setMessage', {type: 'error', message: ['操作失败！']})
      })
    },
    toggleStatus() {
      this.user.is_following = !this.user.is_following
    }
  }
}
</script>
