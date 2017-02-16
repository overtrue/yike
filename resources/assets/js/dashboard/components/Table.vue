<template>
  <div :class="tableWrapper">
    <el-table :data="items" style="width: 100%">
      <template v-for="column in columns">
        <template v-if="column.name">
          <template v-if="column.name == '__actions'">
            <el-table-column :label="column.label" :width="column.width">
              <template scope="scope">
                <el-button
                  v-for="action in itemActions"
                  :size="action.size?action.size:'small'"
                  :type="action.type?action.type:''"
                  @click="callAction(action.name, scope)">{{ action.label }}</el-button>
              </template>
            </el-table-column>
          </template>
          <el-table-column v-else :prop="column.prop" :label="column.label" :width="column.width">
            <template scope="scope">
              <slot :name="column.name" :data="scope"></slot>
            </template>
          </el-table-column>
        </template>
        <template v-else>
          <el-table-column :prop="column.prop" :label="column.label" :width="column.width"></el-table-column>
        </template>
      </template>
    </el-table>

    <el-pagination
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
      :current-page="pagination.current_page"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="pagination.per_page"
      layout="total, sizes, prev, pager, next, jumper"
      :total="pagination.total"
      :class="paginationWrapper">
    </el-pagination>
  </div>
</template>

<script>
  export default {
    props: {
      tableWrapper: {
        type: String,
        default() {
          return ''
        }
      },
      paginationWrapper: {
        type: String,
        default() {
          return 'pagination-wrapper'
        }
      },
      columns: {
        type: Array,
        default() {
          return []
        }
      },
      api: {
        type: String,
        default() {
          return ''
        }
      },
      itemActions: {
        type: Array,
        default() {
          return [
            { name: 'edit-item', label: '编辑' },
            { name: 'delete-item', label: '删除', type: 'danger' }
          ]
        }
      }
    },
    data() {
      return {
        items: [],
        query: {},
        pagination: {
          count: 0,
          current_page: 1,
          per_page: 20,
          total: 0,
          total_pages: 1,
        },
      }
    },
    created() {
      this.fetch()
    },
    mounted() {
      this.$parent.$on('reload', () => {
          this.fetch()
      })
    },
    methods: {
      fetch() {
        let query = this.query

        query['page'] = this.pagination.current_page
        query['per_page'] = this.pagination.per_page

        this.$http.get(this.$endpoints[this.api], { params: query })
            .then(({ data }) => {
              this.items = data.data
              this.pagination = data.meta.pagination
            })
            .catch(response => console.log(response))
      },
      handleSizeChange(val) {
        this.pagination.per_page = val
        this.fetch()
      },
      handleCurrentChange(val) {
        this.pagination.current_page = val
        this.fetch()
      },
      callAction(action, data) {
        this.$emit('table-action', action, data)
      },
    }
  }
</script>

<style lang="scss" scoped>
  .pagination-wrapper {
    text-align: center;
    margin: 20px 0;
  }
</style>
