<template>
  <div class="wrapper">
    <data-table api="comments" :hideQuery="hideQuery" include="post" :columns="columns" @table-action="tableActions" :itemActions="itemActions" :searchables="searchables"></data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
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
          label: 'Actions',
          name: '__actions',
        },
      ],
      itemActions: [
        { name: 'preview-item', label: '预览', type: 'success' },
        { name: 'delete-item', label: '删除', type: 'danger' },
      ],
    }
  },
  methods: {
    onDelete(row) {
      this.$http.delete(this.$endpoints.comments + row.id)
          .then(({ data }) => {
            this.$message.success('删除成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
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
