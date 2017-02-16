<template>
  <div class="wrapper">
    <el-row style="margin-bottom: 20px">
      <el-col>
        <el-button type="primary" @click="dialogFormVisible=!dialogFormVisible">
          <i class="material-icons">add</i> 新增栏目
        </el-button>
      </el-col>
    </el-row>

    <data-table api="series" :columns="columns" @table-action="tableActions"></data-table>

    <el-dialog :title="currentSeries.id?'修改栏目':'新增栏目'" v-model="dialogFormVisible" size="tiny" @close="onCloseForm">
      <series-form @canceled="onCloseForm" @succeed="onSeriesCreated" :series="currentSeries"></series-form>
    </el-dialog>
  </div>
</template>

<script>
 import SeriesForm from './Form'

  export default {
    components: { SeriesForm },
    data() {
      return {
        currentSeries: {},
        dialogFormVisible: false,
        columns: [
          {
            prop: 'id',
            label: 'ID',
            width: '80',
          },
          {
            prop: 'title',
            label: 'Title',
            width: '150',
          },
          {
            prop: 'user.data.name',
            label: 'Author',
          },
          {
            prop: 'post_cache',
            label: 'Posts Number',
          },
          {
            prop: 'created_at',
            label: 'Created At',
          },
          {
            label: 'Actions',
            name: '__actions',
          },
        ]
      }
    },
    methods: {
      onEdit(series) {
        this.currentSeries = series
        this.dialogFormVisible = true
      },
      onSeriesCreated() {
        this.$emit('reload')
        this.dialogFormVisible = false
        this.currentSeries = {}
      },
      onCloseForm() {
        this.dialogFormVisible = false
        this.currentSeries = {}
      },
      onDelete(row) {
        this.$http.delete(this.$endpoints.series + row.id)
            .then(({ data }) => {
              this.$message.success('删除成功')
              this.$emit('reload')
            })
            .catch((response) => console.log(response))
      },
      tableActions(action, data) {
        if (action == 'edit-item') {
          this.onEdit(data.row)
        } else if (action == 'delete-item') {
          this.onDelete(data.row)
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  .wrapper {
    padding: 20px;
  }
</style>
