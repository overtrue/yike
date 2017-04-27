<template>
  <modal class="report-rule" :show="true" v-if="show" @cancel="cancel">
    <span slot="header">举报</span>
    <ul class="rule-list" slot="body">
      <li v-for="(item, index) in list" @click="selectRule(index)">
        {{ item }}
        <i class="material-icons float-right" v-if="rule.id == index && !checkChildren(index)">done</i>
        <i v-if="checkChildren(index)" class="material-icons float-right">keyboard_arrow_right</i>
      </li>
    </ul>
    <div class="buttons" slot="footer">
      <a href="javascript:void(0);" class="btn" v-if="type == 'children'" @click="reset">返回</a>
      <button type="button" class="btn btn-success" @click="report" :disabled="!canSumit">举报</button>
    </div>
  </modal>
</template>

<script>
import Modal from 'home/Modal'
import { mapGetters } from 'vuex'

export default {
  components: { Modal },
  props: {
    show: { type: Boolean, default: false },
    item: { type: Object },
    api: { type: String, default: '' },
    rules: {
      type: Object,
      default() {
        return {}
      }
    }
  },
  data() {
    return {
      type: 'main',
      reason: '',
      rule: {
        id: 0
      },
      parentListId: 1000,
      checkSelected: false,
      list: this.rules[1000],
    };
  },
  computed: {
    ...mapGetters(['isLogged']),
    canSumit() {
      return this.checkSelected
    },
  },
  methods: {
    selectRule(key) {
      this.rule.id = (this.rule.id == key) ? 0 : key

      if (this.checkChildren(key)) {
        this.checkSelected = false
        this.parentListId = key
        this.list = this.rules[key]
        this.type = 'children'
        this.reason = ''
      } else {
        this.checkSelected = (this.rule.id == key) ? true : false
        this.reason = (this.rule.id == key) ? this.list[key] : ''
      }
    },
    checkChildren(key) {
      return this.rules[key] != undefined ? true : false
    },
    reset() {
      let parentId = this.getParentList(this.parentListId)
      this.list = this.rules[parentId]
      this.parentListId = parentId
      if (parentId == 1000) {
        this.type = 'main'
      }
      this.checkSelected = false
      this.reason = ''
    },
    cancel () {
        this.$emit('cancel');
    },
    report() {
      if (!this.isLogged) {
        return this.$router.push({name: 'auth.signin', query: { redirect: window.location.href }})
      }

      let url = this.api + this.item.id + '/reports'

      this.$http.post(url, { reason: this.reason })
          .then((response) => this.cancel())
    },
    getParentList(code) {
      let ids = code.split('')
      let lastCode = ids.pop()
      if (lastCode == 0) {
        return this.getParentList(ids.join(''))
      } else {
        let listIds = code.split('')
        listIds.pop()
        let parentId = listIds.join('')
        return this.pad(parentId, 4)
      }
    },
    pad(num, n) {
      let length = num.toString().length;
      while(length < n) {
        num = num + "0";
        length++;
      }
      return num;
    }
  },
};
</script>

<style lang="scss">
.report-rule {
  .modal-body {
    padding: 0 !important;

    .rule-list {
      padding: 0;
      margin: 0;
      list-style: none;

      li {
        padding: 10px 20px;
        cursor: pointer;

        &:hover {
          background-color: #f3f5f7;
        }
      }
    }
  }
}
</style>
