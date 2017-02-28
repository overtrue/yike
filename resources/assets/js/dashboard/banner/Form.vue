<template>
  <div class="banner-form">
    <el-form ref="banner" :model="banner" :rules="rules" label-width="90px">
      <el-upload
        class="uploader"
        action="/files/upload?strategy=banner"
        :headers="headers"
        :file-list="fileList"
        :on-preview="handlePreview"
        :on-success="handleSuccess"
        :on-remove="handleRemove"
        drag
      >
        <template v-if="image">
          <img :src="image.url" class="cover-image">
        </template>
        <template v-else>
          <i class="el-icon-upload"></i>
          <div class="el-dragger__text">将文件拖到此处，或<em>点击上传</em></div>
        </template>
        <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
      </el-upload>
      <el-form-item label="链接" prop="link">
        <el-input v-model="banner.link" placeholder="https://yike.io/laravel/valet" :value="banner.link"></el-input>
      </el-form-item>
      <el-form-item label="标题" prop="title">
        <el-input v-model="banner.title" placeholder="Laravel Valet" :value="banner.title"></el-input>
      </el-form-item>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Target" prop="target">
            <el-select v-model="banner.target" placeholder="请选择">
              <el-option
                v-for="target in targets"
                :label="target.name"
                :value="target.name">
              </el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="排序" prop="order">
            <el-input v-model="banner.order" placeholder="0" :value="banner.order"></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-form-item label="描述" prop="description">
        <el-input v-model="banner.description" placeholder="Laravel Valet..." :value="banner.description"></el-input>
      </el-form-item>
      <el-form-item label="启动时间" prop="enabled_at">
        <el-date-picker
          v-model="banner.enabled_at"
          :value="banner.enabled_at"
          type="datetime"
          placeholder="选择日期时间">
        </el-date-picker>
      </el-form-item>
      <el-form-item label="过期时间" prop="expired_at">
        <el-date-picker
          v-model="banner.expired_at"
          :value="banner.expired_at"
          type="datetime"
          placeholder="选择日期时间">
        </el-date-picker>
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
    banner: {
      type: Object,
      default() {
        return {
          id: null,
          title: '',
          link: '',
          target: '_blank',
          order: 0,
          description: '',
          enabled_at: '',
          expired_at: '',
        }
      }
    },
    image: {
      type: Object,
      default() {
        return undefined
      }
    },
  },
  data() {
    return {
      headers: {
        Authorization: `Bearer ${this.$store.state.Auth.token}`,
      },
      busying: false,
      targets: [
        {name: '_blank'},
        {name: '_self'},
        {name: '_parent'},
        {name: '_top'},
      ],
    }
  },
  computed: {
    fileList() {
      return this.banner.id
            ? [{ name: this.banner.image.data.title, url: '/'+this.banner.image.data.path }]
            : []
    },
    actionLabel() {
      return this.banner.id ? '更新' : '创建'
    },
    rules() {
      return {
      }
    },
  },
  methods: {
    handleSuccess(response, file, fileList) {
      this.banner.image_id = response.image_id
      this.image = response
    },
    handlePreview(file) {
      this.$emit('preview', file)
    },
    handleRemove(file, fileList) {
      console.log(file, fileList)
    },
    onSubmit() {
      this.$refs.banner.validate((passed) => {
        if (passed) {
          this.busying = true
          let url = this.$endpoints.banners + (this.banner.id || '')
          let method = this.banner.id ? 'patch' : 'post'

          this.$http[method](url, this.banner).then((response) => {
            this.busying = false
            this.$emit('succeed', response.data)
            this.$message.success(this.actionLabel + '成功')
          }).catch((error) => {
            this.busying = false
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

<style lang="scss" scoped>
  .cover-image {
    width: 100%;
  }
  .uploader {
    text-align: center;
    margin-bottom: 15px;
  }
</style>
