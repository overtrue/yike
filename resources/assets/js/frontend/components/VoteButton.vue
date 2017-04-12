<template>
  <div class="favour" @click="vote">
    <i class="material-icons" v-if="item.is_voting">favorite</i>
    <i class="material-icons" v-else>favorite_border</i>
    <span v-text="item.vote_count"></span>
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
    vote() {
      if (!this.isLogged) {
        return this.$router.push({name: 'auth.signin', query: { redirect: window.location.href }})
      }
      this.$http.post(this.$endpoints.voters + this.api, {id: this.item.id})
          .then(() => {
            this.toggleStatus()
          }).catch(() => {
            this.$store.dispatch('setMessage', {type: 'error', message: ['操作失败！']})
          })
    },
    toggleStatus() {
      let count = this.item.vote_count

      this.item.is_voting = !this.item.is_voting

      this.item.vote_count = this.item.is_voting ? count + 1 : count - 1
    },
  }
}
</script>

<style lang="scss" scoped>
.favour {
  cursor: pointer;
}
</style>
