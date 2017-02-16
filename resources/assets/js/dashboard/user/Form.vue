<template>
  <div class="user-form">
    <el-form ref="user" :model="user" :rules="rules" label-width="90px">
      <el-form-item label="用户名" prop="name">
        <el-input v-model="user.name" placeholder="admin" :value="user.name"></el-input>
      </el-form-item>
      <el-form-item label="邮箱" prop="email">
        <el-input v-model="user.email" placeholder="name@yike.io" type="email" :value="user.email"></el-input>
      </el-form-item>
      <el-form-item label="密码" prop="password">
        <el-input v-model="user.password"></el-input>
      </el-form-item>
      <el-form-item label="确认密码" prop="password_confirmation">
        <el-input v-model="user.password_confirmation"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" :disabled="busying" @click="onSubmit" v-text="actionLabel"></el-button>
        <el-button @click="onCancel">取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      default() {
        return {
          id: null,
          name: '',
          email: '',
          phone: '',
          password: '',
          password_confirmation: '',
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
    actionLabel() {
      return this.user.id ? '更新' : '创建'
    },
    rules() {
      return {
        name: [
          { type: 'string', required: true, message: '请填写用户名', trigger: 'blur' }
        ],
        email: [
          { type: 'email', required: true, message: '请填写邮箱', trigger: 'blur' }
        ],
        password: [
          { type: 'string', required: !this.user.id, message: '请输入密码', trigger: 'blur' }
        ],
        password_confirmation: [
          { type: 'string', required: !this.user.id, message: '请输入密码', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    onSubmit() {
      this.$refs.user.validate((passed) => {
        if (passed) {
          this.busying = true
          let url = this.$endpoints.users + (this.user.id || '')
          let method = this.user.id ? 'patch' : 'post'

          this.$http[method](url, this.user).then((response) => {
            this.busying = false
            this.$emit('succeed', response.data)
            this.$message.success(this.actionLabel + '成功')
          })
        } else {
          this.busying = false
        }
      })
    },
    onCancel() {
      this.$emit('canceled')
    }
  }
}
</script>
