<template>
  <div>
    <div class="instructions qr-instruction">
      <p>Duis non ante quis ipsum commodo fringilla ut vel lacus. Quisque venenatis viverra tristique.</p>
      <p>Mauris varius magna eu interdum tristique.</p>
    </div>
    <div class="qr-info">
      <p class="note">Nam eget metus ut ex porta mattis. Donec venenatis ultrices porttitor. <br>Etiam id erat eu felis consectetur</p>
    </div>
    <div class="step4-button">
      <button class="step-button" @click='goToStep'>QR Reader</button>
      <button class="step-button" @click='goToForm'>Form</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: 'Step 4',
    }
  },
  methods: {
    goToStep () {
      this.$emit('goToStep', 'QRScan')
    },
    goToForm () {
      this.$emit('goToForm', 'Form')
    }
  }
}
</script>

<style lang="scss" scoped>
.qr-info {
  font-size: 20px;
  background-color: rgb(255, 255, 231);
  border: 1px solid rgb(-0, 147, 118);
  padding: 10px;
  text-align: left;
}

.qr-info .note:before {
  content: "\203B";
  position: absolute;
  left: 10px;
  top: 0
}

.qr-info .note {
  position: relative;
  padding-left: 22px;
}

.qr-instruction {
  padding-bottom: 30px;
}

.step4-button {
  display: flex;
  justify-content: space-evenly;
  position: relative;
  top: 400px;
}
</style>
