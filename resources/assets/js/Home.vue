<script>
import { mapGetters } from 'vuex'
import NavBar from './components/root/Navbar'
import Alerts from './components/general/Alerts'

export default {
  name: 'YiKe',
  components: {
    NavBar,
    Alerts,
  },
  computed: {
    ...mapGetters(['shouldShowNavigation']),
  },
}
</script>

<template>
  <div id="app">
    <nav-bar v-show="shouldShowNavigation"></nav-bar>
    <div class="container">
      <alerts></alerts>
      <router-view></router-view>
    </div>
  </div>
</template>