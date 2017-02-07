<template>
  <div class="wrapper">
    <data-table api="posts" :columns="columns" @table-action="tableActions">
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
          prop: 'slug',
          label: 'Slug',
        },
        {
          prop: 'user.data.name',
          label: 'Author',
        },
        {
          label: 'Is Draft',
          width: '120',
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
</style>
