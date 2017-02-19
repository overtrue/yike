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
    <el-menu router :default-active="$route.path" class="el-menu-bar">
      <el-menu-item-group title="Content Management">
        <el-menu-item index="/dashboard"><i class="material-icons">palette</i><span>Dashboard</span></el-menu-item>
        <el-menu-item index="/dashboard/user"><i class="material-icons">people</i><span>Users</span></el-menu-item>
        <el-menu-item index="/dashboard/post"><i class="material-icons">description</i><span>Posts</span></el-menu-item>
        <el-menu-item index="/dashboard/series"><i class="material-icons">featured_play_list</i><span>Series</span></el-menu-item>
        <el-menu-item index="/dashboard/tag"><i class="material-icons">label</i><span>Tags</span></el-menu-item>
        <el-menu-item index="/dashboard/role"><i class="material-icons">security</i><span>Roles</span></el-menu-item>
        <el-menu-item index="/dashboard/banner"><i class="material-icons">view_carousel</i><span>Banners</span></el-menu-item>
      </el-menu-item-group>
      <el-menu-item-group title="System Management">
        <el-submenu index="/dashboard/settings">
          <template slot="title"><i class="material-icons">settings</i><span>Settings</span></template>
          <el-menu-item index="/dashboard/settings/system">System</el-menu-item>
          <el-menu-item index="/dashboard/settings/rank">Rank</el-menu-item>
        </el-submenu>
        <el-menu-item index="/dashboard/logs"><i class="material-icons">warning</i><span>Logs</span></el-menu-item>
      </el-menu-item-group>
    </el-menu>
  </aside>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'
  import ElSubmenu from './Submenu'

  export default {
    components: { ElSubmenu },
    computed: {
      ...mapGetters({
        user: 'currentUser'
      })
    },
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
</style>
