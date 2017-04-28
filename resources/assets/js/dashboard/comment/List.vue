<template>
  <div class="wrapper">
    <data-table api="comments" :hideQuery="hideQuery" include="post" :columns="columns" @table-action="tableActions" :itemActions="itemActions" :searchables="searchables">
      <template slot="advanced" scope="props">
        <el-button size="small" type="warning" v-if="!props.data.row.is_banned" @click="onSetReason(props.data.row)">禁止</el-button>
        <el-button size="small" type="success" v-else @click="onLifted(props.data.row)">解禁</el-button>
      </template>
    </data-table>

    <el-dialog title="禁止原因" v-model="reasonFormVisible" size="tiny" @close="onCloseForm">
      <el-form ref="reason" :model="reasonForm" label-width="90px" :rules="rules">
        <el-form-item label="原因" prop="reason">
          <el-input placeholder="请输入禁止原因" v-model="reasonForm.reason"></el-input>
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
      busying: false,
      reasonForm: {
        reason: ''
      },
      currentComment: undefined,
      reasonFormVisible: false,
      searchables: {
        commentable_type: 'Type',
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
          prop: 'user.data.username',
          label: 'User Name',
        },
        {
          prop: 'type',
          label: 'Type',
        },
        {
          prop: 'vote_count',
          label: 'Votes',
        },
        {
          prop: 'created_at',
          label: 'Created',
        },
        {
          width: '70',
          name: 'advanced',
        },
        {
          width: '135',
          name: '__actions',
        },
      ],
      itemActions: [
        { name: 'preview-item', label: '预览', type: 'success' },
        { name: 'delete-item', label: '删除', type: 'danger' },
      ],
    }
  },
  computed: {
    rules() {
      return {
        reason: [
          { type: 'string', required: true, message: '请填写禁止原因', trigger: 'blur'}
        ]
      }
    },
  },
  methods: {
    onSetReason(row) {
      this.currentComment = row
      this.reasonFormVisible=true
    },
    onBanned() {
      this.$refs.reason.validate((passed) => {
        if (passed) {
          this.busying = true
          this.$http.patch(this.$endpoints.comments + this.currentComment.id + '/ban', this.reasonForm)
              .then(({ data }) => {
                this.busying = false
                this.reasonForm.reason = ''
                this.reasonFormVisible = false
                this.$message.success('禁止成功')
                this.$emit('reload')
              })
              .catch((response) => {
                this.busying = false
                this.$message.success('禁止失败')
              })
        } else {
          this.busying = false
        }
      })
    },
    onLifted(row) {
      this.$http.patch(this.$endpoints.comments + row.id + '/lift')
          .then(({ data }) => {
            this.$message.success('解禁成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    onDelete(row) {
      this.$http.delete(this.$endpoints.comments + row.id)
          .then(({ data }) => {
            this.$message.success('删除成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    onCloseForm() {
      this.busying = false
      this.reasonForm.reason = ''
      this.currentComment = undefined
      this.reasonFormVisible = false
    },
    tableActions(action, data) {
      if (action == 'preview-item') {
        let post = data.row.post.data
        window.open('/' + post.user.data.username + '/' + post.slug + '#comment-' + data.row.id)
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
