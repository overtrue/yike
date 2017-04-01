<template>
  <button v-if="enabled" class="btn-follow btn" :class="{'btn-outline-primary': !item.is_following, 'btn-primary': item.is_following}" @click="follow"><slot>{{ label }}</slot></button>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  props: {
    item: {
      type: Object,
      required: true
    },
    api: {
      type: String,
      default: ''
    },
  },
  computed: {
    ...mapGetters(['isLogged', 'currentUser']),
    enabled() {
      return !this.isLogged || this.currentUser.id != this.item.id
    },
    label() {
      return this.item.is_following ? '已关注' : '关注'
    }
  },
  methods: {
    follow() {
      if (!this.isLogged) {
        return this.$router.push({name: 'auth.signin', query: { redirect: window.location.href }})
      }
      this.$http.post(this.$endpoints.followers + this.api, {id: this.item.id}).then(() => {
        this.toggleStatus()
      }).catch(() => {
        this.$store.dispatch('setMessage', {type: 'error', message: ['操作失败！']})
      })
    },
    toggleStatus() {
      this.item.is_following = !this.item.is_following
    }
  }
}
</script>
