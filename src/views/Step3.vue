<template>
  <div>
    <section class="step3">
        <p class="instructions step3-instruction">Cras eget metus tempus, molestie lacus id, commodo mi.</p>
        <ul class="step3-information">
          <li v-for="(item, index) in this.$store.state.agreements" :key="index">{{ item.title }}</li>
        </ul>
    </section>
    <button class="step-button step4-button" @click="goToStep">Step 4</button>
  </div>
</template>

<script>
export default {
  data () {
    return {
      name: 'Step 3',
      agreementsList: [
        {
          id: 1,
          title: 'Nam eu efficitur tortor. Donec placerat sem tortor, ut mollis augue scelerisque vitae.'
        },
        {
          id: 2,
          title: 'Vivamus interdum tincidunt luctus. Etiam facilisis congue odio, ultrices consequat ante consectetur quis.'
        },
        {
          id: 3,
          title: 'Quisque vel metus congue, imperdiet felis sit amet, aliquet ipsum.'
        },
        {
          id: 4,
          title: 'Aliquam eleifend diam ac purus suscipit lobortis. Donec non dui erat. Cras ut ipsum quis urna bibendum feugiat.'
        }
      ]
    }
  },
  methods: {
    init () {
      var self = this
      var procedures = JSON.parse(JSON.stringify(self.$store.state.procedures))
      self.agreementsFiltered = self.agreementsList.filter(function (item) {
        return procedures.indexOf(item.id) !== -1
      })
      self.$store.dispatch('listAgreements', self.agreementsFiltered)
    },
    goToStep () {
      this.$emit('goToStep', 'Step 4')
    }
  },
  mounted () {
    this.init()
  }
}
</script>

<style lang='scss' scoped>
.step3 {
  padding-bottom: 30px;
}

.step3-instruction {
  padding-bottom: 28px;
}

.step3-information {
  text-align: left;
  border: 1px solid #000;
  padding-left: 40px;
  padding-top: 5px;
  padding-bottom: 5px;
  margin: 0;
}

.step3-information li {
  display: flex;
  align-items: center;
}

.step3-information li:before {
  content: '\25AA';
  color: #000;
  font-size: 40px;
}

.step4-button {
  position: absolute;
  right: 18px;
}
</style>
