<template>
  <div class="tag-form">
    <el-form ref="tag" :model="tag" :rules="rules" label-width="90px">
      <el-form-item label="标签名" prop="name">
        <el-input v-model="tag.name" placeholder="Laravel" :value="tag.name"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" :disabled="busying" @click="onSubmit" v-text="actionLabel"></el-button>
        <el-button @click="onCancle">取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  props: {
    tag: {
      type: Object,
      default: function() {
        return {
          id: null,
          name: '',
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
      return this.tag.id ? '更新' : '创建'
    },
    rules() {
      return {
        name: [
          { type: 'string', required: true, message: '请填写标签名', trigger: 'blur' }
        ],
      }
    }
  },
  methods: {
    onSubmit() {
      this.$refs.tag.validate((passed) => {
        if (passed) {
          this.busying = true
          let url = this.$endpoints.tags + (this.tag.id || '')
          let method = this.tag.id ? 'patch' : 'post'

          this.$http[method](url, this.tag).then((response) => {
            this.busying = false
            this.$emit('succeed', response.data)
            this.$message.success(this.actionLabel + '成功')
          }).catch((error) => {
            console.log(error)
            this.$message.error(this.$store.state.messages.validation.name[0])
            this.busying = false
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
