<template>
  <div class="wrapper">
    <el-row style="margin-bottom: 20px">
      <el-col>
        <el-button type="primary" @click="dialogFormVisible=!dialogFormVisible">
          <i class="material-icons">add</i> 新增 Banner
        </el-button>
      </el-col>
    </el-row>

    <data-table api="banners" :columns="columns" @table-action="tableActions">
      <template slot="image" scope="props">
          <img :src="props.data.row.image.path">
      </template>
    </data-table>

    <el-dialog :title="currentBanner?'修改 Banner':'新增 Banner'" v-model="dialogFormVisible" size="small" @close="onCloseForm">
      <banner-form @canceled="onCloseForm" @succeed="onBannerCreated" @preview="onPreview" :banner="currentBanner"></banner-form>
    </el-dialog>
    <el-dialog title="预览图片" v-model="previewImage" size="middle">
      <img class="w-100" :src="imagePath">
    </el-dialog>
  </div>
</template>

<script>
  import BannerForm from './Form'

  export default {
    components: { BannerForm },
    data() {
      return {
        currentBanner: undefined,
        dialogFormVisible: false,
        previewImage: false,
        imagePath: '',
        columns: [
          {
            prop: 'id',
            label: 'ID',
            width: '80',
          },
          {
            name: 'image',
            label: 'Image',
            width: '100',
          },
          {
            prop: 'title',
            label: 'Title',
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
        ]
      }
    },
    methods: {
      onPreview(file) {
        this.previewImage = true
        this.imagePath = file.url
      },
      onEdit(row) {
        this.currentBanner = row
        this.dialogFormVisible = true
      },
      onDelete(row) {
        this.$http.delete(this.$endpoints.banners + row.id)
            .then(({ data }) => {
              this.$message.success('删除成功')
              this.$emit('reload')
            })
            .catch(response => console.log(response))
      },
      onBannerCreated() {
        this.$emit('reload')
        this.dialogFormVisible = false
        this.currentBanner = {}
      },
      onCloseForm() {
        this.dialogFormVisible = false
        this.currentBanner = {}
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
