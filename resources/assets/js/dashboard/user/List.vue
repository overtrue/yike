<template>
  <div class="table-wrapper">
    <el-table :data="users" style="width: 100%">
      <el-table-column prop="id" label="ID" width="50"></el-table-column>
      <el-table-column label="Avatar" width="100">
        <template scope="scope">
          <img class="avatar" :src="scope.row.avatar">
        </template>
      </el-table-column>
      <el-table-column prop="name" label="Name" width="150"></el-table-column>
      <el-table-column prop="username" label="Username"></el-table-column>
      <el-table-column prop="email" label="Email"></el-table-column>
      <el-table-column prop="tag" label="Is Admin?" width="120">
        <template scope="scope">
          <el-tag
            :type="scope.row.is_admin ? 'primary' : 'success'"
            close-transition>{{scope.row.is_admin ? '管理员' : '成员'}}</el-tag>
        </template>
      </el-table-column>
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
    this.loadUsers({ number: this.number, page: this.page })
  },
  computed: {
    ...mapGetters({
      users: 'getUsers',
      pagination: 'getPagination'
    })
  },
  methods: {
    ...mapActions(['loadUsers']),
    handleSizeChange(val) {
      this.loadUsers({ number: val, page: this.page })
      this.number = val
    },
    handleCurrentChange(val) {
      this.loadUsers({ number: this.number, page: val })
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
  .avatar {
    width: 50px;
    border-radius: 50%;
    padding: 10px 0;
  }
</style>
