<template>
  <div class="wrapper">
    <data-table api="series" :columns="columns" @table-action="tableActions" :searchables="searchables">
      <template slot="right-buttons">
        <el-button @click="dialogFormVisible=!dialogFormVisible"><i class="material-icons">add</i> 新增栏目</el-button>
      </template>
    </data-table>

    <el-dialog :title="currentSeries?'修改栏目':'新增栏目'" v-model="dialogFormVisible" size="tiny" @close="onCloseForm">
      <series-form @canceled="onCloseForm" @succeed="onSeriesCreated" :series="currentSeries" :image="currentImage"></series-form>
    </el-dialog>
  </div>
</template>

<script>
  import SeriesForm from './Form'

  export default {
    components: { SeriesForm },
    data() {
      return {
        currentImage: undefined,
        currentSeries: undefined,
        dialogFormVisible: false,
        searchables: {
          title: 'Title',
        },
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
        this.currentImage = series.image.data
      },
      onSeriesCreated() {
        this.$emit('reload')
        this.dialogFormVisible = false
        this.currentSeries = undefined
        this.currentImage = undefined
      },
      onCloseForm() {
        this.dialogFormVisible = false
        this.currentSeries = undefined
        this.currentImage = undefined
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
