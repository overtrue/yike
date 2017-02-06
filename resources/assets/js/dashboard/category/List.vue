<template>
  <div class="wrapper">
    <el-table :data="posts" style="width: 100%">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="name" label="Name" width="150"></el-table-column>
      <el-table-column prop="slug" label="Slug"></el-table-column>
      <el-table-column prop="order" label="Order"></el-table-column>
      <el-table-column prop="description" label="Description"></el-table-column>
      <el-table-column prop="user.data.name" label="Last Edit User"></el-table-column>
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

    <el-pagination
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
      :current-page="pagination.current_page"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="pagination.per_page"
      layout="total, sizes, prev, pager, next, jumper"
      :total="pagination.total"
      class="pagination-wrapper">
    </el-pagination>
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: [],
      query: {},
      pagination: {
        count: 0,
        current_page: 1,
        per_page: 20,
        total: 0,
        total_pages: 1,
      },
    }
  },
  created() {
    this.fetch()
  },
  methods: {
    fetch() {
      let query = this.query

      query['page'] = this.pagination.current_page
      query['per_page'] = this.pagination.per_page

      this.$http.get(this.$store.state.entrypoints.categories, { params: query })
          .then(({ data }) => {
            this.posts = data.data
            this.pagination = data.meta.pagination
          })
          .catch(response => console.log(response))
    },
    handleSizeChange(val) {
      this.pagination.per_page = val
      this.fetch()
    },
    handleCurrentChange(val) {
      this.pagination.current_page = val
      this.fetch()
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
