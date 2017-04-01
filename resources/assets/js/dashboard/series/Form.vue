<template>
  <div class="series-form">
    <el-form ref="series" :model="series" :rules="rules" label-width="90px">
      <el-form-item label="图片" prop="image">
        <el-upload
          class="image-uploader"
          action="/files/upload?strategy=series"
          :headers="headers"
          :show-file-list="false"
          :on-success="handleSuccess"
          :before-upload="beforeUpload">
          <img v-if="currentImage" :src="currentImage.url" class="image">
          <i v-else class="el-icon-plus image-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <el-form-item label="栏目标题" prop="title">
        <el-input v-model="series.title" placeholder="ex: Laravel 入门教程" :value="series.title"></el-input>
      </el-form-item>
      <el-form-item label="栏目描述" prop="description">
        <el-input type="textarea" :rows="2" placeholder="请输入栏目描述" v-model="series.description" :value="series.description"></el-input>
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
      series: {
        type: Object,
        default() {
          return {
            id: null,
            title: '',
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
        currentImage: this.image,
      }
    },
    watch: {
      image() {
        this.currentImage = this.image
      },
    },
    computed: {
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
            let url = this.$endpoints.series + (this.series.id || '')
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
      handleSuccess(response, file) {
        this.series.image_id = response.image_id
        this.currentImage = response
      },
      beforeUpload(file) {
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return isLt2M;
      },
    }
  }
</script>

<style lang="scss">
  .wrapper {
    padding: 20px;
  }
  .image-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .image-uploader .el-upload:hover {
    border-color: #20a0ff;
  }
  .image-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .image {
    max-width: 280px;
    height: auto;
    display: block;
  }
</style>
