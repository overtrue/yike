<template>
  <div class="body">
    <transition name="fade">
      <router-view></router-view>
    </transition>
    <alerts></alerts>
  </div>
</template>

<script>
import Alerts from "./components/Alerts"

export default {
  components: {
    Alerts
  }
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
