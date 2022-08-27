<template>

  <table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
      <th class="bg-primary text-light" v-for="column in columns" :key="column.name">
        {{ column.label }}
      </th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="row in rows" :key="row.primary_key">
      <td v-for="column in columns" :key="column.name">
        {{ row[column.name] }}
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "TableStructure",
  props: {
    columns: {
      type: [Array, Object],
      required: true
    },
    rows: {
      type: [Array, Object],
      required: true
    }
  },
  mounted() {
    console.log(this.columns)
    console.log(this.rows)
  }
}
</script>

<style scoped>

</style>