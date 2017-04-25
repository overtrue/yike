<template>
  <div class="wrapper">
    <data-table api="reports" include="post" :columns="columns" @table-action="tableActions" :itemActions="itemActions"></data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      columns: [
        {
          prop: 'id',
          label: 'ID',
          width: '80',
        },
        {
          prop: 'user.data.name',
          label: 'Report User',
        },
        {
          prop: 'type',
          label: 'Type',
        },
        {
          prop: 'reason',
          label: 'Reason',
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
      ],
    }
  },
  methods: {
    tableActions(action, data) {
      if (action == 'preview-item') {
        if (data.row.type == 'Post') {
          this.$router.push({ name: 'dashboard.post', query: { id: data.row.type_id } })
        } else if (data.row.type == 'Comment') {
          this.$router.push({ name: 'dashboard.comment', query: { id: data.row.type_id } })
        }
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
