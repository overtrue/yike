<template>
  <div class="wrapper">
    <el-row style="margin-bottom: 20px">
      <el-col>
        <el-button type="primary" @click="dialogFormVisible=!dialogFormVisible">
          <i class="material-icons">add</i> 新增用户
        </el-button>
      </el-col>
    </el-row>

    <data-table api="users" :columns="columns" @table-action="tableActions">
      <template slot="avatar" scope="props">
          <img class="avatar" :src="props.data.row.avatar">
      </template>
      <template slot="admin" scope="props">
        <el-tag
          :type="props.data.row.is_admin ? 'primary' : 'success'"
          close-transition>{{props.data.row.is_admin ? '管理员' : '成员'}}</el-tag>
      </template>
    </data-table>

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
      currentUser: {},
      dialogFormVisible: false,
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
      this.$http.delete(this.$store.state.entrypoints.users + row.id)
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
