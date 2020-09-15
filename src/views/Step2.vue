<template>
  <div>
    <section class="step2">
      <p class="instructions step2-instruction">Ut aliquet sapien nec felis blandit egestas. </p>
      <table class="procedures-list">
        <tr v-for="(item, index) in procedures" :key="index">
          <th>
            <label class="destinations-list"><input type="checkbox" @change="selectProcedure(item)" value="item.id"><span>{{ item.title }}</span></label>
          </th>
          <td>
            <p>Aenean aliquet augue sed orci accumsan accumsan.</p>
          </td>
        </tr>
      </table>
    <button class="step-button step2-button" @click="goToStep">Step 3</button>
    </section>
  </div>
</template>

<script>
export default {
  data () {
    return {
      name: 'Step 2',
      props: {
        procedures: {
          type: []
        }
      },
      procedures: [
        {
          id: 1,
          title: 'Nunc ac euismod quam. ',
          completed: false
        },
        {
          id: 2,
          title: 'Sed a malesuada neque. ',
          completed: false
        },
        {
          id: 3,
          title: 'Aliquam erat volutpat. ',
          completed: false
        },
        {
          id: 4,
          title: 'Donec in lobortis dolor. ',
          completed: false
        }
      ]
    }
  },
  methods: {
    selectProcedure (item) {
      item.completed = !item.completed
      if (item.completed) {
        this.$store.dispatch('getAddProcedure', item.id)
      } else {
        this.$store.dispatch('getRemoveProcedure', item.id)
      }
    },
    goToStep () {
      this.$emit('goToStep', 'Step 3')
    }
  }
}
</script>

<style lang="scss" scoped>
.procedures-list {
  width: 100%;
  margin-bottom: 40px;
}
.procedures-list th,
.procedures-list td {
  border: 1px solid #3c8a71;
  padding: 10px;
  text-align: left;
  color: #3c8a71;
  vertical-align: top;
}
.procedures-list th {
  width: 280px;
}
.step2-button {
  position: absolute;
  right: 18px;
  margin-top: 50px;
}

@media only screen and (max-width: 767px) {
  .procedures-list th {
    width: 40%;
  }
  .procedures-list th,
  .procedures-list td {
    font-size: 14px;
  }
}
</style>