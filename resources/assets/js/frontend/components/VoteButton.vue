<template>
  <div class="vote-button">
    <div class="vote" :class="item.is_voting ? 'active' : ''" @click="upVote(item.id)">
      <i class="material-icons">thumb_up</i> {{ item.vote_count > 0 ? item.vote_count : '' }}
    </div>
    <i class="vote material-icons" :class="item.is_down_voting ? 'active' : ''" @click="downVote(item.id)">thumb_down</i>
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
    ...mapGetters(['isLogged']),
  },
  methods: {
    toggleStatus() {
      let count = this.item.vote_count

      this.item.is_voting = !this.item.is_voting

      this.item.vote_count = this.item.is_voting ? count + 1 : count - 1
    },
    upVote(id) {
      this.toggleVote(id, 'up')
    },
    downVote(id) {
      this.toggleVote(id, 'down')
    },
    toggleVote(id, type) {
      if (!this.isLogged) {
        return this.$router.push({name: 'auth.signin', query: { redirect: window.location.href }})
      }

      let url = this.$endpoints.voters + this.api + '/' + type
      let upType = 'is_voting'
      let downType = 'is_down_voting'
      let checkType = type == 'up' ? downType : upType
      let votingType = type == 'up' ? upType : downType

      this.$http.post(url, {id: id})
          .then(() => {
            if(this.item[checkType]) {
              this.item[upType] = !this.item[upType]
              this.item[downType] = !this.item[downType]
              type == 'up' ? this.item.vote_count++ : this.item.vote_count--
            } else {
              this.item[votingType] = !this.item[votingType]
              if(type == 'up') this.item[upType] ? this.item.vote_count++ : this.item.vote_count--
            }
          }).catch(() => {
            this.$store.dispatch('setMessage', {type: 'error', message: ['操作失败！']})
          })
    },
  }
}
</script>

<style lang="scss" scoped>
.vote {
  display: inline-block;
  padding: 5px 10px;
  color: #dce7f4;
  border: 1px solid #dce7f4;
  border-radius: 5px;
  cursor: pointer;
}
.active {
  color: #00ab6b;
  border: 1px solid #00ab6b;
}
</style>
