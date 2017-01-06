// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/import
import state from './state'
import mutations from './mutations'
import plugin from './plugin'
import * as actions from './actions'
import * as getters from './getters'

export default {
    module: {
        state,
        mutations,
        actions,
        getters
    },
    plugin
}
