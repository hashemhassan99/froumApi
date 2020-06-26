import Vue from 'vue'
import Vuex from 'vuex'
import auth from './moduels/auth'
import forum from './moduels/forum'

Vue.use(Vuex)


export default new Vuex.Store({
    modules: {
        auth,
        forum
    }
})

