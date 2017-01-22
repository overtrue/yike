<template>
  <div class="wrapper">
    <el-table :data="posts" style="width: 100%">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="title" label="Title" width="150"></el-table-column>
      <el-table-column prop="slug" label="Slug"></el-table-column>
      <el-table-column prop="user.data.name" label="Author"></el-table-column>
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

    <div class="pagination-wrapper">
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page="pagination.current_page"
        :page-sizes="[10, 20, 30, 40]"
        :page-size="number"
        layout="total, sizes, prev, pager, next, jumper"
        :total="pagination.total">
      </el-pagination>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  data() {
    return {
      number: 10,
      page: 1,
    }
  },
  created() {
    this.loadPosts({ number: this.number, page: this.page })
  },
  computed: {
    ...mapGetters({
      posts: 'getPosts',
      pagination: 'getPostPagination'
    })
  },
  methods: {
    ...mapActions(['loadPosts']),
    handleSizeChange(val) {
      this.loadPosts({ number: val, page: this.page })
      this.number = val
    },
    handleCurrentChange(val) {
      this.loadPosts({ number: this.number, page: val })
    }
  }
}
</script>

<style lang="scss" scoped>
  .wrapper {
    padding: 20px;
  }
  .pagination-wrapper {
    text-align: center;
    margin: 20px 0;
  }
</style>
