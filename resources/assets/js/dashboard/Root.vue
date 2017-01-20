<template>
  <div class="body">
    <side-bar></side-bar>
    <div class="el-content-wrapper">
      <navbar></navbar>
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  import SideBar from './components/Sidebar'
  import Navbar from './components/Navbar'

  export default {
    components: {
      SideBar,
      Navbar,
    }
  }
</script>

<style lang="scss" scoped>
// content
.el-content-wrapper {
  width: 100%;
  z-index: 97;
  box-sizing: border-box;
}
</style>
