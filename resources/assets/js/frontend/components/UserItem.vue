<template>
  <div :class="wrapper">
    <template v-if="item.isEdit !== undefined">
      <label class="col-form-label col-3">{{ item.label }}</label>
      <div class="col-9">
        <input type="text" class="form-control" @click="editItem(item)" :value="user[item.name]" :id="item.name" :placeholder="item.placeholder" />
      </div>
      <div class="actions col-3" v-if="item.isEdit">
        <span class="save" @click="save(item)">保存</span>
        <span class="cancel" @click="cancel(item)">取消</span>
      </div>
      <div class="actions col-3" v-else><i class="material-icons" @click="edit(item)">edit</i></div>
    </template>
    <template v-else>
      <label class="col-form-label col-3">{{ item.label }}</label>
      <div class="col-9">
        <div class="form-control" v-html="user[item.name]"></div>
      </div>
    </template>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'

  export default {
    props: {
      wrapper: {
        type: String,
        default() {
          return ''
        }
      },
      user: {
        type: Object,
        default() {
          return {}
        }
      },
      item: {
        type: Object,
        default() {
          return {}
        }
      }
    },
    methods: {
      ...mapActions(['setUser']),
      edit(item) {
        let value = $('#' + item.name).val()

        $('#' + item.name).val('').focus().val(value)

        item.isEdit = true
      },
      editItem(item) {
        item.isEdit = true
      },
      save(item) {
        let data = {
          [item.name]: $('#' + item.name).val()
        }

        this.$http.patch(this.$endpoints.me, data)
            .then((response) => {
              this.setUser(response.data.data)

              item.isEdit = false
            })
      },
      cancel(item) {
        $('#' + item.name).blur()

        item.isEdit = false
      },
    }
  }
</script>

<style lang="scss" scoped>
  .col-form-label {
    text-align: left;
  }
  .form-control {
    border: none;
    color: #909090;
    font-size: .9rem;
  }
  .form-control:focus {
    outline: none;
    color: #4a4a4a;
  }
  .actions {
    cursor: pointer;
    position: absolute;
    right: 0;
    padding: 0;
    height: 35px;
    line-height: 35px;
    text-align: center;

    i {
      width: 14px;
      text-align: center;
    }
    .save {
      margin-right: .5em;
    }
    span {
      cursor: pointer;
    }
  }
</style>
