<template>
  <div class="wrapper">
    <data-table api="users" :columns="columns" @table-action="tableActions" :searchables="searchables">
      <template slot="avatar" scope="props">
          <img class="avatar" :src="props.data.row.avatar">
      </template>

      <template slot="admin" scope="props">
        <el-tag :type="props.data.row.is_admin ? 'success' : 'gray'">
          {{props.data.row.is_admin ? '管理员' : '成员'}}
        </el-tag>
      </template>

      <template slot="right-buttons">
        <el-button @click="dialogFormVisible=!dialogFormVisible"><i class="material-icons">add</i> 新增用户</el-button>
      </template>
    </data-table>

    <el-dialog :title="currentUser?'修改用户':'新建用户'" v-model="dialogFormVisible" size="tiny">
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
      currentUser: undefined,
      dialogFormVisible: false,
      searchables: {
        name: 'Name',
        email: 'Email',
      },
      columns: [
        {
          prop: 'id',
          label: 'ID',
          width: '80',
        },
        {
          label: 'Avatar',
          width: '100',
          name: 'avatar',
        },
        {
          prop: 'name',
          label: 'Name',
          width: '150',
        },
        {
          prop: 'username',
          label: 'User Name',
        },
        {
          prop: 'email',
          label: 'Email',
        },
        {
          label: 'Is Admin?',
          width: '120',
          name: 'admin',
        },
        {
          label: 'Actions',
          name: '__actions',
        },
      ]
    }
  },
  methods: {
    onEdit(user) {
      this.currentUser = user
      this.dialogFormVisible = true
    },
    onDelete(row) {
      this.$http.delete(this.$endpoints.users + row.id)
          .then(({ data }) => {
            this.$message.success('删除成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    onCloseForm() {
      this.dialogFormVisible = false
      this.currentUser = {}
    },
    onUserCreated() {
      this.$emit('reload')
      this.dialogFormVisible = false
      this.currentUser = {}
    },
    tableActions(action, data) {
      if (action == 'edit-item') {
        this.onEdit(data.row)
      } else if (action == 'delete-item') {
        this.onDelete(data.row)
      }
    },
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
