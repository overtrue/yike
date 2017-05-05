<template>
  <button v-if="enabled" class="btn-follow btn" :class="{'btn-outline-primary': !item[checkField], 'btn-primary': item[checkField]}" @click="action"><slot>{{ label }}</slot></button>
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
      default: 'follow'
    },
    checkField: {
      type: String,
      default: 'is_following'
    },
    endpoint: {
      type: String,
      default: 'followers'
    },
    labels: {
      type: Object,
      default() {
        return {
          positive: '关注',
          negative: '已关注',
        }
      }
    },
  },
  computed: {
    ...mapGetters(['isLogged', 'currentUser']),
    enabled() {
      return !this.isLogged || this.currentUser.id != this.item.id
    },
    label() {
      return this.item[this.checkField] ? this.labels.negative : this.labels.positive
    }
  },
  methods: {
    action() {
      if (!this.isLogged) {
        return this.$router.push({name: 'auth.signin', query: { redirect: window.location.href }})
      }
      this.$http.post(this.$endpoints[this.endpoint] + this.api, {id: this.item.id}).then(() => {
        this.toggleStatus()
      }).catch(() => {
        this.$store.dispatch('setMessage', {type: 'error', message: ['操作失败！']})
      })
    },
    toggleStatus() {
      this.item[this.checkField] = !this.item[this.checkField]

      this.$emit('updateStatistics', this.item[this.checkField] ? 1 : 0)
    }
  }
}
</script>
