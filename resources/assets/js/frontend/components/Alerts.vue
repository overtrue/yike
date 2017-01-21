
<script>
  import { mapState, mapActions } from 'vuex'
  import { isEmpty } from 'lodash'

  export default {
    computed: {
      ...mapState(['messages']),
      hasSuccessMessage() {
        if (this.messages.success !== '') {
          this.$message.success(this.messages.success)
        }
        return false;
      },
      hasErrorMessages() {
        if (this.messages.error.length > 0) {
          this.$message.error(this.messages.error.join('\n'))
        }

        return false
      },
      hasValidationMessages() {
        if (!isEmpty(this.messages.validation)) {
          this.$message.error(this.messages.validation.join('\n'))
        }
        return false;
      },
    },
    methods: {
      ...mapActions(['setMessage']),
      dismiss(type) {
        let obj
        if (type === 'error') {
          obj = { type, message: [] }
        } else if (type === 'validation') {
          obj = { type, message: {} }
        } else {
          obj = { type, message: '' }
        }
        this.setMessage(obj)
      },
    },
  }
</script>

<template>
  <div>
    <div v-if="hasSuccessMessage"></div>
    <div v-if="hasErrorMessages"></div>
    <div v-if="hasValidationMessages"></div>
  </div>
</template>
