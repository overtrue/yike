<template>
  <div class="wrapper">
    <data-table api="posts" :columns="columns" @table-action="tableActions" :itemActions="itemActions" :searchables="searchables">
      <template slot="draft" scope="props">
        <el-tag
          :type="props.data.row.is_draft ? 'warning' : 'primary'"
          close-transition>{{props.data.row.is_draft ? '是' : '否'}}</el-tag>
      </template>
    </data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchables: {
        title: 'Title',
        slug: 'Slug',
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
          label: 'Actions',
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
    onDelete(row) {
      this.$http.delete(this.$endpoints.posts + row.id)
          .then(({ data }) => {
            this.$message.success('删除成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    tableActions(action, data) {
      if (action == 'preview-item') {
        window.open('/' + data.row.user.data.username + '/' + data.row.slug)
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
