<template>
  <section class="el-content">
    <el-row class="top">
      <el-col :span="6" :offset="1">
        <h3 class="title">{{ title }}</h3>
      </el-col>
      <el-col :span="6" :offset="10">
        <breadcrumb :breadcrumbs="breadcrumbs"></breadcrumb>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="22" :offset="1">
        <div class="el-content-inner">
          <router-view></router-view>
        </div>
      </el-col>
    </el-row>
  </section>
</template>

<script>
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
    Breadcrumb,
  }
}

</script>


<style lang="scss" scoped>
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

  .el-content-inner {
    background-color: #fff;
    height: 600px;
    border-radius: 10px;
  }
}
</style>
