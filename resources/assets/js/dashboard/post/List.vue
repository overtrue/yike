<template>
  <div class="wrapper">
    <data-table api="posts" :hideQuery="hideQuery" :columns="columns" @table-action="tableActions" :itemActions="itemActions" :searchables="searchables">
      <template slot="draft" scope="props">
        <el-tag :type="props.data.row.is_draft ? 'warning' : 'primary'">
          {{props.data.row.is_draft ? '是' : '否'}}
        </el-tag>
      </template>
      <template slot="advanced" scope="props">
        <el-button size="small" type="info" v-if="!props.data.row.is_recommended" @click="onRecommend(props.data.row)">推荐</el-button>
        <el-button size="small" type="danger" v-else @click="onOff(props.data.row)">下架</el-button>
        <el-button size="small" type="warning" v-if="!props.data.row.is_banned" @click="onSetReason(props.data.row)">禁止</el-button>
        <el-button size="small" type="success" v-else @click="onLifted(props.data.row)">解禁</el-button>
      </template>
    </data-table>

    <el-dialog title="禁止原因" v-model="reasonFormVisible" size="tiny" @close="onCloseForm">
      <el-form label-width="90px">
        <el-form-item label="原因" prop="reason">
          <el-input placeholder="请输入禁止原因" v-model="reason"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" :disabled="busying" @click="onBanned">确定</el-button>
          <el-button @click="onCloseForm">取消</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      reason: '',
      busying: false,
      currentPost: undefined,
      reasonFormVisible: false,
      searchables: {
        title: 'Title',
        slug: 'Slug',
      },
      hideQuery: {
        id: this.$route.query.id
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
        },
        {
          prop: 'slug',
          label: 'Slug',
        },
        {
          prop: 'user.data.name',
          label: 'Author',
        },
        {
          label: 'Draft?',
          width: '80',
          name: 'draft',
        },
        {
          prop: 'created_at',
          label: 'Created At',
        },
        {
          width: '140',
          name: 'advanced',
        },
        {
          width: '135',
          name: '__actions',
        },
      ],
      itemActions: [
        { name: 'preview-item', label: '预览', type: 'success' },
        { name: 'delete-item', label: '删除', type: 'danger' }
      ],
    }
  },
  methods: {
    onRecommend(row) {
      this.$http.patch(this.$endpoints.posts + row.id + '/recommend')
          .then(({ data }) => {
            this.$message.success('推荐成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    onOff(row) {
      this.$http.patch(this.$endpoints.posts + row.id + '/off')
          .then(({ data }) => {
            this.$message.success('下架成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    onSetReason(row) {
      this.currentPost = row
      this.reasonFormVisible=true
    },
    onBanned() {
      this.$http.patch(this.$endpoints.posts + this.currentPost.id + '/ban', { reason: this.reason })
          .then(({ data }) => {
            this.$message.success('禁止成功')
            this.reasonFormVisible = false
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    onLifted(row) {
      this.$http.patch(this.$endpoints.posts + row.id + '/lift')
          .then(({ data }) => {
            this.$message.success('解禁成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    onDelete(row) {
      this.$http.delete(this.$endpoints.posts + row.id)
          .then(({ data }) => {
            this.$message.success('删除成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    onCloseForm() {
      this.currentPost = undefined
      this.reasonFormVisible = false
    },
    tableActions(action, data) {
      if (action == 'preview-item') {
        window.open('/' + data.row.user.data.username + '/' + data.row.slug)
      } else if (action == 'recommend-item') {
        this.onRecommend(data.row)
      } else if (action == 'ban-item') {
        this.onBan(data.row)
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
