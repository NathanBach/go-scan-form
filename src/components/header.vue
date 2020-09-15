<template>
  <div>
    <header>
      <div class="wrapper">
          <h1>SWT033</h1>
          <button
            v-if="stepName !== 'Welcome'"
            @click="showConfirm"
            class="close-button"
          >
            &times; {{ $t('close') }}
          </button>
        </div>
        <h2 class="stepName">{{ stepName }}</h2>
    </header>
    <section>
      <div v-if="togglePopup">

        <transition name="modal">
          <div class="modal-mask">
            <div class="modal-wrapper">
              <div class="modal-container">

                <div class="modal-body">
                  <slot name="body">
                    <p>{{$t('modal.procedureConfirm')}}</p>
                  </slot>
                </div>

                <div class="modal-footer">
                  <slot name="footer">
                    <div class="header-buttons">
                      <button class="step-button step-button-header" @click="quit">{{ $t('yes') }}</button>
                      <button class="step-button step-button-header" @click="cancelQuit">{{ $t('no') }}</button>
                    </div>
                  </slot>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Header',
  data () {
    return {
      togglePopup: false,
      stepNamePage: null,
      stepIndexPage: 0
    }
  },
  props: {
    stepName: {
      type: String
    },
    stepIndex: {
      type: Number
    }
  },
  methods: {
    init () {
      this.stepNamePage = this.stepName
      this.stepIndexPage = this.stepIndex
    },
    showConfirm () {
      this.togglePopup = true
    },
    cancelQuit () {
      this.togglePopup = false
    },
    quit () {
      this.clean()
      this.stepIndexPage = 0
      this.togglePopup = false
      this.stepNamePage = null
      this.stepIndexPage = 0
      this.stepNamePage = this.stepName
      this.stepIndexPage = this.stepIndex
      this.$emit('quit', 'Welcome')
    },
    clean () {
      this.$emit.radio = null
      this.$store.dispatch('resetData')
    }
  },
  mounted () {
    this.init()

    document.onkeydown = evt => {
      evt = evt || window.event;
      if (evt.keyCode == 27 && this.togglePopup) {
        this.cancelQuit()
      }
    }
  }
}
</script>

<style lang="sass" scoped>
header
  background: #fff

.wrapper
  display: flex
  justify-content: space-between

h1 
  text-align: left
  color: rgb(144, 144, 144)
  font-size: 30px
  padding: 10px 0 0

.header-buttons
  display: flex
  justify-content: space-around

.stepName 
  color: #fff
  background-color: rgb(-0, 147, 118)
  padding: 20px
  font-size: 24px
  font-weight: bold

.modal-mask 
  position: fixed
  z-index: 9998
  top: 0
  left: 0
  width: 100%
  height: 100%
  background-color: rgba(0, 0, 0, 0.5)
  display: table
  transition: opacity 0.3s ease

.modal-wrapper 
  display: table-cell
  vertical-align: middle

.modal-container 
  width: 300px
  margin: 0px auto
  padding: 20px 30px
  background-color: #fff
  border-radius: 2px
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33)
  transition: all 0.3s ease
  font-family: Helvetica, Arial, sans-serif

</style>
