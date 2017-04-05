<template>
  <div class="user-profile">
    <navbar></navbar>
    <div class="text-center setting-box">
      <div class="setting-items">
        <img class="avatar img-circle" width="120" height="120" :src="user.avatar">
        <a href="javascript:;" class="btn btn-outline-success file">
          <span>修改头像</span>
          <input type="file" name="avatar" @change="upload">
        </a>

        <template v-for="item in items">
          <user-item wrapper="setting-item row" :item="item" :user="user"></user-item>
        </template>

      </div>
    </div>

    <el-dialog title="裁剪头像" v-model="dialogVisible" size="tiny">
      <cropper :image="image" @canceled="onCloseForm" @succeed="succeed"></cropper>
    </el-dialog>
  </div>
</template>

<script>
import 'element-ui/lib/theme-default/dialog.css'

import Navbar from 'home/Navbar'
import ElDialog from 'element-ui/lib/dialog'
import { mapActions, mapGetters } from 'vuex'
import Cropper from '../components/Cropper'
import UserItem from '../components/UserItem'

export default {
  components: {
    Navbar,
    ElDialog,
    Cropper,
    UserItem,
  },
  data() {
    return {
      image: {},
      dialogVisible: false,
      items: [
        { label: '昵称', name: 'name', placeholder: '填写你的昵称', isEdit: false },
        { label: '个人简介', name: 'signature', placeholder: '填写你的个人简介', isEdit: false },
        { label: '邮箱', name: 'email' },
      ],
    }
  },
  computed: {
    ...mapGetters({
      user: 'currentUser'
    }),
  },
  methods: {
    ...mapActions(['loadUser']),
    upload(e) {
      let files = e.target.files
      let formData = new FormData()

      formData.append('file', files[0]);

      axios.post('/files/upload?strategy=avatar_origin', formData)
          .then((response) => {
            this.image = response.data

            this.dialogVisible = true
          })
    },
    succeed() {
      this.loadUser()

      this.dialogVisible = false
    },
    onCloseForm() {
      this.dialogVisible = false
    },
  }
}
</script>

<style lang="scss" scoped>
  .setting-items {
    padding-bottom: 60px;
    font-size: .9rem;
  }
  .setting-item {
    position: relative;
    text-align: left;
    width: 80%;
    margin: 0 auto;
    padding: 1em 0;
    border-bottom: 1px solid #f1f1f1;
  }
  .setting-box {
    max-width: 550px;
    margin: 0 auto;
    margin-top: 50px;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
  }
  .avatar {
    margin: 30px 0;
  }
  .file {
    position: relative;
    margin: 0 auto;
    display: block;
    width: 100px;
    height: 30px;
    line-height: 30px;
    font-size: 10px;

    span {
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
    }
    input {
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      width: 100px;
      height: 30px;
      opacity: 0;
    }
  }
</style>
