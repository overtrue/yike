<template>
  <div class="wrapper">
    <data-table api="roles" :columns="columns" @table-action="tableActions" :itemActions="itemActions" :searchables="searchables">
      <template slot="right-buttons">
        <el-button @click="dialogFormVisible=!dialogFormVisible"><i class="material-icons">add</i> 新增角色</el-button>
      </template>
    </data-table>

    <el-dialog :title="currentRole.id?'修改角色':'新增角色'" v-model="dialogFormVisible" size="tiny" @close="onCloseForm">
      <role-form @canceled="onCloseForm" @succeed="onRoleCreated" :role="currentRole"></role-form>
    </el-dialog>
    <el-dialog title="权限" v-model="editPermissionVisible" size="tiny" @close="onCloseForm">
      <permission-form :permissions="permissions" :role="currentRole"></permission-form>
    </el-dialog>
  </div>
</template>

<script>
import RoleForm from "./Form"
import PermissionForm from "./Permission"

export default {
  components: { RoleForm, PermissionForm },
  data() {
    return {
      currentRole: {},
      permissions: [],
      dialogFormVisible: false,
      editPermissionVisible: false,
      searchables: {
        name: 'Name',
        display_name: 'Display Name',
      },
      columns: [
        {
          prop: 'id',
          label: 'ID',
          width: '80',
        },
        {
          prop: 'name',
          label: 'Name',
          width: '150',
        },
        {
          prop: 'display_name',
          label: 'Display Name',
        },
        {
          prop: 'description',
          label: 'Description',
        },
        {
          prop: 'created_at',
          label: 'Created At',
        },
        {
          label: 'Actions',
          name: '__actions',
        },
      ],
      itemActions: [
        { name: 'permission-item', label: '权限', type: 'success' },
        { name: 'edit-item', label: '编辑', type: 'info' },
        { name: 'delete-item', label: '删除', type: 'danger' }
      ]
    }
  },
  created() {
    this.$http.get(this.$endpoints.permissions)
        .then((response) => {
          this.permissions = response.data.data
        })
  },
  methods: {
    onEdit(role) {
      this.currentRole = role
      this.dialogFormVisible = true
    },
    onEditPermission(role) {
      this.currentRole = role
      this.editPermissionVisible = true
    },
    onDelete(row) {
      this.$http.delete(this.$endpoints.roles + row.id)
          .then(({ data }) => {
            this.$message.success('删除成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    onCloseForm() {
      this.dialogFormVisible = false
      this.editPermissionVisible = false
      this.currentRole = {}
    },
    onRoleCreated() {
      this.$emit('reload')
      this.dialogFormVisible = false
      this.currentRole = {}
    },
    tableActions(action, data) {
      if (action == 'edit-item') {
        this.onEdit(data.row)
      } else if (action == 'permission-item') {
        this.onEditPermission(data.row)
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
</style>
