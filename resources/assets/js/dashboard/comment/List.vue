<template>
  <div class="wrapper">
    <data-table api="comments" :columns="columns" :searchables="searchables"></data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchables: {
        commentable_type: 'Type',
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
      ]
    }
  },
  methods: {
  }
}
</script>

<style lang="scss" scoped>
  .wrapper {
    padding: 20px;
  }
</style>
