<template>
  <div class="wrapper">
    <data-table api="categories" :columns="columns" @table-action="tableActions"></data-table>
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
          prop: 'name',
          label: 'Name',
          width: '150',
        },
        {
          prop: 'slug',
          label: 'Slug',
        },
        {
          prop: 'order',
          label: 'Order',
        },
        {
          prop: 'description',
          label: 'Description',
        },
        {
          prop: 'user.data.name',
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
    tableActions(action, data) {
      if (action == 'edit-item') {
        console.log('Edit')
      } else if (action == 'delete-item') {
        console.log('Deleted')
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
