<template>
  <div class="wrapper">
    <data-table api="tags" :columns="columns" @table-action="tableActions" :searchables="searchables">
      <template slot="right-buttons">
        <el-button @click="dialogFormVisible=!dialogFormVisible"><i class="material-icons">add</i> 新增标签</el-button>
      </template>
    </data-table>

    <el-dialog :title="currentTag?'修改标签':'新建标签'" v-model="dialogFormVisible" size="tiny" @close="onCloseForm">
      <tag-form @canceled="onCloseForm" @succeed="onTagCreated" :tag="currentTag"></tag-form>
    </el-dialog>
  </div>
</template>

<script>
import TagForm from './Form'

export default {
  components: { TagForm },
  data() {
    return {
      currentTag: undefined,
      dialogFormVisible: false,
      searchables: {
        name: 'Name',
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
          prop: 'slug',
          label: 'Slug',
        },
        {
          prop: 'creator.data.name',
          label: 'Creator',
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
    }
  },
  methods: {
    onEdit(row) {
      this.currentTag = row
      this.dialogFormVisible = true
    },
    onTagCreated() {
      this.$emit('reload')
      this.dialogFormVisible = false
      this.currentTag = {}
    },
    onCloseForm() {
      this.$emit('reload')
      this.dialogFormVisible = false
      this.currentTag = {}
    },
    onDelete(row) {
      this.$http.delete(this.$endpoints.tags + row.id)
          .then(({ data }) => {
            this.$message.success('删除成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
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
</style>
