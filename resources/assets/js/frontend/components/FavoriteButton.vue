<template>
  <div class="collect" @click="like">
    <i class="material-icons" v-if="item.has_favorited">turned_in</i>
    <i class="material-icons" v-else>turned_in_not</i>
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
      this.$http.post(this.$endpoints.favoriters + this.api, {id: this.item.id})
          .then(() => {
            this.toggleStatus()
          }).catch(() => {
            this.$store.dispatch('setMessage', {type: 'error', message: ['操作失败！']})
          })
    },
    toggleStatus() {
      this.item.has_favorited = !this.item.has_favorited
    },
  }
}
</script>
