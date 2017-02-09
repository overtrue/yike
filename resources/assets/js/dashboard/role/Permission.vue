<template>
  <div class="permission-form">
    <el-checkbox-group v-model="checkedPremission" @change="handleCheckedChange">
      <el-checkbox v-for="permission in permissions" :label="permission.id">{{ permission.display_name }}</el-checkbox>
    </el-checkbox-group>
  </div>
</template>

<script>
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
      permissions: {
        type: Array,
        default() {
          return []
        }
      }
    },
    data() {
      return {
        checkedPremission: this.role.permissions,
      }
    },
    methods: {
      handleCheckedChange(value) {
        console.log(this.role);
        this.$http.patch(this.$store.state.entrypoints.roles + this.role.id + '/permission', { permissions: value })
            .then((response) => {
              this.$message.success('权限修改成功')
            })
      }
    }
  }
</script>
