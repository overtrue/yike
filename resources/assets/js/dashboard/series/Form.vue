<template>
  <div class="series-form">
    <el-form ref="series" :model="series" :rules="rules" label-width="90px">
      <el-form-item label="栏目标题" prop="title">
        <el-input v-model="series.title" placeholder="ex: Laravel 入门教程" :value="series.title"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" :disabled="busying" @click="onSubmit" v-text="actionLabel"></el-button>
        <el-button @click="onCancel">取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    props: {
      series: {
        type: Object,
        default() {
          return {
            id: null,
            title: '',
          }
        }
      }
    },
    data() {
      return {
        busying: false,
      }
    },
    computed: {
      ...mapState(['entrypoints']),
      actionLabel() {
        return this.series.id ? '更新' : '创建'
      },
      rules() {
        return {
          title: [
            { type: 'string', required: true, message: '请填栏目标题', trigger: 'blur'}
          ]
        }
      },
    },
    methods: {
      onSubmit() {
        this.$refs.series.validate((passed) => {
          if (passed) {
            this.busying = true
            let url = this.entrypoints.series + (this.series.id || '')
            let method = this.series.id ? 'patch' : 'post'

            this.$http[method](url, this.series).then((response) => {
              this.busying = false
              this.$emit('succeed')
              this.$message.success(this.actionLabel + '成功')
            })
          } else {
            this.busying = false
          }
        })
      },
      onCancel() {
        this.$emit('canceled')
      },
    }
  }
</script>

<style lang="scss" scoped>
  .wrapper {
    padding: 20px;
  }
</style>
