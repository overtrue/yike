<template>
  <el-breadcrumb separator="/" class="text-right">
    <el-breadcrumb-item v-for="(item, index) in breadcrumbs" :to="item.path">
      {{ item.meta.title }}
    </el-breadcrumb-item>
  </el-breadcrumb>
</template>

<script>
  export default {
    props: {
      breadcrumbs: {
        type: Array,
        default() {
          return []
        }
      }
    }
  }
</script>

<style lang="scss">
.el-breadcrumb {
  height: 50px;
  line-height: 50px;
}
.el-breadcrumb__item {
  float: none;
}
.el-breadcrumb__item__inner {
  color: #97a8be !important;
  font-weight: 200;
}
.el-breadcrumb__item__inner:hover {
  color: #fff !important;
}
.el-breadcrumb__item:last-child .el-breadcrumb__item__inner {
  color: #fff !important;
}
</style>
