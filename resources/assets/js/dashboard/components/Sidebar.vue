<template>
  <aside class="el-menu-wrapper">
    <div class="header">
      <div class="logo">Yike Dashboard</div>
      <div class="bar"><i class="bar material-icons">graphic_eq</i></div>
    </div>
    <div class="user-info">
      <img :src="user.avatar">
      <div class="info">
        <span class="username">{{ user.name }}</span>
        <span class="email">{{ user.email }}</span>
      </div>
    </div>
    <el-menu router :default-active="$route.path" class="el-menu-bar" @open="handleOpen" @close="handleClose">
      <el-menu-item index="/dashboard"><i class="material-icons">palette</i><span>Dashboard</span></el-menu-item>
      <el-menu-item index="/dashboard/user"><i class="material-icons">people</i><span>Users</span></el-menu-item>
      <el-menu-item index="/dashboard/post"><i class="material-icons">description</i><span>Posts</span></el-menu-item>
      <el-menu-item index="/dashboard/series"><i class="material-icons">featured_play_list</i><span>Series</span></el-menu-item>
      <el-menu-item index="/dashboard/tag"><i class="material-icons">label</i><span>Tags</span></el-menu-item>
      <el-menu-item index="/dashboard/role"><i class="material-icons">security</i><span>Roles</span></el-menu-item>
    </el-menu>
  </aside>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'

  export default {
    data() {
      return {
      }
    },
    computed: {
      ...mapGetters({
        user: 'currentUser'
      })
    },
    methods: {
      handleOpen(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        console.log(key, keyPath);
      }
    }
  }
</script>

<style lang="scss" scoped>
// Header
.header {
  height: 60px;
  line-height: 60px;
  padding: 0 10px 0 20px;
  font-size: .9rem;
  font-weight: bold;
  background-color: #30304D;
  color: #fff;
  position: relative;

  div {
    display: inline-block;
  }
  .bar {
    position: absolute;
    right: 10px;
    font-size: 18px;
    cursor: pointer;
  }
}
// User Info
.user-info {
  height: 100px;

  img {
    float: left;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: inline-block;
    vertical-align: middle;
    margin: 30px 15px 30px 20px;
  }
  .info {
    display: inline-block;
    font-size: 12px;
    color: #fff;
    height: 50px;
    margin-top: 25px;
    margin-bottom: 25px;
    padding-top: 5px;
    padding-bottom: 5px;

    span {
      display: block;
      line-height: 20px;
    }
    .email {
      font-weight: 200;
    }
  }
}
// Menu
.el-menu-wrapper {
  position: fixed;
  left: 0;
  top: 0;
  background: #383856;
  height: 100%;
  overflow: auto;
  z-index: 98;
}
.el-menu {
  background-color: transparent !important;
}
.el-menu-bar {
  flex-grow: 0;
  width: 220px;
  border-radius: 0;
}
.el-menu-item, .el-submenu__title {
  color: #fff;
  opacity: .6;
  font-size: 12px;

  i {
    color: #9795E4;
    font-size: 20px;
    padding: 0 10px;
    margin-right: 10px;
    vertical-align: text-bottom;
  }
  span {
    display: inline-block;
    line-height: inherit;
    vertical-align: text-bottom;
  }
}
.el-menu-item:hover, .el-submenu__title:hover, .el-menu li.el-menu-item:hover {
  background-color: rgba(255, 255, 255, .05);
  color: #fff !important;
  opacity: 1 !important;
}
.is-active {
  background-color: #30304D;
  color: #fff !important;
  opacity: 1 !important;
}
</style>
