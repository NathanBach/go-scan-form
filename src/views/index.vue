<template>
  <div id="app">
    <Header
      :stepIndex="currentStep.stepIndex"
      :stepName="currentStep.stepName"
      @quit="backHomeButton($event)"
    />
    <div class="wrapper">
      <div v-if="currentStep.stepName == 'Welcome'">
        <section class="instructions main-page-instruction">
          <p>
            Maecenas mattis ante ex, a gravida orci aliquam eleifend.
          </p>
          <p>
            Praesent posuere risus et sodales mollis. Duis sit amet feugiat
            turpis.
          </p>
        </section>
        <button class="step1" @click="currentStep.stepName = 'Step 1'">
          Step 1
        </button>
      </div>

      <div v-if="currentStep.stepName == 'Step 1'">
        <Step1 @goToStep="goToStep2" />
      </div>

      <div v-if="currentStep.stepName == 'Step 2'">
        <Step2 @goToStep="goToStep3" />
      </div>

      <div v-if="currentStep.stepName == 'Step 3'">
        <Step3 @goToStep="goToStep4" />
      </div>

      <div v-if="currentStep.stepName == 'Step 4'">
        <Step4 @goToStep="QRScan" @goToForm="Form" />
      </div>

      <div v-if="currentStep.stepName == 'QRScan'">
        <QRScan @goToForm="Form" />
      </div>

      <div v-if="currentStep.stepName == 'Form'">
        <Form @goToConfirm="Confirm" @getModel="getModel" />
      </div>

      <div v-if="currentStep.stepName == 'Confirm'">
        <Confirm :model="model" @goToComplete = "Complete" />
      </div>

      <div v-if="currentStep.stepName == 'Complete'">
        <Complete :model="model" @Close="backHomeButton($event)" />
      </div>
    </div>
  </div>
</template>

<script>
import Header from '@/components/header.vue'
import Step1 from '@/views/Step1.vue'
import Step2 from '@/views/Step2.vue'
import Step3 from '@/views/Step3.vue'
import Step4 from '@/views/Step4.vue'
import QRScan from '@/views/QR-Reader.vue'
import Form from '@/views/Form.vue'
import Confirm from '@/views/Confirm.vue'
import Complete from '@/views/Complete.vue'


export default {
  data () {
    return {
      currentStep: {
        stepName: 'Step 4',
        stepIndex: 4
      },
      model: {}
    }
  },
  components: {
    Header,
    Step1,
    Step2,
    Step3,
    Step4,
    QRScan,
    Form,
    Confirm,
    Complete
  },

  procedures: {
    type: String
  },

  agreements: {
    type: Array
  },
  name: 'index',
  methods: {
    backHomeButton (event) {
      this.currentStep.stepName = event
    },
    goToStep2 (step) {
      this.currentStep.stepName = step
    },

    goToStep3 (step) {
      this.currentStep.stepName = step
    },

    goToStep4 (step) {
      this.currentStep.stepName = step
    },
    QRScan (step) {
      this.currentStep.stepName = step
    },
    Form (step) {
      this.currentStep.stepName = step
    },
    Confirm (step) {
      this.currentStep.stepName = step
    },
    Complete (step) {
      this.currentStep.stepName = step
    },
    getModel (model) {
      var self = this
      self.model = model
      // console.log(model)
    }
  }
}
</script>

<style lang="scss">

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed,
figure, figcaption, footer, header, hgroup,
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
margin: 0;
padding: 0;
border: 0;
font-size: 100%;
font: inherit;
vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure,
footer, header, hgroup, menu, nav, section {
display: block;
}
body {
line-height: 1;
}
ol, ul {
list-style: none;
}
blockquote, q {
quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
content: '';
content: none;
}
table {
border-collapse: collapse;
border-spacing: 0;
}

.main-page-instruction {
  padding-bottom: 30px;
}

.instructions {
  text-align: left;
  margin: 0;
  font-size: 20px;
  padding-top: 20px;
}

.step1 {
  outline: none;
  display: inline-block;
  width: 130px;
  padding: 14px;
  border-radius: 12px;
  font-size: 30px;
  color: #fff;
  background-color: rgb(-0, 147, 118);
}

.step-button {
  display: block;
  margin-bottom: 10px;
  text-align: center;
  font-size: 30px;
  width: 320px;
  color: #fff;
  background-color: rgb(-0, 147, 118);
  border-radius: 5px;
}

.step-button-header {
  width: 40%;
  display: flex;
  justify-content: space-around;
  font-size: 24px;
}
</style>
