<!-- fieldAwesome.vue -->
<template>
  <select :name="schema.inputName">
    <option value=""></option>
  </select>
</template>

<script>
import { abstractField } from "vue-form-generator";

export default {
  mixins: [abstractField],
};
</script>