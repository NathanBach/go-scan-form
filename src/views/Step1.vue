<template>
  <div>
    <section>
      <div class="wrapper">
        <p class="instructions step1-instruction">
          Lorem ipsum dolor sit amet.
        </p>
        <div class="step1-button">
          <button class="step-button" @click="select('Quisque')">Quisque</button>
          <button class="step-button" @click="select('Maecenas')">Maecenas</button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  data () {
    return {
      props: {
        counter: {
          type: String
        }
      }
    }
  },
  methods: {
    select (counter) {
      this.$store.dispatch('getCounterSelect', counter)
      this.$emit('goToStep', 'Step 2')
    }
  }
}
</script>

<style lang='scss' scoped>
.step1-instruction {
  padding-bottom: 28px;
}

.step1-button {
  margin-left: 10px;
}
</style>
