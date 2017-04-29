<template>
  <div class="wrapper">
    <data-table api="feedbacks" :columns="columns" @table-action="tableActions" :itemActions="itemActions" :searchables="searchables"></data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchables: {
        ip: 'IP',
      },
      columns: [
        {
          prop: 'id',
          label: 'ID',
          width: '80',
        },
        {
          prop: 'ip',
          label: 'IP',
        },
        {
          prop: 'content',
          label: 'Main Content',
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
        { name: 'delete-item', label: '删除', type: 'danger' },
      ],
    }
  },
  methods: {
    onDelete(row) {
      this.$http.delete(this.$endpoints.feedbacks + row.id)
          .then(({ data }) => {
            this.$message.success('删除成功')
            this.$emit('reload')
          })
          .catch(response => console.log(response))
    },
    tableActions(action, data) {
      if (action == 'delete-item') {
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
