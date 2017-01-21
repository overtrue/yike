<template>
    <div class="page-root">
      <transition name="fade">
        <router-view></router-view>
      </transition>
    </div>
</template>

<script>
export default {
  name: 'YiKe',
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
