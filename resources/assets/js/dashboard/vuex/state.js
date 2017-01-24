// https://vuex.vuejs.org/en/state.html
import { default as entrypoints } from '../entrypoints'

export default {
  messages: {
    success: '',
    error: [],
    warning: '',
    validation: {},
  },
  entrypoints: entrypoints,
  fetching: false,
}
