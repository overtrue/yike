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
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  created() {
    this.loadUsers()
  },
  computed: {
    ...mapGetters({
      users: 'getUsers'
    })
  },
  methods: {
    ...mapActions(['loadUsers'])
  }
}
</script>

<style lang="scss" scoped>
  .table-wrapper {
    padding: 20px;
  }
  .avatar {
    width: 50px;
    border-radius: 50%;
    padding: 10px 0;
  }
</style>
