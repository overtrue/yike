<template>
  <div class="role-form">
    <el-form ref="role" :model="role" :rules="rules" label-width="90px">
      <el-form-item label="ID名称" prop="name">
        <el-input v-model="role.name" placeholder="英文，字母与下划线 ex: xx_manager" :value="role.name"></el-input>
      </el-form-item>
      <el-form-item label="显示名称" prop="display_name">
        <el-input v-model="role.display_name" placeholder="ex: xx管理员" :value="role.display_name"></el-input>
      </el-form-item>
      <el-form-item label="描述" prop="description">
        <el-input v-model="role.description"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" :disabled="busying" @click="onSubmit" v-text="actionLabel"></el-button>
        <el-button @click="onCancle">取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    props: {
      role: {
        type: Object,
        default: function() {
          return {
            id: null,
            name: '',
            display_name: '',
            description: '',
          }
        }
      },
    },
    data() {
      return {
        busying: false,
      }
    },
    computed: {
      ...mapState(['entrypoints']),
      actionLabel() {
        return this.role.id ? '更新' : '创建'
      },
      rules() {
        return {
          name: [
            { type: 'string', required: true, message: '请填写角色', trigger: 'blur' }
          ],
          display_name: [
            { type: 'string', required: true, message: '请填写角色名', trigger: 'blur' }
          ],
          description: [
            { type: 'string', required: false, message: '请填写角色秒速', trigger: 'blur' }
          ],
        }
      },
    },
    methods: {
      onSubmit() {
        let that = this

        this.$refs.role.validate((passed) => {
          if (passed) {
            this.busying = true
            let url = this.entrypoints.roles + ((this.role.id) || '')
            let method = this.role.id ? 'patch' : 'post'

            this.$http[method](url, this.role).then((response) => {
              this.busying = false
              this.$emit('succeed')
              this.$message.success(that.actionLabel + '成功')
            })
          } else {
            this.busying = false
          }
        })
      },
      onCancle() {
        this.$emit('canceled')
      }
    }
  }
</script>
