<template>
    <div class="page-root">
      <transition name="fade">
        <router-view></router-view>
      </transition>
      <alerts></alerts>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Alerts from './components/Alerts'

export default {
  name: 'YiKe',
  components: {
    Alerts,
  },
}
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0
}
</style>
