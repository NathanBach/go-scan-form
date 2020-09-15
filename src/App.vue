<template>
  <div id="app">
    <index />
  </div>
</template>

<script>
import index from './views/index'

export default {
  name: 'App',
  components: {
    index
  },
  methods: {
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
