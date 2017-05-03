<template>
  <div class="favour" @click="like">
    <i class="material-icons" v-if="item.has_liked">favorite</i>
    <i class="material-icons" v-else>favorite_border</i>
    <span v-text="item.like_count"></span>
  </div>
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
    like() {
      if (!this.isLogged) {
        return this.$router.push({name: 'auth.signin', query: { redirect: window.location.href }})
      }
      this.$http.post(this.$endpoints.likers + this.api, {id: this.item.id})
          .then(() => {
            this.toggleStatus()
          }).catch(() => {
            this.$store.dispatch('setMessage', {type: 'error', message: ['操作失败！']})
          })
    },
    toggleStatus() {
      let count = this.item.like_count

      this.item.has_liked = !this.item.has_liked

      this.item.like_count = this.item.has_liked ? count + 1 : count - 1
    },
  }
}
</script>
