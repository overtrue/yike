<template>
  <div class="table-wrapper">
    <el-table :data="posts" style="width: 100%">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="title" label="Title" width="150"></el-table-column>
      <el-table-column prop="slug" label="Slug"></el-table-column>
      <el-table-column prop="type" label="Type"></el-table-column>
      <el-table-column prop="is_draft" label="Is Draft" width="120">
        <template scope="scope">
          <el-tag
            :type="scope.row.is_draft ? 'warning' : 'primary'"
            close-transition>{{scope.row.is_draft ? '是' : '否'}}</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="created_at" label="Created"></el-table-column>
      <el-table-column label="Actions">
        <template scope="scope">
          <el-button
            size="small">编辑</el-button>
          <el-button
            size="small"
            type="danger">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  created() {
    this.loadPosts()
  },
  computed: {
    ...mapGetters({
      posts: 'getPosts'
    })
  },
  methods: {
    ...mapActions(['loadPosts'])
  }
}
</script>

<style lang="scss" scoped>
  .table-wrapper {
    padding: 20px;
  }
</style>
