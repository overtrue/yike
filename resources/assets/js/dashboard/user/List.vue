<template>
  <div class="wrapper">
    <el-row style="margin-bottom: 20px">
      <el-col>
        <el-button type="primary" @click="dialogFormVisible=!dialogFormVisible">
          <i class="material-icons">add</i> 新增用户
        </el-button>
      </el-col>
    </el-row>
    <el-table :data="users" style="width: 100%">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
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
            size="small"
            @click="onEdit(scope.row)">编辑</el-button>
          <el-button
            size="small"
            type="danger"
            @click="onDelete(scope.$index, scope.row)">删除</el-button>
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

    <el-dialog title="新建用户" v-model="dialogFormVisible" size="tiny">
      <user-form @canceled="onCloseForm" @succeed="onUserCreated" :user="currentUser"></user-form>
    </el-dialog>
  </div>
</template>

<script>
import UserForm from "./Form"

export default {
  components: { UserForm },
  data() {
    return {
      users: [],
      currentUser: {},
      query: {},
      dialogFormVisible: false,
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
    onEdit(user) {
      this.currentUser = user
      this.dialogFormVisible = true
    },
    onDelete(index, row) {
      this.users.splice(index, 1)

      this.$http.delete(this.$store.state.entrypoints.users + row.id)
          .then(({ data }) => {
            console.log(data)
            this.$message.success('删除成功')
          })
          .catch(response => console.log(response))
    },
    fetch() {
      let query = this.query

      query['page'] = this.pagination.current_page
      query['per_page'] = this.pagination.per_page

      this.$http.get(this.$store.state.entrypoints.users, { params:query })
          .then(({ data }) => {
            this.users = data.data
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
    },
    onCloseForm() {
      this.dialogFormVisible = false
      this.currentUser = {}
    },
    onUserCreated() {
      this.fetch()
      this.dialogFormVisible = false
      this.currentUser = {}
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
