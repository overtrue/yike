<template>
  <el-menu mode="horizontal" class="pull-right" @select="handleSelect">
    <el-menu-item index="/"><i class="material-icons">home</i></el-menu-item>
    <el-menu-item index="2"><i class="material-icons">notifications</i></el-menu-item>
    <el-menu-item index="logout"><span>Logout</span> <i class="material-icons">power_settings_new</i></el-menu-item>
  </el-menu>
</template>

<script>
  import { mapActions } from 'vuex'

  export default {
    methods: {
      ...mapActions(['logout']),
      handleSelect(key, keyPath) {
        if (key == 'logout') {
          this.logout()
          return window.location.href = '/'
        }

        window.location.href = key
      }
    },
  }
</script>

<style lang="scss" scoped>
.pull-right {
  float: right;
}
.el-menu {
  background-color: transparent !important;
  z-index: 99;
}
.el-menu-item {
  color: #fff;

  span {
    font-size: 12px;
    font-weight: 300;
  }
  i {
    font-size: 18px;
  }
}
.el-menu-item:last-child {
  margin-right: 35px;
}
.el-menu-item:hover {
  background-color: transparent !important;
}
</style>
