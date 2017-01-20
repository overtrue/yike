<template>
  <div class="dashboard-page">
    <sidebar></sidebar>
    <div class="el-content-wrapper">
        <navbar></navbar>
        <section class="el-content">
          <el-row class="top" justify="space-between">
            <el-col :span="6">
              <h3 class="title">{{ title }}</h3>
            </el-col>
            <el-col :span="18">
              <breadcrumb :breadcrumbs="breadcrumbs"></breadcrumb>
            </el-col>
          </el-row>
          <div class="el-content-inner">
            <router-view></router-view>
          </div>
        </section>
      </div>
  </div>
</template>

<script>
import Sidebar from './Sidebar'
import Navbar from './Navbar'
import Breadcrumb from './Breadcrumb'

export default {
  computed: {
    title() {
      return this.$route.meta.title
    },
    breadcrumbs() {
      return (this.$parent && this.$parent.$route && this.$parent.$route.matched) || []
    }
  },
  components: {
    Sidebar, Navbar, Breadcrumb,
  }
}
</script>

<style lang="scss" scoped>
.el-content-wrapper {
  width: 100%;
  z-index: 97;
  box-sizing: border-box;
}
.top {
  padding-top: 60px;
  margin-bottom: 20px;

  .title {
    display: inline-block;
    height: 50px;
    line-height: 50px;
    color: #fff;
    margin: 0;
    font-weight: 300;
  }
}

.el-content {
  background: url('https://pigjian.com/uploads/bg.png');
  background-position: 0% 0%;
  background-repeat: no-repeat;
  background-size: 100%;
  position: relative;
  bottom: 0;
  margin-left: 220px;
  min-height: 350px;
  padding: 0 25px;

  .el-content-inner {
    background-color: #fff;
    height: 600px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
  }
}
</style>
