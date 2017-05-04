<template>
  <div :class="buttonClass" @click="action">
    <i class="material-icons" v-if="item['has_' + type + 'd']">{{ icons.positive }}</i>
    <i class="material-icons" v-else>{{ icons.negative }}</i>
    <span v-if="showStatistics" v-text="item[type + '_count']"></span>
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
    type: {
      type: String,
      default: 'like'
    },
    icons: {
      type: Object,
      default() {
        return {
          positive: 'favorite',
          negative: 'favorite_border',
        }
      }
    },
    showStatistics: {
      type: Boolean,
      dafault: false
    },
    buttonClass: {
      type: String,
      default: 'favour'
    },
  },
  computed: {
    ...mapGetters(['isLogged']),
  },
  methods: {
    action() {
      if (!this.isLogged) {
        return this.$router.push({name: 'auth.signin', query: { redirect: window.location.href }})
      }
      let url = this.$endpoints[this.type + 'rs'] + this.api
      this.$http.post(url, {id: this.item.id}).then(() => {
            this.toggleStatus()
          }).catch(() => {
            this.$store.dispatch('setMessage', {type: 'error', message: ['操作失败！']})
          })
    },
    toggleStatus() {
      let count = this.item[this.type + '_count']

      this.item['has_' + this.type + 'd'] = !this.item['has_' + this.type + 'd']

      this.item[this.type + '_count'] = this.item['has_' + this.type + 'd'] ? count + 1 : count - 1
    },
  }
}
</script>
