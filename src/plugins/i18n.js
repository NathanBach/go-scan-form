import Vue from 'vue'
import VueI18n from 'vue-i18n'
import ja from '../languages/ja.json'
import en from '../languages/en.json'

Vue.use(VueI18n)

const messages = {
  'ja': ja,
  'en': en
}

const i18n = new VueI18n({
  locale: 'ja',
  fallbackLocale: 'ja',
  messages
})

export default i18n