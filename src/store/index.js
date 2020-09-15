import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    counterSelect: '',
    procedures: [],
    agreements: [],
    // userData: { "version": "1", "move_date": "20201228", "create_deman_date": "20200726114134", "device_id": "0000", "language": "0", "demander_name": { "lastname": "Bach", "firstname": "Nhan" }, "demander_name_kata": { "lastname": "トウキョウ", "firstname": "タロウ" }, "company_name": "Fastcoding Vietnam", "create_phone_number": "0312392832", "temp_re_entry": "1", "create_re_counter": "都民の声窓口/食堂/政策企画局 総務部/その他 Other de", "people": { "person1": { "lastname": "山田1", "firstname": "" }, "person2": { "lastname": "山田2", "firstname": "" }, "person3": { "lastname": "山田3", "firstname": "" }, "person4": { "lastname": "山田4", "firstname": "" }, "person5": { "lastname": "山田5", "firstname": "" }, "person6": { "lastname": "山田6", "firstname": "\u0002\u0002" } } },
    userData: {},
    destinationChecks: {
      destinationCheck1: '都民情報ルーム',
      destinationCheck2: '都民の声窓口',
      destinationCheck3: '不動産業課',
      destinationCheck4: '市街地建築部',
      destinationCheck5: '食堂',
      destinationCheck6: '会議室'
    }
  },
  mutations: {
    SET_COUNTER_SELECT (state, counter) {
      state.counterSelect = counter
    },
    SET_ADD_PROCEDURE (state, id) {
      state.procedures.push(id)
    },
    SET_REMOVE_PROCEDURE (state, id) {
      var index = state.procedures.indexOf(id)
      state.procedures.splice(index, 1)
    },
    LIST_AGREEMENTS (state, item) {
      state.agreements = item
    },
    CLEAN_DATA (state) {
      state.counterSelect = ''
      state.procedures = []
      state.agreements = []
      state.userData = {}
    },
    SET_USER_DATA(state, data) {
      state.userData = data
    }
  },
  actions: {
    getCounterSelect ({ commit }, counter) {
      commit('SET_COUNTER_SELECT', counter)
    },
    getAddProcedure ({ commit }, id) {
      commit('SET_ADD_PROCEDURE', id)
    },
    getRemoveProcedure ({ commit }, id) {
      commit('SET_REMOVE_PROCEDURE', id)
    },
    listAgreements ({ commit }, agreementsFiltered) {
      commit('LIST_AGREEMENTS', agreementsFiltered)
    },
    resetData ({ commit }) {
      commit('CLEAN_DATA')
    },
    setUserData ({ commit }, data) {
      commit('SET_USER_DATA', data)
    }
  },
  modules: {}
})
