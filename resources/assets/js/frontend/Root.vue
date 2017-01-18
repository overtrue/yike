<script>
import { mapGetters } from 'vuex'
import Navbar from './components/root/Navbar'
import Alerts from './components/general/Alerts'

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

<template>
    <div class="page-root">
      <navbar v-if="shouldShowNavigation"></navbar>
      <router-view></router-view>
      <alerts></alerts>
    </div>
</template>
