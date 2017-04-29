<template>
  <div class="feedback">
    <a href="javascript:void(0);" class="feedback-button" @click.prevent="visible=true">
      <i class="material-icons">feedback</i>
    </a>

    <modal :show="visible" @cancel="onCancel">
      <span slot="header">提交反馈</span>
      <template slot="body">
        <textarea class="feedback-content" rows="5" v-model="feedback.content" placeholder="告诉我们你的建议或遇到的问题。"></textarea>
      </template>
      <div class="buttons" slot="footer">
        <button type="button" class="btn btn-info" :disabled="busying" @click.prevent="onSubmit">提交</button>
      </div>
    </modal>
  </div>
</template>

<script>
import Modal from "home/Modal"

export default {
  components: { Modal },
  data() {
    return {
      visible: false,
      busying: false,
      feedback: {
        content: ''
      },
    }
  },
  methods: {
    onCancel() {
      this.visible = false
      this.feedback.content = ''
    },
    onSubmit() {
      if(this.feedback.content == '') {
        this.$message.error('反馈内容不能为空')
        return
      }

      this.busying = true
      this.$http.post(this.$endpoints.feedback, this.feedback)
          .then(({ data }) => {
            this.$message.success('反馈成功')
            this.feedback.content = ''
            this.busying = false
            this.onCancel()
          }).catch((response) => {
            this.busying = false
            console.log(response)
          })
    },
  }
}
</script>

<style lang="scss" scoped>
.feedback-button {
  position: fixed;
  bottom: 70px;
  right: 30px;
  width: 38px;
  height: 38px;
  line-height: 38px;
  font-size: 1em;
  background-color: #dce7f4;
  color: #fff;
  text-align: center;
  border-radius: 50%;
  cursor: pointer;
  z-index: 1000000;

  &:hover {
    background-color: #bfcbd9;
  }
}
.feedback-content {
  width: 100%;
  border: none;
  resize: none;
  outline: none;
}
</style>
