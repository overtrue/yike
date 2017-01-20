<template>
    <div class="page-root">
      <navbar v-if="shouldShowNavigation"></navbar>
      <transition name="fade">
        <router-view></router-view>
      </transition>
      <alerts></alerts>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Navbar from './components/Navbar'
import Alerts from './components/Alerts'

export default {
  name: 'YiKe',
  components: {
    Navbar,
    Alerts,
  },
  computed: {
    ...mapGetters(['shouldShowNavigation']),
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
